<?php

namespace App\Models;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;


class model_laporan_spkd extends Model
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
                                  (select contents from absensi.ref_organisasi where id_organisasi = a.parent) as user_atasan
                                  ')
                        ->where('a.active', 1)
                        ->where('a.id_user', $id_user)
                        ->where('a.id_divisi', $id_divisi)
                        ->where('a.id_divisi_sub', $id_divisi_sub)
                        ->get()
                        ->getRowArray();
    }

    public function get_user_staff($id_user, $id_bu, $id_divisi, $id_divisi_sub){
        return $this->db->table('sso.ref_user a')
                        ->select('a.nm_user as contents, b.id_posisi, 
                                  (select nm_organisasi from absensi.ref_organisasi where id_bu = '.$id_bu.' and id_divisi = '.$id_divisi.' and id_divisi_sub = '.$id_divisi_sub.' and active = 1) as atasan,
                                  (select contents from absensi.ref_organisasi where id_bu = '.$id_bu.' and id_divisi = '.$id_divisi.' and id_divisi_sub = '.$id_divisi_sub.' and active = 1) as user_atasan
                                  ')
                        ->join('absensi.ref_pegawai b', 'a.username = b.nik_pegawai', 'left')
                        ->where('a.active', 1)
                        ->where('a.id_user', $id_user)
                        ->where('b.id_divisi', $id_divisi)
                        ->where('b.id_divisi_sub', $id_divisi_sub)
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

    public function get_evaluasi($tahun, $bulan, $id_bu, $id_divisi, $id_divisi_sub, $id_user, $id_posisi){
        if ($id_posisi == 0 || $id_posisi != 10) {
            return $this->db->table('tr_kpi a')
                            ->select('a.nm_kpi, a.id_perspektif, a.id_inisiatif, d.nm_inisiatif, a.nm_satuan, a.target, 
                                      b.sub_bobot_bulanan, b.target_bulanan,COALESCE(c.realisasi,NULL) as realisasi, 
                                      COALESCE(c.pencapaian,NULL) as pencapaian, COALESCE(c.nilai,NULL) as nilai,
                                      e.penyebab, e.tindakan_perbaikan, e.target_perbaikan, e.waktu_perbaikan')
                            ->join('tr_kpi_bulanan b', 'a.id_kpi = b.id_kpi', 'left')
                            ->join('tr_spkd c', 'a.id_kpi = c.id_kpi', 'left')
                            ->join('ref_inisiatif d', 'a.id_inisiatif = d.id_inisiatif', 'left')
                            ->join('tr_spkd_evaluasi e', 'c.id_spkd = e.id_spkd', 'left')
                            ->where('a.active', 1)
                            ->where('a.status_approval', 1)
                            ->where('a.id_bu', $id_bu)
                            ->where('a.id_divisi', $id_divisi)
                            ->where('a.id_divisi_sub', $id_divisi_sub)
                            ->where('a.tahun', $tahun)
                            ->where('c.cuser', $id_user)
                            ->where('b.active', 1)
                            ->where('b.bulan', $bulan)
                            ->where('b.tahun', $tahun)
                            ->where('c.bulan', $bulan)
                            ->where('c.tahun', $tahun)
                            ->where('c.active', 1)
                            ->where('c.status', 1)
                            ->get()
                            ->getResultArray();
        }else{
            return $this->db->table('tr_kpi_driver a')
                            ->select('a.nm_kpi_driver as nm_kpi, 
                                      a.nm_satuan, 
                                      a.target, 
                                      a.sub_bobot, 
                                      a.target_bulanan, 
                                      COALESCE(c.realisasi,NULL) as realisasi, 
                                      COALESCE(c.pencapaian,NULL) as pencapaian, 
                                      COALESCE(c.nilai,NULL) as nilai,
                                      e.penyebab, e.tindakan_perbaikan, e.target_perbaikan, e.waktu_perbaikan')
                            ->join('tr_spkd c', 'a.id_kpi_driver = c.id_kpi_driver', 'left')
                            ->join('tr_spkd_evaluasi e', 'c.id_spkd = e.id_spkd', 'left')
                            ->where('a.active', 1)
                            // ->where('a.id_bu', $id_bu)
                            // ->where('a.id_divisi', $id_divisi)
                            // ->where('a.id_divisi_sub', $id_divisi_sub)
                            ->where('c.tahun', $tahun)
                            ->where('c.cuser', $id_user)
                            ->where('c.bulan', $bulan)
                            ->get()
                            ->getResultArray();
        }
    }


    public function get_akhlak(){
        return $this->db->table('ref_akhlak a')
                        ->select('a.*')
                        ->where('a.active = 1')
                        ->get()
                        ->getResultArray();
    }

    public function get_evaluasi_akhlak($id_user, $bulan, $tahun){
        return $this->db->table('(SELECT a.id_akhlak, a.nm_akhlak, b.id_akhlak_detail, b.nm_akhlak_detail FROM ref_akhlak a left JOIN ref_akhlak_detail b USING(id_akhlak) WHERE a.active = 1 and b.active = 1)z')
                        ->select('z.*,
                        COALESCE((select id_evaluasi_akhlak from tr_evaluasi_akhlak where active = 1 and id_akhlak_detail = z.id_akhlak_detail and bulan = '.$bulan.' and tahun = '.$tahun.' and id_user = '.$id_user.'),0) as id_evaluasi_akhlak,
                        COALESCE((select nilai from tr_evaluasi_akhlak where active = 1 and id_akhlak_detail = z.id_akhlak_detail and bulan = '.$bulan.' and tahun = '.$tahun.' and id_user = '.$id_user.'),null) as nilai
                        ')
                        ->get()
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


    public function combobox_pegawai($id_divisi, $id_divisi_sub){
        return $this->db->query("select z.* from(SELECT
                                    a.nm_pegawai,
                                    b.id_user,
                                    a.nik_pegawai 
                                FROM
                                    absensi.ref_pegawai a
                                    LEFT JOIN sso.ref_user b ON a.nik_pegawai = b.username 
                                WHERE
                                    b.active = 1 
                                    AND a.status_pegawai IN ( 'PKWT', 'PKWTT' ) 
                                    AND a.id_divisi = ".$id_divisi." 
                                    AND a.id_divisi_sub = ".$id_divisi_sub." 
                                    
                                    UNION ALL
                                    
                                    
                                SELECT
                                    contents,
                                    id_user,
                                    nik_pegawai 
                                FROM
                                    absensi.ref_organisasi 
                                WHERE
                                    id_divisi = ".$id_divisi." 
                                    AND id_divisi_sub = ".$id_divisi_sub.")z GROUP BY z.id_user")
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