<?php

namespace App\Services;

use App\Libraries\instances_libraries;
use App\Models\CompanyModel;
use App\Models\SuperModel;
use App\Models\UserModel;

class AuthServiceChatwoot
{
    protected $mCompany;
    protected $mUsers;
    protected $mSuper;

    public function __construct(CompanyModel $mCompany, UserModel $mUsers)
    {
        $this->mCompany = $mCompany;
        $this->mUsers = $mUsers;
    }

    public function authenticate($id_chatwoot, $apiDashboard)
    {

        $findCompany = $this->mCompany->select('id, company, id_admin')
            ->where([
                'id_chatwoot' => $id_chatwoot,
                'api_key_chatwoot' => $apiDashboard
            ])
            ->first();

        if (!$findCompany) {
            throw new \Exception('Unauthorized access: Company not found');
        }


        $verificaUsuario = $this->mUsers->select('id, name, email')
            ->where(['id_company' => $findCompany['id'], 'permission' => 2])
            ->orWhere(['id_company' => $findCompany['id'], 'permission' => 3])
            ->first();

        if (!$verificaUsuario) {
            throw new \Exception('Unauthorized access: Company not found');
        }

        session()->set([
            "user" => [
                'isConnectedChatwoot' => true,
                'name'     => $verificaUsuario['name'],
                'email'    => $verificaUsuario['email'],
                'id'       => intval($verificaUsuario['id']),
                'admin'    => intval($findCompany),
                'company'  => $findCompany
            ]
        ]);

        $mAdmin = new SuperModel();
        $dadosAdmin = $mAdmin->find(session('user')['admin']);
        $instances = new instances_libraries($dadosAdmin['url_api_wa'], $dadosAdmin['api_key_wa']);
        $instances->import();

        return session('user');
    }
}
