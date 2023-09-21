<?php

namespace App\Controllers\Api;

use App\Libraries\Groups_Libraries;
use App\Models\GroupModel;
use App\Models\LogsGroupsModel;
use App\Models\ParticipantModel;
use App\Models\SchedulingModel;
use App\Services\GroupService;
use App\Services\N8nService;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\I18n\Time;

class Groups extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    use ResponseTrait;

    protected $session;
    protected $cache;

    public function __construct()
    {
        //$this->session = $this->session = \Config\Services::session();
        $this->cache = \Config\Services::cache();
        helper('response');
    }

    public function index($instancia = false)
    {
        $listGroups = new GroupService('whatsapp', session('user')['company']);
        return $this->respond($listGroups->listGroups(true));
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        //
        $listGroups = new GroupService($id, session('user')['company']);

        //echo "<pre>";
        print_r($listGroups->listGroups(true));

        //return $this->respond($listGroups->listGroups(true));
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        //
        $posts = $this->request->getPost();
        $groups = new Groups_Libraries('https://noreply.conect.app', '9070AC39-C742-4134-87EE-03365594ABF1', 'whatsapp');
        $create = $groups->createGroups($posts['numbers'], $posts['name']);

        return $this->respond($create);
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        //
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        //
    }

    public function sendMessage()
    {
        $posts = $this->request->getPost();
        $groups = new Groups_Libraries($posts['apiurl'], $posts['apikey'], $posts['instance']);
        //echo getExtensionFromUrl($posts['archive']);
        //echo "<pre>"; print_r($posts);
        try {
            $sends = $groups->sendMessage($posts['groups'], $posts['message'], $posts['archive'], (isset($posts['mentions'])) ? true : false);

            //return $this->respond($sends);
            return redirect()->back();
        } catch (\Exception $e) {
            return $this->fail($e->getMessage());
        }
    }

    public function sincronize($instance = false)
    {
        $groupService = new GroupService($instance, session('user')['company']);
        try {
            $groupService->listGroups();
            return $this->respond(['msg' => 'success']);
            //return redirect()->back();
        } catch (\Exception $e) {
            return $this->fail($e->getMessage());
        }
    }

    public function scheduleds()
    {
        $posts = $this->request->getPost();

        // Verifica se o array 'groups' existe e não está vazio
        if (isset($posts['groups']) && !empty($posts['groups'])) {
            // Transforma os elementos do array em uma string separada por vírgulas
            $groupsString = implode(',', $posts['groups']);
        } else {
            $groupsString = ''; // Caso não haja grupos, a string será vazia
        }

        $dateTime = Time::createFromFormat('d/m/Y H:i', $posts['agendamento']);

        $data = [
            'id_company' => session('user')['company'],
            'id_user' => session('user')['id'],
            'id_instance' => $posts['idInstance'],
            'name' => $posts['title'],
            'message' => $posts['message'],
            'archive' => $posts['archive'] ?? null,
            'senders' => $groupsString,
            'everyone' => (isset($posts['mentions'])) ? true : false,
            'start' => $dateTime->format('Y-m-d H:i:s')
        ];


        $scheduledsModel = new SchedulingModel();
        $scheduledsModel->insert($data);


        echo "<pre>";
        print_r($data);

        print_r($posts);


        //return $this->respond($posts);
    }

    public function scheduledsn8n()
    {
        $post = $this->request->getJSON();
        try {
            $dateTime = Time::createFromFormat("Y-m-d\TH:i:s.uP", $post->time);
            $date = $dateTime->format('Y-m-d H:i:s');
            $scheduledsModel = new SchedulingModel();
            $search = $scheduledsModel
                ->where('start <', $date)
                ->where('status', false)
                ->findAll();

            if (!count($search)) {
                throw new \Exception('Nada para fazer');
            }

            foreach ($search as $list) {
                $rowSends = explode(",", $list['senders']);

                $archive = (($list['archive']) != "") ? $list['archive'] : "";

                foreach ($rowSends as $row) {
                    $data[] = [
                        'id'         => intval($list['id']),
                        'instance'   => $list['id_instance'],
                        'iduser'     => $list['id_user'],
                        'send'       => $row,
                        'message'    => str_replace("\n", "\\n", $list["message"]),
                        'archive'    => $archive,
                        'id_company' => intval($list['id_company']),
                        'everyone'   => boolval($list['everyone'])
                    ];
                }
            }

            return $this->respond($data);
        } catch (\Exception $e) {

            return $this->respondNoContent();
        }
    }

    public function scheduledsn8nsend($instance)
    {
        $sendN8n = new N8nService();
        $posts = $this->request->getVar();
        try {

            $send = $sendN8n->scheduledsSend($instance, str_replace('\\n', "\n", $posts['message']), $posts['send'], $posts['archive'], $posts['everyone'], $posts['iduser'], $posts['id']);

            return $this->respond(['resp' => $send]);
        } catch (\Exception $e) {
            return $this->respond(['error' => $e->getMessage()]);
        }
        return $this->respond($posts);
    }


    /**
     * DataTable method to fetch and format group data for display in a DataTable.
     *
     * @param int $company The company ID for which to retrieve group data.
     * @return \CodeIgniter\HTTP\ResponseInterface JSON response containing formatted data for DataTable.
     */
    public function datatable(int $company)
    {


        if ($this->cache->get("datatable_groups_" . $company)) {
            return $this->response->setJSON($this->cache->get("datatable_groups_" . $company));
        } else {
            // Instanciar os modelos necessários
            $gruposModel = new GroupModel();
            $participantsModel = new ParticipantModel();

            // Inicializar o array para armazenar os resultados formatados
            $results = [];

            // Buscar os grupos com informações relevantes usando um join com a tabela de instâncias
            $groups = $gruposModel
                ->select('groups.*, instances.profile_name, instances.owner as instance_owner')
                ->join('instances', 'instances.id = groups.instance')
                ->where('instances.id_company', $company)
                ->findAll();

            foreach ($groups as $group) {
                // Contar o número de participantes no grupo
                $sqlParticipantsCount = $participantsModel
                    ->where('id_group', $group['id_group'])
                    ->countAllResults();

                // Verificar se o dono da instância é um administrador
                $sqlParticipantsAdm = $participantsModel
                    ->whereIn('admin', ['admin', 'superadmin'])
                    ->where('id_group', $group['id_group'])
                    ->where('participant', $group['instance_owner'])
                    ->first();

                // Determinar os ícones e tags a serem exibidos com base na verificação de administrador
                if (isset($sqlParticipantsAdm['admin'])) {
                    $vAdmin = '<div class="hstack gap-3 flex-wrap">
                <a href="#"><i class="ri-user-follow-fill"></i></a>
                <a href="#"><i class="ri-edit-2-line"></i></a>
                <a href="#"><i class="ri-information-line"></i></a>
                </div>';
                    $tagAdmin = '<span class="badge bg-primary">' . $sqlParticipantsAdm['admin'] . '</span><br>';
                } else {
                    $vAdmin = '<div class="hstack gap-3 flex-wrap">
                <a href="#"><i class="ri-user-unfollow-fill"></i></a>
                <a href="#"><i class="ri-information-line"></i></a>
                </div>';
                    $tagAdmin = "";
                }

                // Formatar o HTML para a coluna de checkbox
                $htmlInput   = '<div class="form-check mb-3"><input class="form-check-input" type="checkbox" id="' . $group['id'] . '" name="' . $group['id'] . '"><label class="form-check-label" for="' . $group['id'] . '"></label></div>';

                // Formatar o HTML para a coluna de perfil com administração e contagem de participantes
                $htmlProfile = $tagAdmin . $group['subject'] . '<hr class="p-0 m-0"><b>Instance: </b>' . $group['profile_name'] . '<br><b>Participantes: </b><span class="badge badge-label bg-danger"><i class="mdi mdi-circle-medium"></i>' . $sqlParticipantsCount . '</span><br>' . $group['id_group'];

                // Converter o timestamp de criação em formato de data e hora
                $time = Time::createFromTimestamp($group['creation']);

                // Adicionar as informações formatadas ao array de resultados
                $results[] = [
                    $group['id'],
                    $htmlProfile,
                    $time->format('d/m/Y H:i:s'),
                    "",
                    $vAdmin
                ];
            }
            $this->cache->save("datatable_groups_" . $company, json_encode(['data' => $results]), 600);

            // Responder com os resultados formatados para a DataTable
            return $this->response->setJSON($this->cache->get("datatable_groups_" . $company));
        }
    }


    public function logs($company)
    {
        if ($this->cache->get("datatable_logsgroups_" . $company)) {
            return $this->response->setJSON($this->cache->get("datatable_logsgroups_" . $company));
        } else {
            $logsGroupsModel = new LogsGroupsModel();
            $groupModel      = new GroupModel();
            $groupsLogs      = $logsGroupsModel
                ->select('logs_groups.*, instances.profile_name, instances.owner as instance_owner')
                ->join('instances', 'instances.id = logs_groups.id_instance')
                ->where('instances.id_company', $company)
                ->findAll();
            $data = [];

            foreach ($groupsLogs as $row) {
                $group = $groupModel->where(['id_group' => $row['id_group']])->first();

                $data[] = [
                    $row['id'],
                    cleanPhoneNumber($row['participants']),
                    ($group['subject']) ?? "",
                    badgeStatus($row['action'])
                ];
            }

            $this->cache->save("datatable_logsgroups_" . $company, json_encode(['data' => $data]), 600);
            
            return $this->respond(['data' => $data]);
        }
    }
}
