<?php

namespace App\Controllers\API;

use App\Models\GroupModel;
use App\Models\InstanceModel;
use App\Models\SchedulingModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\I18n\Time;


class Messages extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    use ResponseTrait;

    public function index()
    {
        //
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        // Certifique-se de que o ID seja fornecido
        if ($id === null) {
            return $this->fail('Parâmetro ID ausente', 400);
        }

        // Carregue os modelos necessários
        $messagemodel = new SchedulingModel();
        $groupsModel = new GroupModel();

        // Recupere os dados de agendamento para o ID fornecido
        $build = $messagemodel->find($id);

        // Verifique se os dados de agendamento foram encontrados
        if (!$build) {
            return $this->fail('Agendamento não encontrado', 404);
        }

        // Formate os valores de data e hora
        $dateTimeSend = Time::createFromFormat("Y-m-d H:i:s", $build['start']);
        $dateSend = $dateTimeSend->format('d/m/Y H:i:s');

        $dateTimeCreate = Time::createFromFormat("Y-m-d H:i:s", $build['created_at']);
        $dateCreate = $dateTimeCreate->format('d/m/Y H:i:s');

        // Extraia e formate a lista de grupos de remetentes
        $explodeSenders = explode(',', $build['senders']);
        $listGroups = $groupsModel->getFormattedSenderGroups($explodeSenders);

        // Prepare os dados de resposta
        $data = [
            'id' => $build['id'],
            'name' => $build['name'],
            'message' => $build['message'],
            'archive' => $build['archive'],
            'senders' => rtrim($listGroups, ", "), // Remova a vírgula final
            'start' => $dateSend,
            'created_at' => $dateCreate
        ];

        // Retorne a resposta com códigos de status apropriados
        return $this->respond($data);
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

    public function datatable(int $company, string $status)
    {
        $messagemodel = new SchedulingModel();
        $instanceModel = new InstanceModel();
        $data = [];

        // Consulta o banco de dados para buscar os registros com base na empresa e status
        $build = $messagemodel
            ->where('id_company', $company)
            ->where('status', $status)
            ->findAll();

        foreach ($build as $row) {
            // Formata a data/hora do registro
            //$dateTime = Time::createFromFormat("Y-m-d H:i:s", $row['start']);
            //$dateSend = $dateTime->format('d/m/Y H:i:s');
            $time = Time::parse($row['start']);
            $date = $time->humanize();

            // Cria o link apropriado com base no status
            if ($status == 1) {
                $html = '<a href="javascript:;" class="link-info listFunctions" data-messageview="' . $row['id'] . '">View <i class="ri-arrow-right-line align-middle"></i></a>';
            } else {
                $html = '<a href="javascript:;" class="link-danger fs-15 listFunctions"  data-messagedel="' . $row['id'] . '"><i class="ri-delete-bin-line"></i></a>';
            }

            $nameInstance = $instanceModel->find($row['id_instance']);

            // Adiciona os dados formatados ao array de dados
            $data[] = [
                $row['id'],
                $row['name'],
                $nameInstance['profile_name']."<br>".$nameInstance['phone'],
                $date,
                $html
            ];
        }

        // Retorna os dados formatados para serem usados pelo DataTables
        return $this->respond(['data' => $data]);
    }
}
