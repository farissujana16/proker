<?php

namespace App\Models;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;


class model_laporan_kpi extends Model
{
    protected $db;
    // protected $table      = 'ref_laporan_spkd';
    // protected $primaryKey = 'id_laporan_spkd';
    // protected $useAutoIncrement = true;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    public function getAlllaporan_spkd($length, $start, $search){
        return $this->db->table('ref_laporan_spkd')
                        ->select('*')
                        ->where('active', 1)
                        ->like('nm_laporan_spkd', $search)
                        ->get($length, $start)
                        ->getResultArray();
    }

    public function getCountAlllaporan_spkd($length, $start, $search){

        $count = array();
        // $this->db->select('count(id_laporan_spkd) as recordsFiltered');
        $count['recordsFiltered'] = $this->db->table('ref_laporan_spkd')
                                             ->select('count(id_laporan_spkd) as recordsFiltered')
                                             ->where('active', 1)
                                             ->like('nm_laporan_spkd', $search)
                                             ->get()
                                             ->getRowArray()['recordsFiltered'];
                                             
        $count['recordsTotal'] = $this->db->table('ref_laporan_spkd')
                                             ->select('count(id_laporan_spkd) as recordsTotal')
                                             ->where('active', 1)
                                             ->like('nm_laporan_spkd', $search)
                                             ->get()
                                             ->getRowArray()['recordsTotal'];

        return $count;
    }

    public function getlaporan_spkdById($id_laporan_spkd){
        return $this->db->table('ref_laporan_spkd')
                        ->select('*')
                        ->where('active', 1)
                        ->where('id_laporan_spkd', $id_laporan_spkd)
                        ->get()
                        ->getRowArray();
    }

    public function insert_laporan_spkd($data){
        $this->db->table('ref_laporan_spkd')
                        ->insert($data);
        return $this->db->insertID();
    }

    public function update_laporan_spkd($data){
        $this->db->table('ref_laporan_spkd')
                 ->where('id_laporan_spkd', $data['id_laporan_spkd'])
                 ->update($data);
        return $data['id_laporan_spkd'];
    }


    public function delete_laporan_spkd($data){
        $this->db->table('ref_laporan_spkd')
                 ->where('id_laporan_spkd', $data['id_laporan_spkd'])
                 ->update($data);
        return $data['id_laporan_spkd'];
    }


    //GETDATA

    public function get_bu($id_bu){
        return $this->db->table('sso.ref_bu')
                        ->select('id_bu, nm_bu')
                        ->where('active', 1)
                        ->where('id_bu', $id_bu)
                        ->get()
                        ->getRowArray();
    }

    public function get_divisi($id_divisi){
        return $this->db->table('absensi.ref_divisi')
                        ->select('id_divisi, nm_divisi')
                        ->where('active', 1)
                        ->where('id_divisi', $id_divisi)
                        ->get()
                        ->getRowArray();
    }

    public function get_divisi_sub($id_divisi_sub){
        return $this->db->table('absensi.ref_divisi_sub')
                        ->select('id_divisi_sub, nm_divisi_sub')
                        ->where('active', 1)
                        ->where('id_divisi_sub', $id_divisi_sub)
                        ->get()
                        ->getRowArray();
    }

    public function get_user($id_user, $id_divisi, $id_divisi_sub){
        return $this->db->table('absensi.ref_organisasi a')
                        ->select('a.contents, a.nm_organisasi, 
                        (select nm_organisasi from absensi.ref_organisasi where id_organisasi = a.parent) as atasan,
                        (select contents from absensi.ref_organisasi where id_organisasi = a.parent) as user_atasan')
                        ->where('a.active', 1)
                        ->where('a.id_user', $id_user)
                        ->where('a.id_divisi', $id_divisi)
                        ->where('a.id_divisi_sub', $id_divisi_sub)
                        ->get()
                        ->getRowArray();
    }


    public function get_perspektif($id_bu, $id_divisi){
        if ($id_bu != 60) {
            $str = ' and b.jenis = 2';
        }else{
            $str = ' and b.id_divisi = '.$id_divisi;
        }
        return $this->db->table('ref_perspektif a')
                        ->select('a.nm_perspektif, a.id_perspektif, b.bobot')
                        ->join('ref_perspektif_details b', 'a.id_perspektif = b.id_perspektif', 'left')
                        ->where('a.active = 1 and b.active = 1 '.$str)
                        ->get()
                        ->getResultArray();
    }

    public function get_evaluasi($tahun, $bulan, $id_bu, $id_divisi, $id_divisi_sub, $id_user){
        return $this->db->table('tr_kpi a')
                        ->select('a.nm_kpi, a.id_perspektif, a.id_inisiatif, d.nm_inisiatif, a.nm_satuan, a.target, a.sub_bobot, b.target_bulanan, COALESCE(c.realisasi,NULL) as realisasi, COALESCE(c.pencapaian,NULL) as pencapaian, COALESCE(c.nilai,NULL) as nilai')
                        ->join('tr_kpi_bulanan b', 'a.id_kpi = b.id_kpi', 'left')
                        ->join('tr_spkd c', 'a.id_kpi = c.id_kpi', 'left')
                        ->join('ref_inisiatif d', 'a.id_inisiatif = d.id_inisiatif', 'left')
                        ->where('a.active', 1)
                        ->where('a.id_bu', $id_bu)
                        ->where('a.id_divisi', $id_divisi)
                        ->where('a.id_divisi_sub', $id_divisi_sub)
                        ->where('a.tahun', $tahun)
                        ->where('a.cuser', $id_user)
                        ->where('b.bulan', $bulan)
                        ->where('b.tahun', $tahun)
                        ->get()
                        ->getResultArray();
    }

    public function get_kpi_bulanan($tahun, $id_divisi, $id_divisi_sub, $id_user){
        return $this->db->query("SELECT
                                    z.nm_kpi,
                                    z.id_perspektif,
                                    z.id_inisiatif,
                                    z.nm_inisiatif,
                                    z.sub_bobot,
                                    z.nm_satuan,
                                    z.target,
                                    MAX( CASE WHEN z.bulan = 1 THEN z.target_bulanan ELSE NULL END ) AS bulan_1,
                                    MAX( CASE WHEN z.bulan = 2 THEN z.target_bulanan ELSE NULL END ) AS bulan_2,
                                    MAX( CASE WHEN z.bulan = 3 THEN z.target_bulanan ELSE NULL END ) AS bulan_3,
                                    MAX( CASE WHEN z.bulan = 4 THEN z.target_bulanan ELSE NULL END ) AS bulan_4,
                                    MAX( CASE WHEN z.bulan = 5 THEN z.target_bulanan ELSE NULL END ) AS bulan_5,
                                    MAX( CASE WHEN z.bulan = 6 THEN z.target_bulanan ELSE NULL END ) AS bulan_6,
                                    MAX( CASE WHEN z.bulan = 7 THEN z.target_bulanan ELSE NULL END ) AS bulan_7,
                                    MAX( CASE WHEN z.bulan = 8 THEN z.target_bulanan ELSE NULL END ) AS bulan_8,
                                    MAX( CASE WHEN z.bulan = 9 THEN z.target_bulanan ELSE NULL END ) AS bulan_9,
                                    MAX( CASE WHEN z.bulan = 10 THEN z.target_bulanan ELSE NULL END ) AS bulan_10,
                                    MAX( CASE WHEN z.bulan = 11 THEN z.target_bulanan ELSE NULL END ) AS bulan_11,
                                    MAX( CASE WHEN z.bulan = 12 THEN z.target_bulanan ELSE NULL END ) AS bulan_12
                                    
                                FROM
                                    (
                                    SELECT
                                        a.id_kpi,
                                        a.nm_kpi,
                                        a.id_perspektif,
                                        a.id_inisiatif,
                                        a.sub_bobot,
                                        a.nm_satuan,
                                        a.target,
                                        b.bulan,
                                        b.target_bulanan,
                                        c.nm_inisiatif
                                    FROM
                                        tr_kpi a
                                        LEFT JOIN tr_kpi_bulanan b USING ( id_kpi )
                                        LEFT JOIN ref_inisiatif c USING ( id_inisiatif )
                                    WHERE
                                        a.active = 1 
                                        AND a.status_approval = 1
                                        AND a.id_divisi = ".$id_divisi."
                                        AND a.id_divisi_sub = ".$id_divisi_sub."
                                        AND a.tahun = ".$tahun."
                                        AND a.cuser = ".$id_user."
                                        AND b.tahun = ".$tahun."
                                        AND b.active = 1 
                                    ) z 
                                GROUP BY
                                    z.id_kpi")
                        ->getResultArray();
    }


    public function get_kpi_tahunan($tahun, $id_divisi, $id_divisi_sub, $id_user){
        return $this->db->query("SELECT
                                    a.id_kpi,
                                    a.nm_kpi,
                                    a.id_perspektif,
                                    a.id_inisiatif,
                                    a.sub_bobot,
                                    a.nm_satuan,
                                    a.target,
                                    a.polaritas,
                                    c.nm_inisiatif
                                FROM
                                    tr_kpi a
                                    LEFT JOIN ref_inisiatif c USING ( id_inisiatif )
                                WHERE
                                    a.active = 1 
                                    AND a.status_approval = 1
                                    AND a.id_divisi = ".$id_divisi."
                                    AND a.id_divisi_sub = ".$id_divisi_sub."
                                    AND a.tahun = ".$tahun."
                                    AND a.cuser = ".$id_user."")
                        ->getResultArray();
    }


    //COMBOBOX

    public function combobox_bu(){
        return $this->db->table('sso.ref_bu')
                        ->select('id_bu, nm_bu')
                        ->where('active = 1')
                        // ->whereIn('id_divisi', session()->get('id_divisi'))
                        ->get()
                        ->getResultArray();
    }
    
    public function combobox_divisi($id_bu){
        $str = "";

        if ($id_bu == 60) {
            $str = " and jns_divisi = 'PUSAT'";
        }else if(in_array($id_bu, [61,62,63,64])){
            $str = " and jns_divisi = 'DIVRE'";
        }else if(in_array($id_bu , [69, 70, 71])){
            $str = " and jns_divisi = 'SBU'";
        }else if(in_array($id_bu , [66])){
            $str = " and jns_divisi = 'BTS'";
        }else if(in_array($id_bu , [74,77,80])){
            $str = " and jns_divisi = 'PPD'";
        }
        return $this->db->table('absensi.ref_divisi')
                        ->select('id_divisi, nm_divisi')
                        ->where('active = 1'.$str)
                        // ->whereIn('id_divisi', session()->get('id_divisi'))
                        ->get()
                        ->getResultArray();
    }

    public function combobox_divisi_sub($id_divisi){
        return $this->db->table('absensi.ref_divisi_sub')
                        ->select('id_divisi_sub, nm_divisi_sub')
                        ->where('active', 1)
                        ->where('id_divisi', $id_divisi)
                        // ->whereIn('id_divisi_sub', session()->get('id_divisi_sub'))
                        ->get()
                        ->getResultArray();
    }


    public function combobox_pegawai($id_bu, $id_divisi, $id_divisi_sub){
        return $this->db->query("SELECT
                                    contents,
                                    id_user,
                                    nik_pegawai,
                                    level 
                                FROM
                                    absensi.ref_organisasi 
                                WHERE
                                    id_bu = ".$id_bu." 
                                    and id_divisi = ".$id_divisi." 
                                    AND id_divisi_sub = ".$id_divisi_sub."
                                    and active = 1

                                UNION ALL

                                SELECT a.nm_pegawai, b.id_user, a.nik_pegawai, 5
                                from absensi.ref_pegawai a 
                                left join sso.ref_user b on a.nik_pegawai = b.username 
                                where a.id_bu = ".$id_bu." 
                                and a.id_divisi = ".$id_divisi." 
                                and a.id_divisi_sub = ".$id_divisi_sub." 
                                and status_pegawai in ('PKWT', 'PKWTT')
                                and a.nik_pegawai not in(
                                    SELECT nik_pegawai 
                                    FROM absensi.ref_organisasi 
                                    WHERE id_bu = ".$id_bu." 
                                    and id_divisi = ".$id_divisi." 
                                    and id_divisi_sub = ".$id_divisi_sub."
                                    and active = 1)")
                                ->getResultArray();
    }


    //CEK DATA

    public function cek_user($id_user){
        return $this->db->table('absensi.ref_organisasi')
                        ->select('level')
                        ->where('active', 1)
                        ->where('id_user', $id_user)
                        ->get()
                        ->getResultArray();
    }

}