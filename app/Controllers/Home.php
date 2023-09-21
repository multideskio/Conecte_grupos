<?php

namespace App\Controllers;

use App\Libraries\Groups_Libraries;
use App\Libraries\S3;
use App\Models\ParticipantModel;

class Home extends BaseController
{
    public function __construct()
    {
        helper('response');
    }
    public function index()
    {
        return redirect()->to('login');
        //return view('welcome_message');
    }
    public function teste()
    {

        $stripe = service('stripe');

        echo "<pre>";
        print_r($stripe->webhookEndpoints->all(['limit' => 3]));
    }
    public function teste0()

    {
        $cache = \Config\Services::cache();
        if ($cache->get("teste")) {
            return $this->response->setJSON($cache->get('teste'));
        } else {
            $participant = new ParticipantModel();
            $result = $participant->findAll();
            $cache->save("teste", json_encode($result), 120);
            print_r($result);
        }
    }

    public function teste1()
    {

        if ($this->request->getMethod() === 'post' && $this->request->getFile('userfile')) {
            $uploadedFile = $this->request->getFile('userfile');


            // Gerar um novo nome aleatório mantendo a extensão original
            $newRandomName = $uploadedFile->getRandomName(); // . '.' . $uploadedFile->getClientExtension();

            // Configurar o caminho no S3 com o novo nome aleatório
            $s3Path = 'groups/archives/1/' . $newRandomName;

            // Obter o ContentType do arquivo
            $contentType = $uploadedFile->getMimeType();

            $s3 = new S3();
            $result = $s3->uploadFile($uploadedFile->getTempName(), $s3Path, $contentType);

            if ($result) {
                echo 'Arquivo enviado com sucesso: ' . $result;
                echo '<br>';
                echo 'Arquivo com CDN: ' . cdngroup($s3Path);
                echo "<br>";
                $totalSizeInBytes = $s3->getDirectorySize('groups/archives/1/');

                if ($totalSizeInBytes >= 0) {
                    $totalSizeInMB = $totalSizeInBytes / (1024 * 1024);
                    echo 'Tamanho total do diretório: ' . round($totalSizeInMB, 2) . ' MB';
                } else {
                    echo 'Erro ao obter o tamanho do diretório.';
                }
                echo "<br>";
                $contents = $s3->listDirectoryContents('groups/archives/1/');

                if (!empty($contents)) {
                    echo 'Conteúdo do diretório:<br>';
                    foreach ($contents as $item) {
                        echo $item . '<br>';
                    }
                } else {
                    echo 'O diretório está vazio ou ocorreu um erro ao listar o conteúdo.';
                }
            } else {
                echo 'Erro ao enviar o arquivo';
            }
            echo '<form action="?" method="post" enctype="multipart/form-data" style="margin-top: 60px;">
            <input type="file" name="userfile" />
            <input type="submit" value="Enviar" />
        </form>';
        } else {
            echo '<form action="?" method="post" enctype="multipart/form-data">
            <input type="file" name="userfile" />
            <input type="submit" value="Enviar" />
        </form>';
        }
    }

    public function lang()
    {
        $session = session();
        $locale  = service('request')->getLocale();
        $session->remove('lang');
        $session->set('lang', $locale);
        return redirect()->back();
    }

    public function groups()
    {
        $groups = new Groups_Libraries('https://app.conect.app', 'B6D711FCDE4D4FD5936544120E713976', 'watsapp_dinamus');
        return $this->response->setJSON($groups->listGroups());
    }

    public function sair()
    {
        session_destroy();
        //$pass = password_hash('mudar@123', PASSWORD_BCRYPT);
        return redirect()->to('login');
    }

    public function sendtest()
    {
        $client = \Config\Services::curlrequest();

        $numeros = "120363164779026197@g.us, 120363146239734242@g.us, 120363166983881103@g.us, 120363149775262110@g.us";

        $separa = explode(',', str_replace(' ', '', $numeros));

        $message = "Isso é uma mensagem de teste!!!
        
        https://pay.kiwify.com.br/IRuNTlO";

        $msg = str_replace("\n", "\\n", $message);

        foreach ($separa as $key => $row) {
            $posts[] = [
                'numero' => $row,
                'message' => "{$key} - {$msg}"
            ];
        }

        $headers = array(
            'Accept' =>  '*/*',
            'Content-Type' => 'application/json',
            'user-agent' => "CI4"
        );

        $url = 'https://n8.conect.app/webhook-test/b1dac78c-c762-4697-9ed4-9dbea2fe722f';

        // Enviar a solicitação POST
        $response = $client->request('POST', $url, [
            'json' => $posts,
            'headers' => $headers
        ]);

        // Obter o corpo da resposta como string
        $responseBody = $response->getBody();

        // Decodificar a resposta como JSON e retornar os dados decodificados
        $json[] = json_decode($responseBody, true);

        return $this->response->setJSON(['body' => $posts]);
    }


    public function group($page, $id): string
    {

        if ($page == 'l') {
            $p = "light";
        } elseif ($page == 'd') {
            $p = "dark";
        } elseif ($page == 'g') {
            $p = "green";
        } else {
            $p = "light";
        }

        return view('pages/' . $p);
    }
}
