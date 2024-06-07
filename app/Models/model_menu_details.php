<?php

namespace App\Models;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;


class model_menu_details extends Model
{
    protected $db;
    // protected $table      = 'ref_menu_details';
    // protected $primaryKey = 'id_menu_details';
    // protected $useAutoIncrement = true;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    public function getAllmenu_details($length, $start, $search){
        return $this->db->table('ref_menu_details a')
                        ->select('a.*, b.nm_menu_groups')
                        ->join('ref_menu_groups b', 'a.id_menu_groups = b.id_menu_groups', 'left')
                        ->where('a.active', 1)
                        ->like('a.nm_menu_details', $search)
                        ->orderBy('a.id_menu_groups')
                        ->get($length, $start)
                        ->getResultArray();
    }

    public function getCountAllmenu_details($length, $start, $search){

        $count = array();
        // $this->db->select('count(id_menu_details) as recordsFiltered');
        $count['recordsFiltered'] = $this->db->table('ref_menu_details')
                                             ->select('count(id_menu_details) as recordsFiltered')
                                             ->where('active', 1)
                                             ->like('nm_menu_details', $search)
                                             ->get()
                                             ->getRowArray()['recordsFiltered'];
                                             
        $count['recordsTotal'] = $this->db->table('ref_menu_details')
                                             ->select('count(id_menu_details) as recordsTotal')
                                             ->where('active', 1)
                                             ->like('nm_menu_details', $search)
                                             ->get()
                                             ->getRowArray()['recordsTotal'];

        return $count;
    }

    public function getmenu_detailsById($id_menu_details){
        return $this->db->table('ref_menu_details')
                        ->select('*')
                        ->where('active', 1)
                        ->where('id_menu_details', $id_menu_details)
                        ->get()
                        ->getRowArray();
    }

    public function insert_menu_details($data){
        $this->db->table('ref_menu_details')
                        ->insert($data);
        return $this->db->insertID();
    }

    public function update_menu_details($data){
        $this->db->table('ref_menu_details')
                 ->where('id_menu_details', $data['id_menu_details'])
                 ->update($data);
        return $data['id_menu_details'];
    }


    public function delete_menu_details($data){
        $this->db->table('ref_menu_details')
                 ->where('id_menu_details', $data['id_menu_details'])
                 ->update($data);
        return $data['id_menu_details'];
    }


    public function combobox_menu_groups(){
        return $this->db->table('ref_menu_groups')
                        ->where('active',1)
                        ->get()
                        ->getResultArray();
        
    }

}