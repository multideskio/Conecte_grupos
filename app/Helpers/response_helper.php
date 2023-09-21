<?php

if (!function_exists('empty_response')) {
    /**
     * Retorna uma resposta vazia com o código de status fornecido.
     *
     * @param int $statusCode Código de status HTTP
     *
     * @return ResponseInterface
     */
    function empty_response(int $statusCode)
    {
        $response = service('response');
        $response->setStatusCode($statusCode);
        return $response->setBody(null);
    }
}


if (!function_exists('nivel_access')) {
    function nivel_access($nivel)
    {
        $arr = [
            1 => 'Superadmin',
            2 => 'Admin',
            3 => 'Usuário'
        ];

        return $arr[$nivel];
    }
}


// Função para remover caracteres não numéricos dos números de telefone
if (!function_exists('cleanPhoneNumber')) {
    function cleanPhoneNumber($phoneNumber)
    {
        return preg_replace('/\D/', '', $phoneNumber);
    }
}


if (!function_exists('randomSerial')) {
    function randomSerial()
    {
        $key = implode('-', str_split(bin2hex(random_bytes(10)), 5));
        $res = $key;
        return $res;
    }
}

if (!function_exists('primaryName')) {
    function primaryName($name)
    {
        $key = explode(' ', $name);
        return $key[0];
    }
}


if (!function_exists('add_days_to_purchase_date')) {
    function add_days_to_purchase_date($purchaseDate, $daysToAdd)
    {
        $purchaseDateObj = new \DateTime($purchaseDate);
        $purchaseDateObj->modify("+$daysToAdd days");
        return $purchaseDateObj->format('Y-m-d');
    }
}

if (!function_exists('is_plan_expired')) {
    function is_plan_expired($expiryDate)
    {
        $currentDate = new \DateTime();
        $expiryDateObj = new \DateTime($expiryDate);

        return $currentDate > $expiryDateObj;
    }
}

if (!function_exists('days_until_expiry')) {
    function days_until_expiry($expiryDate)
    {
        $currentDate = new \DateTime();
        $expiryDateObj = new \DateTime($expiryDate);

        $interval = $currentDate->diff($expiryDateObj);
        return $interval->days;
    }
}

// Verifica se a função getExtensionFromUrl já foi definida para evitar conflitos
if (!function_exists('getExtensionFromUrl')) {
    // Define uma função para obter a extensão de um URL
    function getExtensionFromUrl($url)
    {
        // Usa a função pathinfo para obter informações sobre o URL
        $pathinfo = pathinfo($url);
        
        // Verifica se a chave 'extension' está definida no array retornado por pathinfo
        if (isset($pathinfo['extension'])) {
            // Retorna a extensão do arquivo
            return $pathinfo['extension'];
        }
        
        // Retorna falso se a extensão não estiver definida no URL
        return false;
    }
}

// Verifica se a função getFileTypeFromUrl já foi definida para evitar conflitos
if (!function_exists('getFileTypeFromUrl')) {
    // Define uma função para obter o tipo de arquivo a partir de um URL
    function getFileTypeFromUrl($url)
    {
        // Obtém os cabeçalhos HTTP do URL usando a função get_headers
        $headers = get_headers($url, 1);

        // Verifica se a chave 'Content-Type' está definida nos cabeçalhos
        if (isset($headers['Content-Type'])) {
            // Retorna o tipo MIME do arquivo
            return $headers['Content-Type'];
        }
        
        // Retorna falso se o tipo MIME não estiver definido nos cabeçalhos
        return false;
    }
}

if (!function_exists('cdn')) {
    function cdngroup($caminho = false)
    {
        if (!$caminho) {
            $url = "https://cdn.multidesk.io/";
        } else {
            $url = "https://cdn.multidesk.io/" . $caminho;
        }
        return $url;
    }
}


if (!function_exists('cleanFilename')) {
    function cleanFilename($filename)
    {
        // Remove acentuação
        $cleaned = iconv('UTF-8', 'ASCII//TRANSLIT', $filename);

        // Remove caracteres especiais, exceto letras, números e espaços
        $cleaned = preg_replace('/[^A-Za-z0-9\s\-\.]/', '', $cleaned);

        // Substitui espaços por hífens
        $cleaned = preg_replace('/\s+/', '-', $cleaned);
        $cleaned = preg_replace('/-+/', '-', $cleaned);
        $cleaned = trim($cleaned, '-');

        return $cleaned;
    }
}


if(!function_exists('badgeStatus')){
    function badgeStatus($status){

        if($status == 'add'){
            $result = '<span class="badge bg-success">Adicionado ao grupo</span>';
        }elseif($status == "promote"){
            $result = '<span class="badge bg-info">Promovido</span>';
        }elseif($status == "remove"){
            $result = '<span class="badge bg-danger">Removido</span>';
        }else{
            $result = '<span class="badge bg-warning">{$status}</span>';
        }

        return $result ;
    }
}