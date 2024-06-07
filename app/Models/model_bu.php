<?php

namespace App\Models;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;


class model_bu extends Model
{
    protected $db;
    // protected $table      = 'sso.ref_bu';
    // protected $primaryKey = 'id_bu';
    // protected $useAutoIncrement = true;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    public function getAllbu($length, $start, $search){
        return $this->db->table('sso.ref_bu')
                        ->select('*')
                        ->where('active', 1)
                        ->like('nm_bu', $search)
                        ->get($length, $start)
                        ->getResultArray();
    }

    public function getCountAllbu($length, $start, $search){

        $count = array();
        // $this->db->select('count(id_bu) as recordsFiltered');
        $count['recordsFiltered'] = $this->db->table('sso.ref_bu')
                                             ->select('count(id_bu) as recordsFiltered')
                                             ->where('active', 1)
                                             ->like('nm_bu', $search)
                                             ->get()
                                             ->getRowArray()['recordsFiltered'];
                                             
        $count['recordsTotal'] = $this->db->table('sso.ref_bu')
                                             ->select('count(id_bu) as recordsTotal')
                                             ->where('active', 1)
                                             ->like('nm_bu', $search)
                                             ->get()
                                             ->getRowArray()['recordsTotal'];

        return $count;
    }

    public function getbuById($id_bu){
        return $this->db->table('sso.ref_bu')
                        ->select('*')
                        ->where('active', 1)
                        ->where('id_bu', $id_bu)
                        ->get()
                        ->getRowArray();
    }

    public function insert_bu($data){
        $this->db->table('sso.ref_bu')
                        ->insert($data);
        return $this->db->insertID();
    }

    public function update_bu($data){
        $this->db->table('sso.ref_bu')
                 ->where('id_bu', $data['id_bu'])
                 ->update($data);
        return $data['id_bu'];
    }


    public function delete_bu($data){
        $this->db->table('sso.ref_bu')
                 ->where('id_bu', $data['id_bu'])
                 ->update($data);
        return $data['id_bu'];
    }


    //BUSSINESS UNIT ACCESS

    public function getAllbu_access($length, $start, $search, $id_bu){
        return $this->db->table('ref_bu_access a')
                        ->select('a.*, b.nm_user')
                        ->join('sso.ref_user b', 'a.id_user = b.id_user', 'left')
                        ->where('a.active', 1)
                        ->where('a.id_bu', $id_bu)
                        ->like('b.nm_user', $search)
                        ->get($start, $length)
                        ->getResultArray();
    }

    public function getCountAllbu_access($length, $start, $search, $id_bu){

        $count = array();

        $count['recordsFiltered'] = $this->db->table('ref_bu_access a')
                                             ->select('count(a.id_bu) as recordsFiltered')
                                             ->join('sso.ref_user b', 'a.id_user = b.id_user', 'left')
                                             ->where('a.active', 1)
                                             ->where('a.id_bu', $id_bu)
                                             ->like('b.nm_user', $search)
                                             ->get()
                                             ->getRowArray()['recordsFiltered'];
                                             
        $count['recordsTotal'] = $this->db->table('ref_bu_access')
                                             ->select('count(id_bu) as recordsTotal')
                                             ->where('active', 1)
                                             ->where('id_bu', $id_bu)
                                             ->get()
                                             ->getRowArray()['recordsTotal'];

        return $count;
    }

    public function getbu_accessById($id_bu_access){
        return $this->db->table('ref_bu_access')
                        ->select('*')
                        ->where('active', 1)
                        ->where('id_bu_access', $id_bu_access)
                        ->get()
                        ->getRowArray();
    }

    public function insert_bu_access($data){
        $this->db->table('ref_bu_access')
                        ->insert($data);
        return $this->db->insertID();
    }

    public function update_bu_access($data){
        $this->db->table('ref_bu_access')
                 ->where('id_bu_access', $data['id_bu_access'])
                 ->update($data);
        return $data['id_bu_access'];
    }


    public function delete_bu_access($data){
        $this->db->table('ref_bu_access')
                 ->where('id_bu_access', $data['id_bu_access'])
                 ->update($data);
        return $data['id_bu_access'];
    }




    //COMBOBOX
    public function combobox_user(){
        return $this->db->table('sso.ref_user')
                        ->select('id_user, nm_user, username')
                        ->where('active', 1)
                        ->get()
                        ->getResultArray();
    }

}