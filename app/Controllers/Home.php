<?php

namespace App\Controllers;

use App\Libraries\Groups_Libraries;

class Home extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }

    public function groups()
    {
        $groups = new Groups_Libraries('https://app.conect.app', 'B6D711FCDE4D4FD5936544120E713976', 'watsapp_dinamus');
        return $this->response->setJSON($groups->listGroups());
    }

    public function sair(){
        session_destroy();
        $pass = password_hash('mudar@123', PASSWORD_BCRYPT);

        echo $pass;
    }

    public function sendtest(){
        $client = \Config\Services::curlrequest();

        $numeros = "120363164779026197@g.us, 120363146239734242@g.us, 120363166983881103@g.us, 120363149775262110@g.us";

        $separa = explode(', ', $numeros);

        foreach($separa as $key => $row){
            $posts[] = [
                'numero' => $row,
                'message' => "{$key} - Isso é uma mensagem de teste!!! https://pay.kiwify.com.br/IRuNTlO"
            ];
        }

        $headers = array(
            'Accept' =>  '*/*',
            'Content-Type' => 'application/json',
            'user-agent' => "CI4"
        );

        $url = 'https://n8.conect.app/webhook-test/b1dac78c-c762-4697-9ed4-9dbea2fe722f';

        // Enviar a solicitação POST
       // $response = $client->request('POST', $url, [
        //    'json' => $posts,
      //      'headers' => $headers
       // ]);

        // Obter o corpo da resposta como string
      //  $responseBody = $response->getBody();
        
        // Decodificar a resposta como JSON e retornar os dados decodificados
      //  $json[] = json_decode($responseBody, true);

        return $this->response->setJSON(['body' => $posts]) ;
    }
}