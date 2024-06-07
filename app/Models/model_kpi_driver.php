<?php

namespace App\Models;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;


class model_kpi_driver extends Model
{
    protected $db;
    // protected $table      = 'tr_kpi_driver';
    // protected $primaryKey = 'id_kpi_driver';
    // protected $useAutoIncrement = true;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    public function getAllkpi_driver($length, $start, $search, $tahun){
        return $this->db->table('tr_kpi_driver')
                        ->select('*')
                        ->where('tahun', $tahun)
                        ->where('active', 1)
                        ->like('nm_kpi_driver', $search)
                        ->get($length, $start)
                        ->getResultArray();
    }

    public function getCountAllkpi_driver($length, $start, $search, $tahun){

        $count = array();
        // $this->db->select('count(id_kpi_driver) as recordsFiltered');
        $count['recordsFiltered'] = $this->db->table('tr_kpi_driver')
                                             ->select('count(id_kpi_driver) as recordsFiltered')
                                             ->where('active', 1)
                                             ->where('tahun', $tahun)
                                             ->like('nm_kpi_driver', $search)
                                             ->get()
                                             ->getRowArray()['recordsFiltered'];
                                             
        $count['recordsTotal'] = $this->db->table('tr_kpi_driver')
                                             ->select('count(id_kpi_driver) as recordsTotal')
                                             ->where('active', 1)
                                             ->where('tahun', $tahun)
                                             ->like('nm_kpi_driver', $search)
                                             ->get()
                                             ->getRowArray()['recordsTotal'];

        return $count;
    }

    public function getkpi_driverById($id_kpi_driver){
        return $this->db->table('tr_kpi_driver')
                        ->select('*')
                        ->where('active', 1)
                        ->where('id_kpi_driver', $id_kpi_driver)
                        ->get()
                        ->getRowArray();
    }

    public function insert_kpi_driver($data){
        $this->db->table('tr_kpi_driver')
                        ->insert($data);
        return $this->db->insertID();
    }

    public function update_kpi_driver($data){
        $this->db->table('tr_kpi_driver')
                 ->where('id_kpi_driver', $data['id_kpi_driver'])
                 ->update($data);
        return $data['id_kpi_driver'];
    }


    public function delete_kpi_driver($data){
        $this->db->table('tr_kpi_driver')
                 ->where('id_kpi_driver', $data['id_kpi_driver'])
                 ->update($data);
        return $data['id_kpi_driver'];
    }


    //COMBOBOX

    public function combobox_satuan(){
        return $this->db->table('ref_satuan')
                        ->select('id_satuan, nm_satuan')
                        ->where('active', 1)
                        ->get()
                        ->getResultArray();
    }

}