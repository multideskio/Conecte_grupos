<?php

namespace App\Services;

use App\Models\InstanceModel;

class GroupService
{

    protected $instanceModel;
    protected $instance;

    public function __construct($nameInstance)
    {
        $this->instanceModel = new InstanceModel();
        $this->instance = $this->instanceModel->where('name', $nameInstance)->findAll();
    }

    public function listGroups($listParticipants = 'false')
    {
        try {

            $apiUrl = "{$this->instance[0]['server_url']}/group/fetchAllGroups/{$this->instance[0]['name']}?getParticipants=false";

            // Definir os cabeçalhos da requisição
            $headers = [
                'Accept'       => '*/*',
                'apikey'       => $this->instance[0]['api_key'],
                'Content-Type' => 'application/json',
            ];
            
            // Crie uma instância do cliente cURL do CodeIgniter 4
            $httpClient = \Config\Services::curlrequest();

            $response = $httpClient->request('GET', $apiUrl, [
                'headers' => $headers,
            ]);
    
            $apiResponse = json_decode($response->getBody(), true);

            return $apiResponse;
            
        } catch (\Exception $e) {
            // Lidar com erros, como autorização (erro 401)
            return ['error' => $e->getMessage(), 'url' => $apiUrl, 'apikey' => $this->instance[0]['api_key']];
        }
    }
}
