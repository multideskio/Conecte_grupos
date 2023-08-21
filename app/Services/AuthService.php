<?php

namespace App\Services;

use App\Models\CompanyModel;
use App\Models\PlanModel;
use App\Models\SuperModel;
use App\Models\UserModel;

class AuthService
{
    protected $inputs;
    protected $userModel;

    public function __construct($inputs, UserModel $userModel)
    {
        $this->inputs = $inputs;
        $this->userModel = $userModel;
        helper('response');
    }

    public function authenticate()
    {
        // Verificar se os campos foram preenchidos
        if (empty($this->inputs['username'])) {
            throw new \Exception(lang('General.errosLogin.notEmail'));
        }

        if (empty($this->inputs['password'])) {
            throw new \Exception(lang('General.errosLogin.notPassword'));
        }

        $email    = $this->inputs['username'];
        $password = $this->inputs['password'];
        $remember = !empty($this->inputs['remember']) ? 1 : 0;

        // Buscar usuário pelo email
        $user = $this->userModel->where('email', $email)->first();

        if (!$user) {
            throw new \Exception(lang('General.errosLogin.errorEmail'));
        }

        // Comparar a senha usando o hash armazenado no banco de dados
        if (!password_verify($password, $user['password'])) {
            throw new \Exception(lang('General.errosLogin.errorPassword'));
        }

        if ($remember) {
            // Configurar cookies para login automático
            set_cookie('user_email', $email, 60 * 60 * 24 * 30);
            set_cookie('user_token', password_hash($user['token'], PASSWORD_BCRYPT), 60 * 60 * 24 * 30);
            set_cookie('user_auto', $remember, 60 * 60 * 24 * 30);
        } else {
            // Remover cookies de login automático
            delete_cookie('user_email');
            delete_cookie('user_token');
            delete_cookie('user_auto');
        }

        $verifyPlan = $this->verifyPlan($user['id_company']);
        //Retorna dados do super admin
        $mCompany = new CompanyModel();
        $id = $mCompany->select('id_admin')->find($user['id_company']);
        // Preparar dados para a sessão
        $dataSession = [
            'isConnected' => true,
            'id' => intval($user['id']),
            'company' => intval($user['id_company']),
            'name' => $user['name'],
            'fone' => $user['wa_number'],
            'email' => $user['email'],
            'permission' => intval($user['permission']),
            'status' => intval($user['status']),
            'image' => $user['image'] ?: null,
            'control' => $id['id_admin'],
            'daysRemaining' => $verifyPlan
        ];

        // Gravar dados na sessão
        session()->set(['user' => $dataSession]);

        // Autenticação bem-sucedida
        return true;
    }
    private function verifyPlan($company)
    {
        $mPlan = new PlanModel();

        $build   = $mPlan->where('id_company', $company)->findAll();

        if (count($build) == 0) {
            throw new \Exception(lang('Validation.plan.0'));
        }

        if (count($build) > 1) {
            throw new \Exception(lang('Validation.plan.1', ['idCompany' => $company]));
        }

        $row = $build[0];

        // Exemplo de uso
        $dataCompra = $row['payday'];
        $diasParaAdicionar = $row['valid_days'];

        /*session()->set(['user' => [
            'vencimento' => add_days_to_purchase_date($dataCompra, $diasParaAdicionar),
        ]]);*/
        
        $dataValidade = add_days_to_purchase_date($dataCompra, $diasParaAdicionar);
        
        if (is_plan_expired($dataValidade)) {
            throw new \Exception(lang('Validation.plan.vencido.0'));
        }
        
        return days_until_expiry($dataValidade);
    }
    
    public function createAccount()
    {
    }
}
