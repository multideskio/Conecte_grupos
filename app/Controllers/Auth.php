<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    public function index()
    {
        //
    }

    public function conectcrm($idUser, $apiDashboard){
        $request = request();
        return $request->getJSON();
    }
}
