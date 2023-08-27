<?php

namespace App\Controllers\Api;

use App\Libraries\instances_libraries;
use App\Models\InstanceModel;
use App\Models\SuperModel;
use App\Services\InstanceService;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class Instances extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    use ResponseTrait;

    protected $client;

    public function __construct()
    {
        $this->client = \Config\Services::curlrequest();
    }

    public function index()
    {
        //
        if (session('user')['permission'] == 2) {
            $mInstances = new InstanceModel();
            return $this->respond($mInstances->where('id_company', session('user')['company'])->findAll());
        } elseif (session('user')['permission'] == 1) {
            $mInstances = new InstanceModel();
            return $this->respond($mInstances->findAll());
        }
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        //
        try {
            $instanceService = new InstanceService();
            $instanceService->verifyPlan();
            return $this->respond(['sincronized']);
        } catch (\Exception $e) {
            return $this->fail($e->getMessage());
        }
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

    public function import()
    {
        try {
            $mAdmin = new SuperModel();
            $dadosAdmin = $mAdmin->find(session('user')['admin']);
            $instances = new instances_libraries($dadosAdmin['url_api_wa'], $dadosAdmin['api_key_wa']);
            $instances->import();
            return $this->create();
        } catch (\Exception $e) {
            return $this->failUnauthorized($e->getMessage());
        }
    }

    public function disconnect()
    {

        $input = $this->request->getVar();
        $sInstance = new InstanceService;
        try {

            $sDisconnect = $sInstance->disconnect($input);
            //$sInstance->verifyPlan();
            return $this->respond($sDisconnect);
        } catch (\Exception $e) {

            return $this->fail($e->getMessage());
        }
    }

    public function restart()
    {
        $input = $this->request->getVar();

        $sInstance = new InstanceService;

        try {
            $sDisconnect = $sInstance->restart($input);
            sleep(3);
            $sInstance->verifyPlan();
            return $this->respond($sDisconnect);
        } catch (\Exception $e) {
            return $this->fail($e->getMessage());
        }
    }

    public function conectar()
    {
        $input      = $this->request->getVar();
        $sInstance  = new InstanceService;
        $sConnect   = $sInstance->conectar($input);
        
        return $this->respond($sConnect);
    }
}
