<?php

namespace App\Models;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;


class model_kompetensi extends Model
{
    protected $db;
    // protected $table      = 'ref_kompetensi';
    // protected $primaryKey = 'id_kompetensi';
    // protected $useAutoIncrement = true;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    public function getAllkompetensi($length, $start, $search){
        return $this->db->table('ref_kompetensi')
                        ->select('*')
                        ->where('active', 1)
                        ->like('nm_kompetensi', $search)
                        ->get($length, $start)
                        ->getResultArray();
    }

    public function getCountAllkompetensi($length, $start, $search){

        $count = array();
        // $this->db->select('count(id_kompetensi) as recordsFiltered');
        $count['recordsFiltered'] = $this->db->table('ref_kompetensi')
                                             ->select('count(id_kompetensi) as recordsFiltered')
                                             ->where('active', 1)
                                             ->like('nm_kompetensi', $search)
                                             ->get()
                                             ->getRowArray()['recordsFiltered'];
                                             
        $count['recordsTotal'] = $this->db->table('ref_kompetensi')
                                             ->select('count(id_kompetensi) as recordsTotal')
                                             ->where('active', 1)
                                             ->like('nm_kompetensi', $search)
                                             ->get()
                                             ->getRowArray()['recordsTotal'];

        return $count;
    }

    public function getkompetensiById($id_kompetensi){
        return $this->db->table('ref_kompetensi')
                        ->select('*')
                        ->where('active', 1)
                        ->where('id_kompetensi', $id_kompetensi)
                        ->get()
                        ->getRowArray();
    }

    public function insert_kompetensi($data){
        $this->db->table('ref_kompetensi')
                        ->insert($data);
        return $this->db->insertID();
    }

    public function update_kompetensi($data){
        $this->db->table('ref_kompetensi')
                 ->where('id_kompetensi', $data['id_kompetensi'])
                 ->update($data);
        return $data['id_kompetensi'];
    }


    public function delete_kompetensi($data){
        $this->db->table('ref_kompetensi')
                 ->where('id_kompetensi', $data['id_kompetensi'])
                 ->update($data);
        return $data['id_kompetensi'];
    }

}