<?php

namespace App\Controllers\API;

use App\Models\InstanceModel;
use App\Models\LogsGroupsModel;
use App\Models\ParticipantModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class Webhook extends ResourceController
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
        //
        return $this->fail('Acesso bloqueado!!!', 401);
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


    public function events($instance = null)
    {
        try {
            /**
             * ADICIONAR A LOGICA DE IDENTIFICAR A CAMPANHA PELO ID DO GRUPO
             */
            $instanceModel  = new InstanceModel();
            $postPayload    = $this->request->getVar();
            $logsGroupModel = new LogsGroupsModel();

            $participantModel = new ParticipantModel();

            $build = $instanceModel->where([
                'name'    => $instance,
                'api_key' => $postPayload->apikey
            ])->first();

            if (!$build) {
                log_message('error', "Company not found: instance {$instance}");
                return $this->fail('Company not found');
            }

            $participant = $participantModel->where([
                'id_company' => $build['id_company'],
                'id_group'   => $postPayload->data->id
            ])->first();

            if (isset($participant['admin'])) {
                $data = [
                    'id_company'    => $build['id_company'],
                    'id_instance'   => $build['id'],
                    'id_group'      => $postPayload->data->id,
                    'event'         => $postPayload->event,
                    'action'        => $postPayload->data->action,
                    'participants'  => json_encode($postPayload->data->participants, true),
                    'payload'       => json_encode($postPayload, true)
                ];
                $logsGroupModel->insert($data);
                return $this->respondCreated();
            } else {
                return $this->fail('User is not a group admin');
            }
        } catch (\Exception $e) {
            return $this->fail(['error' => $e->getMessage()]);
        }
    }
}
