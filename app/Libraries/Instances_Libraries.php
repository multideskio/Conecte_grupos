<?php

namespace App\Libraries;

class instances_libraries
{
    /**
     * 
     * BUSCA DADOS DIRETO DA API
     * 
     */
    private $apiUrl;
    private $apiKey;

    public function __construct($apiUrl, $apiKey)
    {
        $this->apiUrl = $apiUrl;
        $this->apiKey = $apiKey;
    }
    public function show($urlApi, $keyApi)
    {
        $rowSuperAdmin = ''; 
    }
}
