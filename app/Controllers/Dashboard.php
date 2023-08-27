<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GroupModel;
use App\Models\InstanceModel;
use App\Models\ParticipantModel;
use App\Models\SendModel;

class Dashboard extends BaseController
{
    public function __construct()
    {
        helper(['response', 'text', 'inflector']);
    }

    public function index()
    {
        $participantsModel = new ParticipantModel();
        $sendsModel = new SendModel();
        $groupsModel = new GroupModel();

        // Buscando quantidade de grupos pela instância
        $numGroups = $groupsModel
            ->join('instances i', 'i.id = groups.instance')
            ->where('i.id_company', session('user')['company'])
            ->countAllResults();

        // Buscando número de administração pela instância
        $numAdmin = $participantsModel
            ->join('instances i', 'i.owner = participants.participant')
            ->whereIn('participants.admin', ['admin', 'superadmin'])
            ->where('i.id_company', session('user')['company'])
            ->countAllResults();

        // Buscando outros números
        $numPart = $participantsModel
            ->where('id_company', session('user')['company'])
            ->countAllResults();

        $numSends = $sendsModel
            ->where('id_company', session('user')['company'])
            ->countAllResults();

        $data['numAdmin'] = $numAdmin;
        $data['numPart']  = $numPart;
        $data['numGroup'] = $numGroups;
        $data['numSends'] = $numSends;
        $data['title']    = 'Dashboard';

        return view('admin/dashboard/home', $data);
    }


    public function campaigns()
    {
        //
        $dv['title'] = 'Campaigns';
        return view('admin/campaigns/home', $dv);
    }

    public function gallery()
    {
        //
        $dv['title'] = 'Synchronize';
        return view('admin/synchronize/home', $dv);
    }

    /**
     *  VIEW DE ENVIO DE MENSAGEM DIRETA
     */

    public function sendView($instance)
    {
        //Busca instancia
        $instanceModel = new InstanceModel();
        $rowInstance   = $instanceModel->where(['name' => $instance, 'id_company' => session('user')['company']])->first();
        if (!$rowInstance) {
            return redirect()->back();
            $this->session->setFlashdata('error', "Instância não definida!");
            exit;
        }
        //busca grupos
        $groupsModel = new GroupModel();
        $rowGroup    = $groupsModel->where(['instance' => $rowInstance['id']])->findAll();
        //
        $dv['rowGroup']    = $rowGroup;
        $dv['rowInstance'] = $rowInstance;
        $dv['title'] = 'Send Message';
        return view('admin/campaigns/send', $dv);
    }
    //

    public function scheduledsView($instance)
    {

        //Busca instancia
        $instanceModel = new InstanceModel();
        $rowInstance   = $instanceModel->where('name', $instance)->first();
        if (!$rowInstance) {
            return redirect()->back();
            $this->session->setFlashdata('error', "Instância não definida!");
            exit;
        }
        //busca grupos
        $groupsModel = new GroupModel();
        $rowGroup    = $groupsModel->where(['instance' => $rowInstance['id']])->findAll();

        //
        $dv['rowGroup']    = $rowGroup;
        $dv['rowInstance'] = $rowInstance;
        $dv['title'] = 'Send Message';
        return view('admin/campaigns/scheduleds', $dv);
    }

    //
    public function groupsView()
    {

        $dv['title'] = 'Groups';
        return view('admin/groups/home', $dv);
    }


    /**
     * 
     * 
     * 
     */

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
