<?php

namespace App\Models;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;


class model_satuan extends Model
{
    protected $db;
    // protected $table      = 'ref_satuan';
    // protected $primaryKey = 'id_satuan';
    // protected $useAutoIncrement = true;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    public function getAllsatuan($length, $start, $search){
        return $this->db->table('ref_satuan')
                        ->select('*')
                        ->where('active', 1)
                        ->like('nm_satuan', $search)
                        ->get($length, $start)
                        ->getResultArray();
    }

    public function getCountAllsatuan($length, $start, $search){

        $count = array();
        // $this->db->select('count(id_satuan) as recordsFiltered');
        $count['recordsFiltered'] = $this->db->table('ref_satuan')
                                             ->select('count(id_satuan) as recordsFiltered')
                                             ->where('active', 1)
                                             ->like('nm_satuan', $search)
                                             ->get()
                                             ->getRowArray()['recordsFiltered'];
                                             
        $count['recordsTotal'] = $this->db->table('ref_satuan')
                                             ->select('count(id_satuan) as recordsTotal')
                                             ->where('active', 1)
                                             ->like('nm_satuan', $search)
                                             ->get()
                                             ->getRowArray()['recordsTotal'];

        return $count;
    }

    public function getsatuanById($id_satuan){
        return $this->db->table('ref_satuan')
                        ->select('*')
                        ->where('active', 1)
                        ->where('id_satuan', $id_satuan)
                        ->get()
                        ->getRowArray();
    }

    public function insert_satuan($data){
        $this->db->table('ref_satuan')
                        ->insert($data);
        return $this->db->insertID();
    }

    public function update_satuan($data){
        $this->db->table('ref_satuan')
                 ->where('id_satuan', $data['id_satuan'])
                 ->update($data);
        return $data['id_satuan'];
    }


    public function delete_satuan($data){
        $this->db->table('ref_satuan')
                 ->where('id_satuan', $data['id_satuan'])
                 ->update($data);
        return $data['id_satuan'];
    }

}