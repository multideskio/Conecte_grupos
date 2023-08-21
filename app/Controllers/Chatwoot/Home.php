<?php namespace App\Controllers\Chatwoot;

use App\Models\InstanceModel;

class Home extends BaseController
{
    
    public function index()
    {
        //
        $mInstances = new InstanceModel();

        return view('chatwoot/dashboard/home', [
            'instances' => $mInstances->findAll()
        ]);
    }
    public function campanhas(){

        return view('chatwoot/campaigns/dashboard/home');
    }
}
