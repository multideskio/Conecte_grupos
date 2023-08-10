<?php

namespace App\Controllers\Api;

use App\Libraries\Groups_Libraries;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class Groups extends ResourceController
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
    
    public function index($instancia = false)
    {
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        //
        $groups = new Groups_Libraries('https://noreply.conect.app', '9070AC39-C742-4134-87EE-03365594ABF1', 'whatsapp');
        return $this->respond($groups->listGroups('false'));
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
        $posts = $this->request->getPost();
        $groups = new Groups_Libraries('https://noreply.conect.app', '9070AC39-C742-4134-87EE-03365594ABF1', 'whatsapp');
        $create = $groups->createGroups($posts['numbers'], $posts['name']);

        return $this->respond($create);
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

    public function sendMessage()
    {
        $posts = $this->request->getPost();
        $listaDestino = explode(', ', $posts['destino']);
        $groups = new Groups_Libraries('https://noreply.conect.app', '9070AC39-C742-4134-87EE-03365594ABF1', 'whatsapp');
        try {
            $sends = $groups->sendMessage($listaDestino, $posts['message'], (isset($posts['mentions'])) ? true : false);
            return $this->respond(['code' => 200, 'status' => 'ok', 'sends' => $sends]);
        } catch (\Exception $e) {
            return $this->fail($e->getMessage());
        }
    }
}
