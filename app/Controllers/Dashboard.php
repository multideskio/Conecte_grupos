<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function __construct()
    {
        helper(['response', 'text', 'inflector']);
    }
    
    public function index()
    {
        //
        $dv['title'] = 'Dashboard';
        return view('admin/dashboard/home', $dv);
    }
    
    public function campaigns()
    {
        //
        $dv['title'] = 'Campaigns';
        return view('admin/campaigns/home', $dv);
    }

    public function instance()
    {
        //
        $dv['title'] = 'Instance';
        return view('admin/instance/home', $dv);
    }
    
    public function tasks()
    {
        //
        $dv['title'] = 'Tasks';
        return view('admin/tasks/home', $dv);
    }
    
    public function leads()
    {
        //
        $dv['title'] = 'Leads';
        return view('admin/leads/home', $dv);
    }

    public function synchronize()
    {
        //
        $dv['title'] = 'Synchronize';
        return view('admin/synchronize/home', $dv);
    }
    public function support()
    {
        //
        $dv['title'] = 'Support';
        return view('admin/support/home', $dv);
    }

    public function block(){
        if (session()->has('error')) : ?>
            <div class="alert alert-danger">
                <?php echo session('error'); ?>
            </div>
        <?php endif;
    }
}
