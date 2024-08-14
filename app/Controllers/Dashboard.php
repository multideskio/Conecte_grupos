<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CampaignModel;
use App\Models\FileModel;
use App\Models\GroupModel;
use App\Models\InstanceModel;
use App\Models\ParticipantModel;
use App\Models\SendModel;

class Dashboard extends BaseController
{
    protected $cache;

    public function __construct()
    {
        helper(['response', 'text', 'inflector']);
        $this->cache = service('cache');
    }

    public function index()
    {
        $participantsModel = new ParticipantModel();
        $sendsModel        = new SendModel();
        $groupsModel       = new GroupModel();
        $campanhasModel    = new CampaignModel();
        $filesModel        = new FileModel();

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

        $semRepetido = $participantsModel
            ->where('id_company', session('user')['company'])
            ->groupBy('participant')
            ->countAllResults();

        //Numero de envios
        $numSends = $sendsModel
            ->where('id_company', session('user')['company'])
            ->countAllResults();

        //Numero de disparos
        $numDisparos = $sendsModel
            ->where('id_company', session('user')['company'])
            ->groupBy('code')
            ->countAllResults();

        //Numero de arquivos no sistema
        $numArchives = $filesModel
            ->where('id_company', session('user')['company'])
            ->countAllResults();

        // Busca qtd de campanhas
        $numCampanhas = $campanhasModel
            ->where('id_company', session('user')['company'])
            ->countAllResults();

        $data['semRepetido']  = $semRepetido;
        $data['numArchives']  = $numArchives;
        $data['numDisparos']  = $numDisparos;
        $data['numCampanhas'] = $numCampanhas;
        $data['numAdmin']     = $numAdmin;
        $data['numPart']      = $numPart;
        $data['numGroup']     = $numGroups;
        $data['numSends']     = $numSends;
        $data['title']        = lang("Menu.dashboard");

        return view('admin/dashboard/home', $data);
    }

    public function createCampaigns()
    {
        //
        $data['title'] = lang("Menu.campaigns");
        return view('admin/campaigns/create', $data);
    }

    public function campaigns()
    {
        $campanhasModel = new CampaignModel();
        $filesModel     = new FileModel();

        // Busca qtd de campanhas
        $campanhas = $campanhasModel->where('id_company', session('user')['company'])->findAll();

        //

        $data['campanhas'] = $campanhas;
        $data['files']     = $filesModel;
        $data['title'] = lang("Menu.campaigns");
        return view('admin/campaigns/home', $data);
    }

    public function files()
    {
        $filesModel = new FileModel();

        $listFiles = $filesModel->where('id_company', session('user')['company'])->findAll();
        //
        $data['files'] = $listFiles;
        $data['title'] = lang('Menu.files');
        return view('admin/files/home', $data);
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
        $dv['title'] = lang("Menu.instances");
        return view('admin/instance/home', $dv);
    }

    public function tasks()
    {
        //
        $dv['title'] = lang("Menu.tasks");
        return view('admin/tasks/home', $dv);
    }

    public function leads()
    {
        //
        $dv['title'] = lang("Menu.leads");
        return view('admin/leads/home', $dv);
    }

    public function synchronize()
    {
        //
        $dv['title'] = lang("Menu.sicronization");
        return view('admin/synchronize/home', $dv);
    }
    public function participants()
    {
        //
        $dv['title'] = lang("Menu.participants");
        return view('admin/participants/home', $dv);
    }
    public function support()
    {
        //
        $dv['title'] = lang("Menu.support");
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
