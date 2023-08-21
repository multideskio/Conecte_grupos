<?php

namespace App\Services;

use App\Models\InstanceModel;
use App\Models\PlanModel;
use App\Models\SuperModel;

class InstanceService
{

    protected $apiCredentials;
    protected $superModel;
    protected $sessionData;
    protected $instanceModel;

    public function __construct()
    {
        $this->instanceModel  = new InstanceModel();
        $this->superModel     = new SuperModel();
        $this->sessionData    = session('user');
        $this->apiCredentials = $this->superModel->select('url_api_wa url, api_key_wa key')->find($this->sessionData['control']);
        helper('response');
    }

    /**
     * Verifica se as instâncias do plano estão criadas e atualiza se necessário.
     */
    public function verifyPlan()
    {
        $planModel = new PlanModel();

        $configuredPlan = $planModel->select('num_instance')->where('id_company', $this->sessionData['company'])->findAll();
        $createdInstances = $this->instanceModel->where('id_company', $this->sessionData['company'])->findAll();

        if (!count($configuredPlan)) {
            throw new \Exception('Plano não configurado para a empresa.');
        }

        if ($configuredPlan[0]['num_instance'] == count($createdInstances)) {
            $this->updateInstances();
        } elseif ($configuredPlan[0]['num_instance'] > count($createdInstances)) {
            $numInstancesToCreate = $configuredPlan[0]['num_instance'] - count($createdInstances);
            return $this->createInstances($numInstancesToCreate);
        } else {
            // Excluir instâncias para manter o plano ativo
        }
    }

    /**
     * Cria novas instâncias.
     *
     * @param int $numInstances Número total de instâncias para criar.
     */
    public function createInstances($numInstances)
    {
        $apiUrl = "{$this->apiCredentials['url']}/instance/create";
        $headers = [
            'Accept'       => '*/*',
            'apikey'       => $this->apiCredentials['key'],
            'Content-Type' => 'application/json',
        ];
        $httpClient = \Config\Services::curlrequest();
        $responseBodies = [];
        for ($i = 0; $i < $numInstances; $i++) {
            $instanceName = uniqid() . "_instance_{$this->sessionData['company']}";
            $postPayload = [
                "instanceName" => $instanceName,
                "qrcode" => true,
                "webhook" => site_url("api/v1/webhook/{$instanceName}"),
                "webhook_by_events" => true,
                "events" => [
                    // "APPLICATION_STARTUP",
                    //"QRCODE_UPDATED",
                    // "MESSAGES_SET",
                    //"MESSAGES_UPSERT",
                    //"MESSAGES_UPDATE",
                    //"MESSAGES_DELETE",
                    //"SEND_MESSAGE",
                    // "CONTACTS_SET",
                    // "CONTACTS_UPSERT",
                    // "CONTACTS_UPDATE",
                    // "PRESENCE_UPDATE",
                    // "CHATS_SET",
                    // "CHATS_UPSERT",
                    // "CHATS_UPDATE",
                    // "CHATS_DELETE",
                    //"GROUPS_UPSERT",
                    "GROUP_UPDATE",
                    "GROUP_PARTICIPANTS_UPDATE",
                    "CONNECTION_UPDATE",
                    //"CALL"
                    // "NEW_JWT_TOKEN"
                ]
            ];

            $response = $httpClient->request('POST', $apiUrl, [
                'headers' => $headers,
                'json' => $postPayload
            ]);

            $responseBodies[] = json_decode($response->getBody(), true);
        }

        $this->insertInstanceData($responseBodies);
    }

    /**
     * Insere os dados das instâncias criadas no banco de dados.
     *
     * @param array $responseData Dados a serem inseridos.
     */
    public function insertInstanceData(array $responseData)
    {
        $insertData = [];

        foreach ($responseData as $row) {
            $insertData[] = [
                'id_company' => $this->sessionData['company'],
                'name' => $row['instance']['instanceName'],
                'server_url' => $this->apiCredentials['url'],
                'api_key' => $row['hash']['apikey']
            ];
        }

        $this->instanceModel->insertBatch($insertData);
    }

