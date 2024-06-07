<?php

namespace App\Models;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;


class model_tahun extends Model
{
    protected $db;
    // protected $table      = 'ref_tahun';
    // protected $primaryKey = 'id_tahun';
    // protected $useAutoIncrement = true;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    public function getAlltahun($length, $start, $search){
        return $this->db->table('ref_tahun')
                        ->select('*')
                        ->where('active', 1)
                        ->like('nm_tahun', $search)
                        ->get($start, $length)
                        ->getResultArray();
    }

    public function getCountAlltahun($length, $start, $search){

        $count = array();
        // $this->db->select('count(id_tahun) as recordsFiltered');
        $count['recordsFiltered'] = $this->db->table('ref_tahun')
                                             ->select('count(id_tahun) as recordsFiltered')
                                             ->where('active', 1)
                                             ->like('nm_tahun', $search)
                                             ->get()
                                             ->getRowArray()['recordsFiltered'];
                                             
        $count['recordsTotal'] = $this->db->table('ref_tahun')
                                             ->select('count(id_tahun) as recordsTotal')
                                             ->where('active', 1)
                                             ->like('nm_tahun', $search)
                                             ->get()
                                             ->getRowArray()['recordsTotal'];

        return $count;
    }

    public function gettahunById($id_tahun){
        return $this->db->table('ref_tahun')
                        ->select('*')
                        ->where('active', 1)
                        ->where('id_tahun', $id_tahun)
                        ->get()
                        ->getRowArray();
    }

    public function insert_tahun($data){
        $this->db->table('ref_tahun')
                        ->insert($data);
        return $this->db->insertID();
    }

    public function update_tahun($data){
        $this->db->table('ref_tahun')
                 ->where('id_tahun', $data['id_tahun'])
                 ->update($data);
        return $data['id_tahun'];
    }


    public function delete_tahun($data){
        $this->db->table('ref_tahun')
                 ->where('id_tahun', $data['id_tahun'])
                 ->update($data);
        return $data['id_tahun'];
    }

}