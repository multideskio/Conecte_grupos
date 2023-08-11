<?php

namespace App\Libraries;

class Groups_Libraries
{
    private $apiUrl;
    private $apiKey;
    private $instance;

    public function __construct($apiUrl, $apiKey, $instance)
    {
        $this->apiUrl = $apiUrl;
        $this->apiKey = $apiKey;
        $this->instance = $instance;
    }

    public function listGroups(string $listParticipants = 'false')
    {
        try {

            $url = "{$this->apiUrl}/group/fetchAllGroups/{$this->instance}?getParticipants={$listParticipants}";

            // Definir os cabeçalhos da requisição
            $headers = array(
                'headers' => array(
                    'apikey' => $this->apiKey
                )
            );

            // Crie uma instância do cliente cURL do CodeIgniter 4
            $client = \Config\Services::curlrequest();

            // Enviar a solicitação GET
            $response = $client->get($url, $headers);

            // Obter o corpo da resposta como string
            $responseBody = $response->getBody();

            // Decodificar a resposta como JSON e retornar os dados decodificados
            return json_decode($responseBody, true);
        } catch (\Exception $e) {
            // Lidar com erros, como autorização (erro 401)
            return ['error' => $e->getMessage(), 'url' => $url];
        }
    }

    // Função para remover caracteres não numéricos dos números de telefone
    public function cleanPhoneNumber(&$phoneNumber)
    {
        $phoneNumber = preg_replace('/\D/', '', $phoneNumber);
    }

    public function createGroups(array $numbers, string $name, string $description = null)
    {
        $url = "{$this->apiUrl}/group/create/{$this->instance}";

        // Definir os cabeçalhos da requisição
        // Definir os cabeçalhos da requisição na ordem desejada
        $headers = array(
            'Accept' =>  '*/*',
            'apikey' => $this->apiKey,
            'Content-Type' => 'application/json',
            'user-agent' => "CI4"
        );

        // Limpar os números de telefone no array usando array_walk
        $this->cleanPhoneNumber($numbers);

        $posts = [
            "subject" => $name,
            "description" => ($description) ? $description : '',
            "participants" => $numbers,

        ];



        // Crie uma instância do cliente cURL do CodeIgniter 4
        $client = \Config\Services::curlrequest();

        // Enviar a solicitação POST
        $response = $client->request('POST', $url, [
            'headers' => $headers,
            'json' => $posts
        ]);

        // Obter o corpo da resposta como string
        $responseBody = $response->getBody();

        // Decodificar a resposta como JSON e retornar os dados decodificados
        return json_decode($responseBody, true);
    }

    public function sendMessage(array $listaDestino, string $message, bool $mentions = true): array
    {

        $url = "{$this->apiUrl}/message/sendText/{$this->instance}";

        //headers
        $headers = array(
            'Accept' =>  '*/*',
            'apikey' => $this->apiKey,
            'Content-Type' => 'application/json',
            'user-agent' => "CI4"
        );

        // Crie uma instância do cliente cURL do CodeIgniter 4
        $client = \Config\Services::curlrequest(); 

        try {
            //monta mensagem em um laço de repetição
            foreach ($listaDestino as $destino) {
                //monta mensagem
                $posts = [
                    "number" => $destino,
                    "options" => [
                        "delay" => 1200,
                        "presence" => "composing",
                        "mentions" => [
                            "everyOne" => $mentions
                        ]
                    ],
                    "textMessage" => [
                        "text" => "{$message} \n\n\n " . date("d/m/Y H:i:s")
                    ]
                ];
                // Enviar a solicitação POST
                $response = $client->request('POST', $url, [
                    'headers' => $headers,
                    'json' => $posts
                ]);
                // Obter o corpo da resposta como string
                $responseBody = $response->getBody();
                // Decodificar a resposta como JSON e retornar os dados decodificados
                $json[] = json_decode($responseBody, true);
            }
            return $json;
        
        } catch (\Exception $e) {
        
            return $e->getMessage();
        
        }
    }
}
