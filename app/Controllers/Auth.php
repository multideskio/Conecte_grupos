<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Services\AuthService;
use App\Services\InstanceService;

/**
 * CONTROLLER SEM PROTEÇÃO POR SENHA
 */
class Auth extends BaseController
{
    /**
     * ROUTE LOGIN
     */
    public function index()
    {
        //
        return view('admin/login/home');
    }

    public function signup()
    {
        return view('admin/login/signup');
    }

    /**
     * ROUTE POST LOGIN SIGNUP
     */
    public function newuser()
    {
        echo "<pre>";

        print_r($this->request->getPost());
    }

    /**
     * ROUTE POST LOGIN
     */
    public function auth()
    {
        $userModel   = new UserModel();
        $input       = $this->request->getPost();
        $authService = new AuthService($input, $userModel);
        try {
            // Tenta autenticar o usuário
            $authenticated = $authService->authenticate();
            if ($authenticated) {
                $instanceService = new InstanceService();
                $instanceService->verifyPlan();
                return redirect()->to(site_url('dashboard'));
                // Autenticação bem-sucedida
                // Redirecione o usuário para a página de sucesso ou execute outras ações necessárias
            }
        } catch (\Exception $e) {
            // Trata erros de autenticação
            $errorMessage = $e->getMessage();
            
            $this->session->setFlashdata('error', $errorMessage);
            // Redirecionar de volta para a página anterior
            return redirect()->back();
            // Exiba a mensagem de erro para o usuário ou realize outras ações necessárias
        }
    }
}
