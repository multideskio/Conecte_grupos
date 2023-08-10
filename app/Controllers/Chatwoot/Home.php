<?php namespace App\Controllers\Chatwoot;

use App\Libraries\Groups_Libraries;

class Home extends BaseController
{

    public function index()
    {
        //
        $groups = new Groups_Libraries('https://noreply.conect.app', '9070AC39-C742-4134-87EE-03365594ABF1', 'whatsapp');
        return view('chatwoot/home', [
            'grupos' => $groups->listGroups('true')
        ]);
    }
    public function campanhas(){

        return view('chatwoot/campanhas');
    }
}
