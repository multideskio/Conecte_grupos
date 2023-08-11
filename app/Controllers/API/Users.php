<?php

namespace App\Controllers\Api;

use App\Models\CompanyModel;
use App\Models\UserModel;
use App\Services\AuthService; // Importa a classe AuthService
use App\Services\AuthServiceChatwoot;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class Users extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    use ResponseTrait;

    protected $session;


    public function __construct()
    {
        $this->session = $this->session = \Config\Services::session();
    }

    public function index()
    {
        //
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        //
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        //
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        //
    }

    /**
     * Autentica um usuário com base nas credenciais do Chatwoot.
     *
     * @param string $id_chatwoot
     * @param string $apiDashboard
     * @return mixed
     */
    public function auth($id_chatwoot, $apiDashboard)
    {
        // Injeta o AuthServiceChatwoot e os Modelos no construtor do controlador
        $authService = new AuthServiceChatwoot(new CompanyModel(), new UserModel());
        
        // Chama o método de autenticação do serviço
        $authResult = $authService->authenticate($id_chatwoot, $apiDashboard);
        
        if (is_array($authResult)) {
            return redirect()->to(site_url('chatwoot'));
            //return $this->respond($authResult); // Retorna detalhes do usuário autenticado
        } else {
            return $this->failUnauthorized($authResult); // Retorna mensagem de erro
        }
    }

    public function test($id_chatwoot, $apiDashboard)
    {
        try {

            $authService = new AuthService();
            // Chama o método authenticate do AuthService para autenticar
            $userId = $authService->authenticate($id_chatwoot, $apiDashboard);

            // Retorna a resposta de sucesso com o ID do usuário autenticado
            //return $this->respond($userId);
            return redirect()->to(site_url('chatwoot'));
        } catch (\Exception $e) {
            // Retorna a resposta de erro com a mensagem da exceção
            return $this->failUnauthorized($e->getMessage());
        }
    }
}
