<?php

namespace App\Models;

use CodeIgniter\Model;

class GroupModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'groups';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'instance','id_group', 'subject', 'subject_owner', 'subject_time', 'size', 'creation', 'owner', 'restrict', 'announce', 'desc', 'desc_id'
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
    

    public function getFormattedSenderGroups($senderIds)
    {
        $listGroups = "";

        foreach ($senderIds as $searchGroupList) {
            $group = $this->where('id_group', $searchGroupList)->first();
            if ($group) {
                $listGroups .= $group['subject'] . ", ";
            }
        }

        return rtrim($listGroups, ", ");
    }
}
