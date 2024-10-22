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

    public function createGroupsMulti(int $num, array $numbers, string $name, string $description = null)
    {
        $headers = array(
            'Accept' =>  '*/*',
            'apikey' => $this->apiKey,
            'Content-Type' => 'application/json',
            'user-agent' => "CI4"
        );

        $url = "{$this->apiUrl}/group/create/{$this->instance}";

        $client = \Config\Services::curlrequest();

        for ($i = 1; $i <= $num + 1; $i++) {
            $response = $client->request('POST', $url, [
                'headers' => $headers,
                'json' => [
                    "subject" => $i .' '. $name,
                    "description" => ($description) ? $description : '',
                    "participants" => $numbers,
                ]
            ]);
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
                        $posts  = createImageMessage($destino, $message, $archive, $mentions);
                        break;
                    case 'mp4':
                        $apiUrl = "{$this->apiUrl}/message/sendMedia/{$this->instance}";
                        $posts  = createVideoMessage($destino, $message, $archive, $mentions);
                        break;
                    case 'xlsx':
                        $apiUrl = "{$this->apiUrl}/message/sendMedia/{$this->instance}";
                        $posts  = createXlsxDocumentMessage($destino, 'arquivo.xlsx', $message, $archive, $mentions);
                        break;
                    case 'zip':
                        $apiUrl = "{$this->apiUrl}/message/sendMedia/{$this->instance}";
                        $posts  = createZipDocumentMessage($destino, 'aqruivo.zip', $message, $archive, $mentions);
                        break;
                    case 'pdf':
                        $apiUrl = "{$this->apiUrl}/message/sendMedia/{$this->instance}";
                        $posts  = createPdfDocumentMessage($destino, 'arquivo.pdf', $message, $archive, $mentions);
                        break;
                    case 'mp3':
                    case 'ogg':
                        $apiUrl = "{$this->apiUrl}/message/sendWhatsAppAudio/{$this->instance}";
                        $posts  = createAudioMessage($destino, $archive, $mentions);
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

            sleep(3);
        }

        $sendsModel = new SendModel();

        if (!empty($inserSend)) {
            $sendsModel->insertBatch($inserSend);
        }

        // Adicione aqui a lógica para o caso em que $archive é verdadeiro

        return $posts;
    }

    public function updateAll(array $listaDestino, string $image, string $title, string $desc, string $trancar)
    {
        $headers = array(
            'Accept' => '*/*',
            'apikey' => $this->apiKey,
            'Content-Type' => 'application/json',
            'user-agent' => "CI4"
        );

        $client = \Config\Services::curlrequest();

        $data = [];

        foreach ($listaDestino as $key => $destino) {
            try {
                $groupData = ['groupJid' => $destino]; // Dados iniciais do grupo

                if ($image) {
                    $response = $client->request('POST', "{$this->apiUrl}/group/updateGroupPicture/{$this->instance}/?groupJid={$destino}", [
                        'headers' => $headers,
                        'json' => [
                            "image" => $image
                        ]
                    ]);
                    log_message('info', "Imagem do grupo {$destino} atualizada com sucesso.");
                    $groupData['image_status'] = 'updated';

                    // Intervalo aleatório de 1 a 2 segundos
                    sleep(rand(1, 2));
                }

                if ($title) {
                    $response = $client->request('POST', "{$this->apiUrl}/group/updateGroupSubject/{$this->instance}/?groupJid={$destino}", [
                        'headers' => $headers,
                        'json' => [
                            "subject" => "[" . ++$key . "] {$title}"
                        ]
                    ]);
                    log_message('info', "Título do grupo {$destino} atualizado para '{$title}'.");
                    $groupData['title_status'] = 'updated';
                    $groupData['new_title'] = $title;

                    // Intervalo aleatório de 1 a 2 segundos
                    sleep(rand(1, 2));
                }

                if ($desc) {
                    $response = $client->request('POST', "{$this->apiUrl}/group/updateGroupDescription/{$this->instance}/?groupJid={$destino}", [
                        'headers' => $headers,
                        'json' => [
                            "description" => $desc
                        ]
                    ]);
                    log_message('info', "Descrição do grupo {$destino} atualizada.");
                    $groupData['description_status'] = 'updated';

                    // Intervalo aleatório de 1 a 2 segundos
                    sleep(rand(1, 2));
                }

                if ($trancar) {
                    $action = $trancar == 'open' ? "not_announcement" : "announcement";
                    $response = $client->request('POST', "{$this->apiUrl}/group/updateSetting/{$this->instance}/?groupJid={$destino}", [
                        'headers' => $headers,
                        'json' => [
                            "action" => $action
                        ]
                    ]);
                    log_message('info', "Configuração do grupo {$destino} atualizada para '{$trancar}'.");
                    $groupData['trancar_status'] = $trancar;

                    // Intervalo aleatório de 1 a 2 segundos
                    sleep(rand(1, 2));
                }

                $groupData['status'] = 'success'; // Marca o status como sucesso
                $data[] = $groupData;
            } catch (\Exception $e) {
                log_message('error', "Erro ao atualizar o grupo {$destino}: {$e->getMessage()}");
                $data[] = [
                    'groupJid' => $destino,
                    'status' => 'error',
                    'error_message' => $e->getMessage()
                ];
            }
        }

        return $data;
    }
}
