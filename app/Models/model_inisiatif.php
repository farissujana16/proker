<?php

namespace App\Models;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;


class model_inisiatif extends Model
{
    protected $db;
    // protected $table      = 'ref_inisiatif';
    // protected $primaryKey = 'id_inisiatif';
    // protected $useAutoIncrement = true;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    public function getAllinisiatif($length, $start, $search){
        return $this->db->table('ref_inisiatif a')
                        ->select('a.*, b.nm_perspektif')
                        ->join('ref_perspektif b', 'a.id_perspektif = b.id_perspektif', 'left')
                        ->where('a.active', 1)
                        ->like('a.nm_inisiatif', $search)
                        ->get($length, $start)
                        ->getResultArray();
    }

    public function getCountAllinisiatif($length, $start, $search){

        $count = array();
        // $this->db->select('count(id_inisiatif) as recordsFiltered');
        $count['recordsFiltered'] = $this->db->table('ref_inisiatif a')
                                             ->select('count(a.id_inisiatif) as recordsFiltered')
                                             ->join('ref_perspektif b', 'a.id_perspektif = b.id_perspektif', 'left')
                                             ->where('a.active', 1)
                                             ->like('a.nm_inisiatif', $search)
                                             ->get()
                                             ->getRowArray()['recordsFiltered'];
                                             
        $count['recordsTotal'] = $this->db->table('ref_inisiatif a')
                                             ->select('count(a.id_inisiatif) as recordsTotal')
                                             ->join('ref_perspektif b', 'a.id_perspektif = b.id_perspektif', 'left')
                                             ->where('a.active', 1)
                                             ->get()
                                             ->getRowArray()['recordsTotal'];

        return $count;
    }

    public function getinisiatifById($id_inisiatif){
        return $this->db->table('ref_inisiatif')
                        ->select('*')
                        ->where('active', 1)
                        ->where('id_inisiatif', $id_inisiatif)
                        ->get()
                        ->getRowArray();
    }

    public function insert_inisiatif($data){
        $this->db->table('ref_inisiatif')
                        ->insert($data);
        return $this->db->insertID();
    }

    public function update_inisiatif($data){
        $this->db->table('ref_inisiatif')
                 ->where('id_inisiatif', $data['id_inisiatif'])
                 ->update($data);
        return $data['id_inisiatif'];
    }


    public function delete_inisiatif($data){
        $this->db->table('ref_inisiatif')
                 ->where('id_inisiatif', $data['id_inisiatif'])
                 ->update($data);
        return $data['id_inisiatif'];
    }

    //COMBOBOX
    public function combobox_perspektif(){
        return $this->db->table('ref_perspektif')
                        ->select('*')
                        ->where('active', 1)
                        ->get()
                        ->getResultArray();
    }
}