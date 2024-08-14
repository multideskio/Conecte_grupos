<?php

namespace App\Controllers\API;

use App\Models\GroupModel;
use App\Models\ParticipantModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class Participants extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    protected $cache;
    public function __construct()
    {
        $this->cache = \Config\Services::cache();
        helper('response');
    }
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

    public function dataTable1($companyId)
    {

        $participantsModel = new ParticipantModel();

        $columnName = 'participant'; // Substitua pelo nome real da coluna

        $additionalColumn = 'id_group'; // Substitua pelo nome real da coluna adicional

        // Criar uma tabela temporária para armazenar os IDs dos registros duplicados
        $tempTableName = 'temp_duplicates';
        $createTempTable = "CREATE TEMPORARY TABLE $tempTableName AS
                        SELECT id, $columnName, $additionalColumn 
                        FROM participants 
                        WHERE (id, $columnName, $additionalColumn) NOT IN 
                              (SELECT MIN(id), $columnName, $additionalColumn 
                               FROM participants 
                               GROUP BY $columnName, $additionalColumn)";

        $participantsModel->query($createTempTable);

        // Excluir os registros duplicados
        $deleteDuplicates = "DELETE FROM participants WHERE id IN (SELECT id FROM $tempTableName)";
        $participantsModel->query($deleteDuplicates);

        // Remover a tabela temporária
        $dropTempTable = "DROP TEMPORARY TABLE IF EXISTS $tempTableName";
        $participantsModel->query($dropTempTable);


        echo "<pre>";


        /*foreach ($duplicates as $duplicate) {
            $participantsModel->builder()->where("$columnName", $duplicate->$columnName);
            $participantsModel->builder()->orderBy('id', 'DESC'); // Selecione a ordem desejada para manter um registro, pode ser necessário ajustar
            $participantsModel->builder()->limit($duplicate->count - 1); // Limita a quantidade para manter
            $participantsModel->builder()->delete();
        }*/


        //return 'Duplicatas removidas com sucesso!';
    }

    public function dataTable(int $company)
    {
        if ($this->cache->get("datatable_participants_" . $company)) {
            return $this->response->setJSON($this->cache->get("datatable_participants_" . $company));
        } else {
            $gruposModel = new GroupModel();
            $participantsModel = new ParticipantModel();
            $results = [];

            // Buscar os grupos com informações relevantes usando um join com a tabela de instâncias
            $groups = $gruposModel
                ->select('groups.*, instances.profile_name, instances.owner as instance_owner')
                ->join('instances', 'instances.id = groups.instance')
                ->where('instances.id_company', $company)
                ->findAll();

            foreach ($groups as $group) {
                $uniqueParticipants = [];
                //
                $sqlParticipantsCount = $participantsModel->where('id_group', $group['id_group'])->findAll();

                foreach ($sqlParticipantsCount as $row) {
                    //if (!in_array($row['participant'], $uniqueParticipants)) {
                    //$participantsModel->where('id', $row['id'])->delete();
                    //echo $row['id']. "DELETADO <br>";
                    //}
                    $results[] = [
                        $row['id'],
                        $group['subject'],
                        explode("@", $row['participant'])[0]
                    ];
                }
            }
            $this->cache->save("datatable_participants_" . $company, json_encode(['data' => $results]), 10);
            return $this->response->setJSON($this->cache->get("datatable_participants_" . $company));
        }
    }

    public function delete($id = null)
    {
        //
    }
}
