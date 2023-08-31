<?php

namespace App\Database\Seeds;

use App\Models\CompanyModel;
use App\Models\PlanModel;
use App\Models\SuperModel;
use App\Models\UserModel;
use CodeIgniter\Database\Seeder;

class SuperAdmin extends Seeder
{
    public function run()
    {
        //
        helper('response');

        $sData = [
            'name' => 'MultiDesk',
            'url_api_wa' => 'https://v5.multidesk.io',
            'api_key_wa' => 'B6D711FCDE4D4FD5936544120E713976'
        ];
        $mSuper = new SuperModel();
        $idSuper = $mSuper->insert($sData);

        echo "Super criado! \n";
        //
        $cData = [
            'id_admin' => $idSuper,
            'name' => 'Paulo Henrique',
            'company' => 'MultiDesk',
            'email' => 'igrsysten@gmail.com',
        ];
        $mCompany = new CompanyModel();
        $idCompany = $mCompany->insert($cData);
        echo "Company criado!\n";
        //
        $uData = [
            [
                'id_company' => $idCompany,
                'name' => 'Paulo Henrique',
                'wa_number' => '5562981154120',
                'email' => 'contato@multidesk.io',
                'level' => 'superadmin',
                'permission' => 1,
                'status' => true,
                'password' => password_hash('mudar@123', PASSWORD_BCRYPT),
                'token' => randomSerial()
            ],
            [
                'id_company' => $idCompany,
                'name' => 'Paulo Henrique',
                'wa_number' => '5562981154120',
                'email' => 'igrsysten@gmail.com',
                'level' => 'admin',
                'permission' => 2,
                'status' => true,
                'password' => password_hash('mudar@123', PASSWORD_BCRYPT),
                'token' => randomSerial()
            ],
        ];

        $mUser = new UserModel();
        $mUser->insertBatch($uData);
        echo "Users Criados!\n";


        $pData = [
            'id_company' => $idCompany,
            'id_user' => 1,
            'num_instance' => 3,
            'valid_days' => 365,
            'payday' => date('Y-m-d'),
            'price' => 0,
            'status' => true,
            'size_files' => 200
        ];

        $mPlan = new PlanModel();
        $mPlan->insert($pData);
        echo "Plano criado!\n\n";


        echo "Todas as ações foram realizadas com sucesso! \n";
    }
}
