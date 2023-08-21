<?php

namespace App\Libraries;

use App\Models\InstanceModel;

class instances_libraries
{
    /**
     * 
     * BUSCA DADOS DIRETO DA API
     * 
     */
    private $apiUrl;
    private $apiKey;
    protected $client;
    
    public function __construct($apiUrl, $apiKey)
    {
        $this->apiUrl = $apiUrl;
        $this->apiKey = $apiKey;
        $this->client = \Config\Services::curlrequest();
    }
    public function import()
    {
        $url = "{$this->apiUrl}/instance/fetchInstances";

        $headers = array(
            'Accept' =>  '*/*',
            'Content-Type' => 'application/json',
            'apikey' => $this->apiKey
        );

        $response = $this->client->request('GET', $url, [
            'headers' => $headers
        ]);

        $responseBody = json_decode($response->getBody(), true);

        $posts = array();

        foreach ($responseBody as $instancesRow){
            foreach ($instancesRow as $row){
                //print_r($row);
                $posts[] = [
                    'id_superadmin'       => session('user')['admin'],
                    'name'                => $row['instanceName'],
                    'wa_number'           => (isset($row['owner']))             ? $row['owner']             : null,
                    'profile_name'        => (isset($row['profileName']))       ? $row['profileName']       : null,
                    'profile_picture_url' => (isset($row['profilePictureUrl'])) ? $row['profilePictureUrl'] : null,
                    'profile_status'      => (isset($row['profileStatus']))     ? $row['profileStatus']     : null,
                    'status'              => (isset($row['status']))            ? $row['status']            : null,
                    'server_url'          => (isset($row['serverUrl']))         ? $row['serverUrl']         : null,
                    'api_key'             => (isset($row['apikey']))            ? $row['apikey']            : null
                ];
            }
        }

        
        $mInstances = new InstanceModel();
        
        try {
            // Deletar registros existentes do superadmin atual
            $delInstances = $mInstances->where('id_superadmin', session('user')['id'])->delete();
            
            // Inserir os novos registros
            $inInstances = $mInstances->insertBatch($posts);
    
            return $inInstances;
        } catch (\Exception $e) {
            return $e->getMessage(); // Retorna mensagem de erro, caso ocorra uma exceção
        }
        
        /*$delInstaces = $mInstaces->where('id_superadmin', session('user')['admin'])->delete();
        
        $inInstaces = $mInstaces->insertBatch($posts) ;
        
        return $inInstaces;*/
    }
}
