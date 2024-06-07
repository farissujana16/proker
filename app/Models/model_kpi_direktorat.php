<?php

namespace App\Models;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;


class model_kpi_direktorat extends Model
{
    protected $db;
    // protected $table      = 'ref_kpi_direktorat';
    // protected $primaryKey = 'id_kpi_direktorat';
    // protected $useAutoIncrement = true;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    public function getAllkpi_direktorat($length, $start, $search){
        return $this->db->table('ref_kpi_direktorat a')
                        ->select('a.*')
                        ->where('a.active', 1)
                        ->like('a.nm_kpi_direktorat', $search)
                        ->get($length, $start)
                        ->getResultArray();
    }

    public function getCountAllkpi_direktorat($length, $start, $search){

        $count = array();
        // $this->db->select('count(id_kpi_direktorat) as recordsFiltered');
        $count['recordsFiltered'] = $this->db->table('ref_kpi_direktorat a')
                                             ->select('count(a.id_kpi_direktorat) as recordsFiltered')
                                             ->where('a.active', 1)
                                             ->like('a.nm_kpi_direktorat', $search)
                                             ->get()
                                             ->getRowArray()['recordsFiltered'];
                                             
        $count['recordsTotal'] = $this->db->table('ref_kpi_direktorat a')
                                             ->select('count(a.id_kpi_direktorat) as recordsTotal')
                                             ->where('a.active', 1)
                                             ->get()
                                             ->getRowArray()['recordsTotal'];

        return $count;
    }

    public function getkpi_direktoratById($id_kpi_direktorat){
        return $this->db->table('ref_kpi_direktorat')
                        ->select('*')
                        ->where('active', 1)
                        ->where('id_kpi_direktorat', $id_kpi_direktorat)
                        ->get()
                        ->getRowArray();
    }

    public function insert_kpi_direktorat($data){
        $this->db->table('ref_kpi_direktorat')
                        ->insert($data);
        return $this->db->insertID();
    }

    public function update_kpi_direktorat($data){
        $this->db->table('ref_kpi_direktorat')
                 ->where('id_kpi_direktorat', $data['id_kpi_direktorat'])
                 ->update($data);
        return $data['id_kpi_direktorat'];
    }


    public function delete_kpi_direktorat($data){
        $this->db->table('ref_kpi_direktorat')
                 ->where('id_kpi_direktorat', $data['id_kpi_direktorat'])
                 ->update($data);
        return $data['id_kpi_direktorat'];
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