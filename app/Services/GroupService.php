<?php

namespace App\Services;

use App\Models\CompanyGroupsModel;
use App\Models\GroupModel;
use App\Models\InstanceModel;
use App\Models\ParticipantModel;
use GuzzleHttp\Client;

class GroupService
{
    protected $instanceModel;
    protected $instance;
    protected $groupModel;
    protected $companyGroupsModel;
    protected $participantModel;
    protected $idCompany;

    public function __construct($nameInstance, $idCompany)
    {
        $this->idCompany = $idCompany;
        $this->companyGroupsModel = new CompanyGroupsModel();
        $this->groupModel         = new GroupModel();
        $this->instanceModel      = new InstanceModel();
        $this->participantModel   = new ParticipantModel();

        $this->instance = $this->instanceModel->where('name', $nameInstance)->findAll();
    }

    public function listGroups($listParticipants = false)
    {
        $apiUrl = "{$this->instance[0]['server_url']}/group/fetchAllGroups/{$this->instance[0]['name']}?getParticipants=true";
        try {

            // Definir os cabeçalhos da requisição
            $headers = [
                'apikey'       => $this->instance[0]['api_key']
            ];

            // Crie uma instância do cliente cURL do CodeIgniter 4
            $httpClient = \Config\Services::curlrequest();

            $response = $httpClient->request('GET', $apiUrl, [
                'headers' => $headers,
            ]);

            $groupsData = json_decode($response->getBody(), true);

            if (count($groupsData)) {
                $this->insertOrUpdateGroups($groupsData);
            } else {
                throw new \Exception('Você não tem grupos para atualizar');
            }
        } catch (\Exception $e) {

            return ['error' => $e->getMessage(), 'url' => $apiUrl, 'apikey' => $this->instance[0]['api_key']];
        }
    }


    private function insertOrUpdateGroups($groupsData)
    {
        $groupDataRelation = [];

        // Get IDs of groups from the API response
        $apiGroupIds = array_column($groupsData, 'id');

        // Get IDs of groups from the database for the current instance
        $existingGroupIds = array_column($this->groupModel
            ->where('instance', $this->instance[0]['id'])
            ->findAll(), 'id_group');

        // Find the IDs of groups that need to be deleted
        $groupsToDelete = array_diff($existingGroupIds, $apiGroupIds);

        // Delete the groups that are no longer present in the API response
        if (!empty($groupsToDelete)) {
            $this->groupModel
                ->whereIn('id_group', $groupsToDelete)
                ->where('instance', $this->instance[0]['id'])
                ->delete();
        }

        // Process groups for insertion/update
        $updateData = [];
        $insertData = [];

        foreach ($groupsData as $group) {
            $existingGroup = $this->groupModel
                ->where('id_group', $group['id'])
                ->where('instance', $this->instance[0]['id'])
                ->findAll();
            if (count($existingGroup)) {
                $groupDataInsert = [
                    'id'            => $existingGroup[0]['id'],
                    'instance'      => $this->instance[0]['id'],
                    'id_group'      => $group['id'],
                    'subject'       => $group['subject'] ?? null,
                    'subject_owner' => $group['subjectOwner'] ?? null,
                    'subject_time'  => $group['subjectTime'] ?? null,
                    'size'          => $group['size'] ?? '0',
                    'creation'      => $group['creation'] ?? null,
                    'owner'         => $group['owner'] ?? null,
                    'desc'          => $group['desc'] ?? null,
                    'descId'        => $group['descId'] ?? null,
                    'restrict'      => $group['restrict'] ?? null,
                    'announce'      => $group['announce'] ?? null,
                ];
                $updateData[] = $groupDataInsert;
            } else {
                $groupData = [
                    'instance'      => $this->instance[0]['id'],
                    'id_group'      => $group['id'],
                    'subject'       => $group['subject'] ?? null,
                    'subject_owner' => $group['subjectOwner'] ?? null,
                    'subject_time'  => $group['subjectTime'] ?? null,
                    'size'          => $group['size'] ?? '0',
                    'creation'      => $group['creation'] ?? null,
                    'owner'         => $group['owner'] ?? null,
                    'desc'          => $group['desc'] ?? null,
                    'descId'        => $group['descId'] ?? null,
                    'restrict'      => $group['restrict'] ?? null,
                    'announce'      => $group['announce'] ?? null,
                ];
                $insertData[] = $groupData;
            }
            // Store group data for later participant insertion
            $groupDataRelation[] = $group;
        }

        if (!empty($insertData)) {
            $this->groupModel->insertBatch($insertData);
        }

        if (!empty($updateData)) {
            $this->groupModel->updateBatch($updateData, 'id');
        }

        $this->relateGroupsToCompanies($groupDataRelation, $this->idCompany);
    }




