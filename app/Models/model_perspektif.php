<?php

namespace App\Models;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;


class model_perspektif extends Model
{
    protected $db;
    // protected $table      = 'ref_perspektif';
    // protected $primaryKey = 'id_perspektif';
    // protected $useAutoIncrement = true;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    public function getAllperspektif($length, $start, $search){
        return $this->db->table('ref_perspektif')
                        ->select('*')
                        ->where('active', 1)
                        ->like('nm_perspektif', $search)
                        ->get($length, $start)
                        ->getResultArray();
    }

    public function getCountAllperspektif($length, $start, $search){

        $count = array();
        // $this->db->select('count(id_perspektif) as recordsFiltered');
        $count['recordsFiltered'] = $this->db->table('ref_perspektif')
                                             ->select('count(id_perspektif) as recordsFiltered')
                                             ->where('active', 1)
                                             ->like('nm_perspektif', $search)
                                             ->get()
                                             ->getRowArray()['recordsFiltered'];
                                             
        $count['recordsTotal'] = $this->db->table('ref_perspektif')
                                             ->select('count(id_perspektif) as recordsTotal')
                                             ->where('active', 1)
                                             ->like('nm_perspektif', $search)
                                             ->get()
                                             ->getRowArray()['recordsTotal'];

        return $count;
    }

    public function getperspektifById($id_perspektif){
        return $this->db->table('ref_perspektif')
                        ->select('*')
                        ->where('active', 1)
                        ->where('id_perspektif', $id_perspektif)
                        ->get()
                        ->getRowArray();
    }

    public function insert_perspektif($data){
        $this->db->table('ref_perspektif')
                        ->insert($data);
        return $this->db->insertID();
    }

    public function update_perspektif($data){
        $this->db->table('ref_perspektif')
                 ->where('id_perspektif', $data['id_perspektif'])
                 ->update($data);
        return $data['id_perspektif'];
    }


    public function delete_perspektif($data){
        $this->db->table('ref_perspektif')
                 ->where('id_perspektif', $data['id_perspektif'])
                 ->update($data);
        return $data['id_perspektif'];
    }


    //DETAIL PAGE

    public function getAllperspektif_details($length, $start, $search, $id_perspektif){
        return $this->db->table('ref_perspektif_details a')
                        ->select('a.*, b.nm_divisi, c.nm_divisi_sub')
                        ->join('absensi.ref_divisi b', 'a.id_divisi = b.id_divisi', 'left')
                        ->join('absensi.ref_divisi_sub c', 'a.id_divisi_sub = c.id_divisi_sub', 'left')
                        ->where('a.active', 1)
                        ->where('a.id_perspektif', $id_perspektif)
                        ->where('(b.nm_divisi like "%'.$search.'%" or c.nm_divisi_sub like "%'.$search.'%")')
                        ->get($length, $start)
                        ->getResultArray();
    }

    public function getCountAllperspektif_details($length, $start, $search, $id_perspektif){

        $count = array();
        // $this->db->select('count(id_perspektif) as recordsFiltered');
        $count['recordsFiltered'] = $this->db->table('ref_perspektif_details a')
                                    ->select('count(id_perspektif) as recordsFiltered')
                                    ->join('absensi.ref_divisi b', 'a.id_divisi = b.id_divisi', 'left')
                                    ->join('absensi.ref_divisi_sub c', 'a.id_divisi_sub = c.id_divisi_sub', 'left')
                                    ->where('a.active', 1)
                                    ->where('a.id_perspektif', $id_perspektif)
                                    ->like('b.nm_divisi', $search)
                                    ->where('(b.nm_divisi like "%'.$search.'%" or c.nm_divisi_sub like "%'.$search.'%")')
                                    ->get()
                                    ->getRowArray()['recordsFiltered'];
                                             
        $count['recordsTotal'] = $this->db->table('ref_perspektif_details')
                                             ->select('count(id_perspektif) as recordsTotal')
                                             ->where('active', 1)
                                             ->where('id_perspektif', $id_perspektif)
                                             ->get()
                                             ->getRowArray()['recordsTotal'];

        return $count;
    }

    public function getperspektifById_details($id_perspektif_details){
        return $this->db->table('ref_perspektif_details')
                        ->select('*')
                        ->where('active', 1)
                        ->where('id_perspektif_details', $id_perspektif_details)
                        ->get()
                        ->getRowArray();
    }

    public function insert_perspektif_details($data){
        $this->db->table('ref_perspektif_details')
                        ->insert($data);
        return $this->db->insertID();
    }

    public function update_perspektif_details($data){
        $this->db->table('ref_perspektif_details')
                 ->where('id_perspektif_details', $data['id_perspektif_details'])
                 ->update($data);
        return $data['id_perspektif_details'];
    }


    public function delete_perspektif_details($data){
        $this->db->table('ref_perspektif_details')
                 ->where('id_perspektif', $data['id_perspektif'])
                 ->update($data);
        return $data['id_perspektif'];
    }


    //COMBOBOX

    public function combobox_divisi(){
        return $this->db->table('absensi.ref_divisi')
                        ->select('*')
                        ->where('active', 1)
                        ->get()
                        ->getResultArray();
    }

    public function combobox_divisi_sub($id_divisi){
        return $this->db->table('absensi.ref_divisi_sub')
                        ->select('*')
                        ->where('active', 1)
                        ->where('id_divisi', $id_divisi)
                        ->get()
                        ->getResultArray();
    }

}