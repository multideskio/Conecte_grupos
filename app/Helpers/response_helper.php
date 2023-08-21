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


if(!function_exists('randomSerial')){
    function randomSerial(){
        $key = implode('-', str_split(bin2hex(random_bytes(10)), 5));
        $res = $key ;
        return $res;
    }
}

if(!function_exists('primaryName')){
    function primaryName($name){
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
