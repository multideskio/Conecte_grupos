<?php

namespace App\Services;

use App\Models\CompanyModel;
use App\Models\UserModel;

class AuthServiceChatwoot
{
    protected $mCompany;
    protected $mUsers;

    public function __construct(CompanyModel $mCompany, UserModel $mUsers)
    {
        $this->mCompany = $mCompany;
        $this->mUsers = $mUsers;
    }

    /**
     * Autentica um usuário com base nas credenciais fornecidas.
     *
     * @param string $id_chatwoot
     * @param string $apiDashboard
     * @return array|string
     */
    public function authenticate($id_chatwoot, $apiDashboard)
    {
        try {
            // Encontra a empresa com base nas credenciais fornecidas
            $company = $this->findCompany($id_chatwoot, $apiDashboard);

            if ($company) {
                // Encontra um usuário autorizado na empresa
                $user = $this->findAuthorizedUser($company['id']);

                if ($user) {
                    // Configura a sessão do usuário
                    $this->setUserSession($user, $company['company'], $company['id_admin']);
                    return session('user');
                }

                throw new \Exception('Unauthorized access: User not found');
            } else {
                throw new \Exception('Unauthorized access: Company not found');
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Encontra a empresa com base nas credenciais fornecidas.
     *
     * @param string $id_chatwoot
     * @param string $apiDashboard
     * @return array|null
     */
    protected function findCompany($id_chatwoot, $apiDashboard)
    {
        return $this->mCompany->select('id, company', 'id_admin')
            ->where('id_chatwoot', $id_chatwoot)
            ->where('api_key_chatwoot', $apiDashboard)
            ->first();
    }

    /**
     * Encontra um usuário autorizado na empresa.
     *
     * @param int $companyId
     * @return array|null
     */
    protected function findAuthorizedUser($companyId)
    {
        return $this->mUsers->select('id, name, email')
            ->where(['id_company' => $companyId, 'permission' => 2])
            ->orWhere(['id_company' => $companyId, 'permission' => 3])
            ->first(); // Verifique se a consulta aqui retorna apenas um usuário
    }

    /**
     * Configura a sessão do usuário.
     *
     * @param array $userData
     * @param string $companyName
     * @return void
     */
    protected function setUserSession($userData, $companyName, $admin)
    {
        session()->set([
            "user" => [
                'isConnectedChatwoot' => true,
                'name' => $userData['name'],
                'email' => $userData['email'],
                'id' => intval($userData['id']),
                'admin' => intval($admin),
                'company' => $companyName
            ]
        ]);
    }
}
