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