    /**
     * Busca todas as instancias.
     *
     * @param array $databaseInstances Instâncias do banco de dados.
     */

    private function searchApi()
    {
        $apiUrl = "{$this->apiCredentials['url']}/instance/fetchInstances";
        $httpClient = \Config\Services::curlrequest();
        $headers = [
            'Accept'       => '*/*',
            'apikey'       => $this->apiCredentials['key'],
            'Content-Type' => 'application/json',
        ];
        $response = $httpClient->request('GET', $apiUrl, [
            'headers' => $headers,
        ]);
        return json_decode($response->getBody(), true);
    }

    /**
     * Atualiza as instâncias existentes no banco de dados.
     *
     * @param array $databaseInstances Instâncias do banco de dados.
     */
    public function updateInstances()
    {
        $apiResponse = $this->searchApi();
        $dataToUpdate = [];
        foreach ($apiResponse as $item) {
            if (isset($item['instance']['instanceName'])) {
                $dataToUpdate[] = [
                    'name'                => $item['instance']['instanceName'],
                    'phone'               => ($item['instance']['owner']) ? cleanPhoneNumber($item['instance']['owner']) : null,
                    'owner'               => $item['instance']['owner'] ?? null,
                    'profile_name'        => $item['instance']['profileName'] ?? null,
                    'profile_picture_url' => $item['instance']['profilePictureUrl'] ?? null,
                    'profile_status'      => $item['instance']['profileStatus'] ?? null,
                    'status'              => $item['instance']['status'] ?? null,
                ];
            }
        }
        $this->instanceModel->updateBatch($dataToUpdate, 'name');
    }

    /**
     * Exclui instâncias.
     */
    public function deleteInstances()
    {
        // Implemente a lógica para excluir instâncias, se necessário.
    }

    public function disconnect(array $input): array
    {
        // Monta a URL da API para desconectar a instância
        $apiUrl = "{$this->apiCredentials['url']}/instance/logout/{$input['instance']}";

        // Cria uma instância do cliente HTTP
        $httpClient = \Config\Services::curlrequest();

        // Define os cabeçalhos da requisição
        $headers = [
            'Accept'       => '*/*',
            'apikey'       => $input['apikey'],
            'Content-Type' => 'application/json',
        ];

        try {
            // Faz a requisição HTTP DELETE
            $response = $httpClient->request('DELETE', $apiUrl, [
                'headers' => $headers,
            ]);

            // Decodifica a resposta JSON e retorna
            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            // Em caso de erro na requisição, retorne uma resposta de erro ou lance uma exceção
            return ['error' => 'Erro na requisição'];
        }
    }

    public function restart(array $input): array
    {
        // Monta a URL da API para desconectar a instância
        $apiUrl = "{$this->apiCredentials['url']}/instance/restart/{$input['instance']}";

        // Cria uma instância do cliente HTTP
        $httpClient = \Config\Services::curlrequest();

        // Define os cabeçalhos da requisição
        $headers = [
            'Accept'       => '*/*',
            'apikey'       => $input['apikey'],
            'Content-Type' => 'application/json',
        ];

        // Faz a requisição HTTP DELETE
        $response = $httpClient->request('PUT', $apiUrl, [
            'headers' => $headers,
        ]);

        // Decodifica a resposta JSON e retorna
        return json_decode($response->getBody(), true);
    }

    public function conectar(array $input): array
    {
        // Monta a URL da API para desconectar a instância
        $apiUrl = "{$this->apiCredentials['url']}/instance/connect/{$input['instance']}";

        // Cria uma instância do cliente HTTP
        $httpClient = \Config\Services::curlrequest();

        // Define os cabeçalhos da requisição
        $headers = [
            'Accept'       => '*/*',
            'apikey'       => $input['apikey'],
            'Content-Type' => 'application/json',
        ];

        // Faz a requisição HTTP DELETE
        $response = $httpClient->request('GET', $apiUrl, [
            'headers' => $headers,
        ]);

        // Decodifica a resposta JSON e retorna
        return json_decode($response->getBody(), true);
    }
}
