<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomSubMenu extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'seo_custom_sub_menu';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['sub_menu', 'sub_menu_link', 'menu_id', 'created_by'];

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


    public function save_record($data= null){
        $this->db = \Config\Database::connect();
        $sql = "SELECT * FROM `seo_custom_sub_menu` WHERE `menu_id`=".$data['menu_id']." AND `sub_menu` = '".$data['sub_menu']."' ";
        $result = $this->db->query($sql);
        return count($result->getResult());
    }
}
