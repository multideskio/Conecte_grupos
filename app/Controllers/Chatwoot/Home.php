<?php namespace App\Controllers\Chatwoot;

use App\Libraries\Groups_Libraries;

class Home extends BaseController
{

    public function index()
    {
        //
        $groups = new Groups_Libraries('https://app.conect.app', '0F60574D-5382-456A-AA39-59382213E7C9', 'meupessoal');
        return view('chatwoot/home', [
            'grupos' => $groups->listGroups('true')
        ]);
    }
    public function campanhas(){

        return view('chatwoot/campanhas');
    }
}
