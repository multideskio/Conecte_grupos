<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GroupModel;
use App\Models\InstanceModel;

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

    /**
     *  VIEW DE ENVIO DE MENSAGEM DIRETA
     */

    public function sendView($instance)
    {
        //Busca instancia
        $instanceModel = new InstanceModel();
        $rowInstance   = $instanceModel->where('name', $instance)->first();
        if (!count($rowInstance)) {
            return redirect()->back();
            exit;
        }

        //busca grupos
        $groupsModel = new GroupModel();
        $rowGroup    = $groupsModel->where(['instance' => $rowInstance['id'], 'announce' => 0])->findAll();

        //
        $dv['rowGroup']    = $rowGroup;
        $dv['rowInstance'] = $rowInstance;
        $dv['title'] = 'Send Message';
        return view('admin/campaigns/send', $dv);
    }
    //











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

    public function block()
    {
        if (session()->has('error')) : ?>
            <div class="alert alert-danger">
                <?php echo session('error'); ?>
            </div>
<?php endif;
    }
}
