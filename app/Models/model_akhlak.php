<?php

namespace App\Models;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;


class model_akhlak extends Model
{
    protected $db;
    // protected $table      = 'ref_akhlak';
    // protected $primaryKey = 'id_akhlak';
    // protected $useAutoIncrement = true;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    public function getAllakhlak($length, $start, $search){
        return $this->db->table('ref_akhlak')
                        ->select('*')
                        ->where('active', 1)
                        ->like('nm_akhlak', $search)
                        ->get($length, $start)
                        ->getResultArray();
    }

    public function getCountAllakhlak($length, $start, $search){

        $count = array();
        // $this->db->select('count(id_akhlak) as recordsFiltered');
        $count['recordsFiltered'] = $this->db->table('ref_akhlak')
                                             ->select('count(id_akhlak) as recordsFiltered')
                                             ->where('active', 1)
                                             ->like('nm_akhlak', $search)
                                             ->get()
                                             ->getRowArray()['recordsFiltered'];
                                             
        $count['recordsTotal'] = $this->db->table('ref_akhlak')
                                             ->select('count(id_akhlak) as recordsTotal')
                                             ->where('active', 1)
                                             ->like('nm_akhlak', $search)
                                             ->get()
                                             ->getRowArray()['recordsTotal'];

        return $count;
    }

    public function getakhlakById($id_akhlak){
        return $this->db->table('ref_akhlak')
                        ->select('*')
                        ->where('active', 1)
                        ->where('id_akhlak', $id_akhlak)
                        ->get()
                        ->getRowArray();
    }

    public function insert_akhlak($data){
        $this->db->table('ref_akhlak')
                        ->insert($data);
        return $this->db->insertID();
    }

    public function update_akhlak($data){
        $this->db->table('ref_akhlak')
                 ->where('id_akhlak', $data['id_akhlak'])
                 ->update($data);
        return $data['id_akhlak'];
    }


    public function delete_akhlak($data){
        $this->db->table('ref_akhlak')
                 ->where('id_akhlak', $data['id_akhlak'])
                 ->update($data);
        return $data['id_akhlak'];
    }

}