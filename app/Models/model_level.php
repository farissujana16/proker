<?php

namespace App\Models;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;


class model_level extends Model
{
    protected $db;
    // protected $table      = 'ref_level';
    // protected $primaryKey = 'id_level';
    // protected $useAutoIncrement = true;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    public function getAllLevel($length, $start, $search){
        return $this->db->table('ref_level')
                        ->select('*')
                        ->where('active', 1)
                        ->like('nm_level', $search)
                        ->get($start, $length)
                        ->getResultArray();
    }

    public function getCountAllLevel($length, $start, $search){

        $count = array();
        // $this->db->select('count(id_level) as recordsFiltered');
        $count['recordsFiltered'] = $this->db->table('ref_level')
                                             ->select('count(id_level) as recordsFiltered')
                                             ->where('active', 1)
                                             ->like('nm_level', $search)
                                             ->get()
                                             ->getRowArray()['recordsFiltered'];
                                             
        $count['recordsTotal'] = $this->db->table('ref_level')
                                             ->select('count(id_level) as recordsTotal')
                                             ->where('active', 1)
                                             ->like('nm_level', $search)
                                             ->get()
                                             ->getRowArray()['recordsTotal'];

        return $count;
    }

    public function getLevelById($id_level){
        return $this->db->table('ref_level')
                        ->select('*')
                        ->where('active', 1)
                        ->where('id_level', $id_level)
                        ->get()
                        ->getRowArray();
    }

    public function insert_level($data){
        $this->db->table('ref_level')
                        ->insert($data);
        return $this->db->insertID();
    }

    public function update_level($data){
        $this->db->table('ref_level')
                 ->where('id_level', $data['id_level'])
                 ->update($data);
        return $data['id_level'];
    }


    public function delete_level($data){
        $this->db->table('ref_level')
                 ->where('id_level', $data['id_level'])
                 ->update($data);
        return $data['id_level'];
    }


    //MENU GROUPS ACCESS PAGE

    public function getAlllevel_groups_access($length, $start, $search, $id_level){
        return $this->db->table('ref_menu_groups a')
                        ->select('a.id_menu_groups, a.nm_menu_groups, 
                            COALESCE (( SELECT active FROM ref_menu_groups_access WHERE id_menu_groups = a.id_menu_groups AND id_level = '.$id_level.' ),0 ) as active,
                            COALESCE (( SELECT id_menu_groups_access FROM ref_menu_groups_access WHERE id_menu_groups = a.id_menu_groups AND id_level = '.$id_level.' ),0 ) as id_menu_groups_access')
                        ->where('a.active', 1)
                        ->like('a.nm_menu_groups', $search)
                        ->get($length, $start)
                        ->getResultArray();
    }

    public function getCountAlllevel_groups_access($length, $start, $search){

        $count = array();
        // $this->db->select('count(id_menu_details) as recordsFiltered');
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


    public function save_groups_access_data($data){
        $this->db->table('ref_menu_groups_access')
                        ->insert($data);
        return $this->db->insertID();
    }

    public function update_groups_access_data($data){
        $this->db->table('ref_menu_groups_access')
                 ->where('id_menu_groups_access', $data['id_menu_groups_access'])
                 ->update($data);
        return $data['id_menu_groups_access'];
    }



    //MENU DETAILS ACCESS PAGE

    public function getAlllevel_details_access($length, $start, $search, $id_level){
        return $this->db->table('ref_menu_details a')
                        ->select('a.id_menu_details, a.nm_menu_details, 
                            COALESCE (( SELECT active FROM ref_menu_details_access WHERE id_menu_details = a.id_menu_details AND id_level = '.$id_level.' ),0 ) as active,
                            COALESCE (( SELECT id_menu_details_access FROM ref_menu_details_access WHERE id_menu_details = a.id_menu_details AND id_level = '.$id_level.' ),0 ) as id_menu_details_access')
                        ->where('a.active', 1)
                        ->like('a.nm_menu_details', $search)
                        ->get($length, $start)
                        ->getResultArray();
    }

    public function getCountAlllevel_details_access($length, $start, $search){

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


    public function save_details_access_data($data){
        $this->db->table('ref_menu_details_access')
                        ->insert($data);
        return $this->db->insertID();
    }

    public function update_details_access_data($data){
        $this->db->table('ref_menu_details_access')
                 ->where('id_menu_details_access', $data['id_menu_details_access'])
                 ->update($data);
        return $data['id_menu_details_access'];
    }

}