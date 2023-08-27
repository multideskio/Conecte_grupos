<?php

namespace App\Services;

use App\Models\InstanceModel;
use App\Models\SchedulingModel;
use App\Models\SendModel;

class N8nService
{

    public function __construct()
    {
        helper('whatsapp');
    }

    public function scheduledsSend($instanceId, $message, $destino, $archive, $mentions, $user, $idScheduled)
    {
        $instanceModel = new InstanceModel();
        $instance      = $instanceModel->find($instanceId);
        $headers = array(
            'Accept'       => '*/*',
            'apikey'       => $instance['api_key'],
            'Content-Type' => 'application/json',
            'user-agent'   => "CI4"
        );
        if (!empty($archive)) {
            // Lógica para determinar o tipo de arquivo e enviar mensagem correspondente
            $extension = getExtensionFromUrl($archive);
            switch ($extension) {
                case 'jpg':
                case 'png':
                case 'jpeg':
                    $apiUrl = "{$instance['server_url']}/message/sendMedia/{$instance['name']}";
                    $posts  = createImageMessage($destino, $message, $archive);
                    break;
                case 'mp4':
                    $apiUrl = "{$instance['server_url']}/message/sendMedia/{$instance['name']}";
                    $posts  = createVideoMessage($destino, $message, $archive);
                    break;
                case 'xlsx':
                    $apiUrl = "{$instance['server_url']}/message/sendMedia/{$instance['name']}";
                    $posts  = createXlsxDocumentMessage($destino, 'evolution-api.xlsx', $message, $archive);
                    break;
                case 'zip':
                    $apiUrl = "{$instance['server_url']}/message/sendMedia/{$instance['name']}";
                    $posts  = createZipDocumentMessage($destino, 'preencher.zip', $message, $archive);
                    break;
                case 'pdf':
                    $apiUrl = "{$instance['server_url']}/message/sendMedia/{$instance['name']}";
                    $posts  = createPdfDocumentMessage($destino, 'preencher.pdf', $message, $archive);
                    break;
                case 'mp3':
                case 'ogg':
                    $apiUrl = "{$instance['server_url']}/message/sendWhatsAppAudio/{$instance['name']}";
                    $posts  = createAudioMessage($destino, $archive);
                    break;
                    // Adicione mais casos aqui para outros tipos de arquivo
                default:
                    // Tipo de arquivo não suportado, pode adicionar uma lógica de erro aqui
                    throw new \Exception('O seu arquivo não é suportado.');
                    break;
            }
        } else {
            $apiUrl = "{$instance['server_url']}/message/sendText/{$instance['name']}";
            $posts = createTextMessage($destino, $message, ($mentions == 'false') ? false : true);
        }
        if (isset($posts)) {

            $client = \Config\Services::curlrequest();
            $response = $client->request('POST', $apiUrl, [
                'headers' => $headers,
                'json' => $posts
            ]);
            $responseBody = $response->getBody();
            $json = json_decode($responseBody, true);
            
            $inserSend = [
                'id_company'  => $instance['id_company'],
                'id_group'    => $destino,
                'id_user'     => $user,
                'message'     => $message,
                'code'        => $instance['id_company'].'-'.$idScheduled
            ];
            $sendsModel = new SendModel();
            if (!empty($inserSend)) {
                $sendsModel->insert($inserSend);
            }
            $scheduledsModel = new SchedulingModel();
            $scheduledsModel->update($idScheduled, ['status' => true]);
            return $json ;
        } else {
            throw new \Exception('Post não definido!');
        }
    }
}