    private function relateGroupsToCompanies($groupsData, $companyId)
    {
        $dataIn = [];
        $groupIdsFromApi = array_column($groupsData, 'id');

        // Get existing relationships for the current company
        $existingRelationships = $this->companyGroupsModel
            ->where('id_company', $companyId)
            ->findAll();

        // Find the relationships that need to be deleted
        $relationshipsToDelete = array_filter($existingRelationships, function ($relationship) use ($groupIdsFromApi) {
            return !in_array($relationship['id_group'], $groupIdsFromApi);
        });

        // Delete the relationships that are no longer present in the API response
        /*if (!empty($relationshipsToDelete)) {
            $relationshipIdsToDelete = array_column($relationshipsToDelete, 'id');
            $this->companyGroupsModel
                ->whereIn('id', $relationshipIdsToDelete)
                ->where('id_company', $companyId)
                ->delete();
        }*/

        // Insert new relationships
        foreach ($groupsData as $group) {
            $existingRelationship = $this->companyGroupsModel
                ->where('id_group', $group['id'])
                ->where('id_company', $companyId)
                ->countAllResults();

            if (!$existingRelationship) {
                $dataIn[] = [
                    'id_group' => $group['id'],
                    'id_company' => $companyId
                ];
            }
        }

        if (!empty($dataIn)) {
            $this->companyGroupsModel->insertBatch($dataIn);
        }

        // Insert participants
        $groupId = [];
        $participants = [];

        foreach ($groupsData as $group) {
            $groupId[]      = $group['id'];
            $participants[] = $group['participants'] ?? [];
        }

        $this->insertOrUpdateParticipants($participants, $groupId);
    }






    private function insertOrUpdateParticipants($participantsData, $groupIds)
    {
        $dataParticipants = [];

        // Coletar todos os IDs de participantes
        $participantIds = [];
        foreach ($participantsData as $participants) {
            foreach ($participants as $participant) {
                $participantIds[] = $participant['id'];
            }
        }

        // Verificar a existência de participantes
        $existingParticipants = $this->participantModel
            ->whereIn('participant', $participantIds)
            ->where('id_company', $this->idCompany)
            ->findAll();

        // Criar um índice associativo para os participantes existentes para facilitar a verificação
        $existingParticipantsMap = [];
        foreach ($existingParticipants as $existingParticipant) {
            $existingParticipantsMap[$existingParticipant['participant']] = true;
        }

        // Verificar e preparar os dados para inserção
        foreach ($participantsData as $groupIndex => $participants) {
            foreach ($participants as $participant) {
                $participantId = $participant['id'];

                if (!isset($existingParticipantsMap[$participantId])) {
                    $dataParticipants[] = [
                        'id_company'  => $this->idCompany,
                        'id_group'    => $groupIds[$groupIndex],
                        'participant' => $participantId,
                        'admin'       => $participant['admin']
                    ];
                }
            }
        }

        // Inserir os participantes no banco de dados, se houver dados a serem inseridos
        if (!empty($dataParticipants)) {
            $this->participantModel->insertBatch($dataParticipants);
        }
    }
}
