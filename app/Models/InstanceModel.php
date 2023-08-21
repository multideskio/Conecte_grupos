<?php

namespace App\Models;

use CodeIgniter\Model;

class InstanceModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'instances';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_company',
        'name',
        'phone',
        'profile_name',
        'profile_picture_url',
        'profile_status',
        'status',
        'server_url',
        'api_key',
        'owner' 
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    public function controlAccess(){
        if(session('')['']){

        }else{

        }

        return $this->findAll();
    }
}
