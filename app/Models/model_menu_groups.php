<?php

namespace App\Models;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;


class model_menu_groups extends Model
{
    protected $db;
    // protected $table      = 'ref_menu_groups';
    // protected $primaryKey = 'id_menu_groups';
    // protected $useAutoIncrement = true;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    public function getAllmenu_groups($length, $start, $search){
        return $this->db->table('ref_menu_groups')
                        ->select('*')
                        ->where('active', 1)
                        ->like('nm_menu_groups', $search)
                        ->get($start, $length)
                        ->getResultArray();
    }

    public function getCountAllmenu_groups($length, $start, $search){

        $count = array();
        // $this->db->select('count(id_menu_groups) as recordsFiltered');
        $count['recordsFiltered'] = $this->db->table('ref_menu_groups')
                                             ->select('count(id_menu_groups) as recordsFiltered')
                                             ->where('active', 1)
                                             ->like('nm_menu_groups', $search)
                                             ->get()
                                             ->getRowArray()['recordsFiltered'];
                                             
        $count['recordsTotal'] = $this->db->table('ref_menu_groups')
                                             ->select('count(id_menu_groups) as recordsTotal')
                                             ->where('active', 1)
                                             ->like('nm_menu_groups', $search)
                                             ->get()
                                             ->getRowArray()['recordsTotal'];

        return $count;
    }

    public function getmenu_groupsById($id_menu_groups){
        return $this->db->table('ref_menu_groups')
                        ->select('*')
                        ->where('active', 1)
                        ->where('id_menu_groups', $id_menu_groups)
                        ->get()
                        ->getRowArray();
    }

    public function insert_menu_groups($data){
        $this->db->table('ref_menu_groups')
                        ->insert($data);
        return $this->db->insertID();
    }

    public function update_menu_groups($data){
        $this->db->table('ref_menu_groups')
                 ->where('id_menu_groups', $data['id_menu_groups'])
                 ->update($data);
        return $data['id_menu_groups'];
    }


    public function delete_menu_groups($data){
        $this->db->table('ref_menu_groups')
                 ->where('id_menu_groups', $data['id_menu_groups'])
                 ->update($data);
        return $data['id_menu_groups'];
    }

}