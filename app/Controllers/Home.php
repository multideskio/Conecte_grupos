<?php

namespace App\Controllers;

use App\Libraries\Groups_Libraries;

class Home extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }

    public function groups()
    {
        $groups = new Groups_Libraries('https://app.conect.app', 'B6D711FCDE4D4FD5936544120E713976', 'watsapp_dinamus');
        return $this->response->setJSON($groups->listGroups());
    }

    public function sair(){
        session_destroy();
        $pass = password_hash('mudar@123', PASSWORD_BCRYPT);

        echo $pass;
    }
}