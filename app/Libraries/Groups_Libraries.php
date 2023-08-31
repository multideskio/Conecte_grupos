<?php

namespace App\Libraries;

use App\Models\SendModel;

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
        helper(['whatsapp', 'response']);
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
        cleanPhoneNumber($numbers);

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

    public function sendMessage(array $listaDestino, string $message, string $archive, bool $mentions = true): array
    {
        $json = array(); // Inicializa a variável $json como um array vazio

        $headers = array(
            'Accept' => '*/*',
            'apikey' => $this->apiKey,
            'Content-Type' => 'application/json',
            'user-agent' => "CI4"
        );

        $client = \Config\Services::curlrequest();

        $code = uniqid();

        foreach ($listaDestino as $destino) {
            if (!empty($archive)) {
                // Lógica para determinar o tipo de arquivo e enviar mensagem correspondente
                $extension = getExtensionFromUrl($archive);
                switch ($extension) {
                    case 'jpg':
                    case 'png':
                    case 'jpeg':
                        $apiUrl = "{$this->apiUrl}/message/sendMedia/{$this->instance}";
                        $posts  = createImageMessage($destino, $message, $archive);
                        break;
                    case 'mp4':
                        $apiUrl = "{$this->apiUrl}/message/sendMedia/{$this->instance}";
                        $posts  = createVideoMessage($destino, $message, $archive);
                        break;
                    case 'xlsx':
                        $apiUrl = "{$this->apiUrl}/message/sendMedia/{$this->instance}";
                        $posts  = createXlsxDocumentMessage($destino, 'arquivo.xlsx', $message, $archive);
                        break;
                    case 'zip':
                        $apiUrl = "{$this->apiUrl}/message/sendMedia/{$this->instance}";
                        $posts  = createZipDocumentMessage($destino, 'aqruivo.zip', $message, $archive);
                        break;
                    case 'pdf':
                        $apiUrl = "{$this->apiUrl}/message/sendMedia/{$this->instance}";
                        $posts  = createPdfDocumentMessage($destino, 'arquivo.pdf', $message, $archive);
                        break;
                    case 'mp3':
                    case 'ogg':
                        $apiUrl = "{$this->apiUrl}/message/sendMedia/{$this->instance}";
                        $posts  = createAudioMessage($destino, $archive);
                        break;
                        // Adicione mais casos aqui para outros tipos de arquivo
                    default:
                        // Tipo de arquivo não suportado, pode adicionar uma lógica de erro aqui
                        throw new \Exception('O seu arquivo não é suportado.');
                        break;
                }
            } else {
                $apiUrl = "{$this->apiUrl}/message/sendText/{$this->instance}";
                $posts = createTextMessage($destino, $message, $mentions);
            }

            if (isset($posts)) {
                $response = $client->request('POST', $apiUrl, [
                    'headers' => $headers,
                    'json' => $posts
                ]);

                $responseBody = $response->getBody();
                $json[] = json_decode($responseBody, true);
            }


            /**
             * 
             * Não usar sessions na api, pode dar erro de execução no cron
             * Mudar consulta para busca dados no banco de dados ao invés de usar sessions
             * 
             */
            $inserSend[] = [
                'id_company'  => session('user')['company'],
                'id_group'    => $destino,
                'id_user'     => session('user')['id'],
                'message'     => $message,
                'code'        => $code
            ];
            
        }

        $sendsModel = new SendModel();

        if (!empty($inserSend)) {
            $sendsModel->insertBatch($inserSend);
        }

        // Adicione aqui a lógica para o caso em que $archive é verdadeiro

        return $posts;
    }
}
