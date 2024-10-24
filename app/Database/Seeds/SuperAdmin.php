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
        /* The code snippet you provided is a part of a PHP Seeder class that is used to populate the
        database with initial data. Let's break down the code: */
        helper('response');

        $sData = [
            'name'       => 'MultiDeskIo',
            'url_api_wa' => 'https://evo2.conect.app',
            'api_key_wa' => 'yi2f32pfkwfwavcc2y9penmh2rn9tiggv07pzjkl5wyig18jmq',
        ];
        $mSuper  = new SuperModel();
        $idSuper = $mSuper->insert($sData);

        echo "Super criado! \n";
        //
        /* The code snippet you provided is creating a new company record in the database. Here's a
        breakdown of what each part of the code is doing: */
        $cData = [
            'id_admin' => $idSuper,
            'name'     => 'Paulo Henrique',
            'company'  => 'MultiDesk',
            'email'    => 'igrsysten@gmail.com',
        ];
        $mCompany  = new CompanyModel();
        $idCompany = $mCompany->insert($cData);
        echo "Company criado!\n";
        //
        /* The `` array contains two sets of data for creating user records in the database. Each
        set represents a user with specific details such as name, WhatsApp number, email, user
        level, permissions, status, hashed password, and a generated token. */
        $uData = [
            [
                'id_company' => $idCompany,
                'name'       => 'Paulo Henrique',
                'wa_number'  => '5562981154120',
                'email'      => 'contato@multidesk.io',
                'level'      => 'superadmin',
                'permission' => 1,
                'status'     => true,
                'password'   => password_hash('mudar@123', PASSWORD_BCRYPT),
                'token'      => randomSerial(),
            ],
            [
                'id_company' => $idCompany,
                'name'       => 'Paulo Henrique',
                'wa_number'  => '5562981154120',
                'email'      => 'igrsysten@gmail.com',
                'level'      => 'admin',
                'permission' => 2,
                'status'     => true,
                'password'   => password_hash('mudar@123', PASSWORD_BCRYPT),
                'token'      => randomSerial(),
            ],
        ];

        $mUser = new UserModel();
        $mUser->insertBatch($uData);
        echo "Users Criados!\n";

        /* The code snippet you provided is creating a new plan record in the database. Here's a
        breakdown of what each part of the code is doing: */
        $pData = [
            'id_company'   => $idCompany,
            'id_user'      => 1,
            'num_instance' => 3,
            'valid_days'   => 365,
            'payday'       => date('Y-m-d'),
            'price'        => 0,
            'status'       => true,
            'size_files'   => 200,
        ];

        $mPlan = new PlanModel();
        $mPlan->insert($pData);
        echo "Plano criado!\n\n";

        echo "Todas as ações foram realizadas com sucesso! \n";
    }
}