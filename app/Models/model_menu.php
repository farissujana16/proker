<?php

namespace App\Models;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;


class model_menu extends Model
{
    protected $db;
    // protected $table      = 'ref_level';
    // protected $primaryKey = 'id_level';
    // protected $useAutoIncrement = true;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }


    public function selectaccess($id_level, $kd_menu){
        $query = $this->db->table('ref_menu_details_access a')
                      ->join('ref_menu_details b', 'a.id_menu_details = b.id_menu_details', 'left')
                      ->where('a.id_level', $id_level)
                      ->where('b.kd_menu_details', $kd_menu)
                      ->where('a.active', 1)
                      ->get()
                      ->getRowArray();
        if (!empty($query)) {
            $result = $query;
            return $result;
        } else {
            return false;
        }
    }
    

}