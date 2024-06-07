<?php

namespace App\Models;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;


class model_evaluasi_akhlak extends Model
{
    protected $db;
    // protected $table      = 'ref_evaluasi_akhlak';
    // protected $primaryKey = 'id_evaluasi_akhlak';
    // protected $useAutoIncrement = true;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    public function getAllevaluasi_akhlak($length, $start, $search, $bulan, $tahun, $id_user){
        if ($id_user == 0) {
            $user = session()->get('id_user');
        }else{
            $user = $id_user;
        }
        return $this->db->table('(SELECT a.id_akhlak, a.nm_akhlak, b.id_akhlak_detail, b.nm_akhlak_detail FROM ref_akhlak a left JOIN ref_akhlak_detail b USING(id_akhlak) WHERE a.active = 1 and b.active = 1)z')
                        ->select('z.*,
                        COALESCE((select id_evaluasi_akhlak from tr_evaluasi_akhlak where active = 1 and id_akhlak_detail = z.id_akhlak_detail and bulan = '.$bulan.' and tahun = '.$tahun.' and id_user = '.$user.'),0) as id_evaluasi_akhlak,
                        COALESCE((select nilai from tr_evaluasi_akhlak where active = 1 and id_akhlak_detail = z.id_akhlak_detail and bulan = '.$bulan.' and tahun = '.$tahun.' and id_user = '.$user.'),null) as nilai
                        ')
                        ->like('z.nm_akhlak', $search)
                        ->get($length, $start)
                        ->getResultArray();
    }

    public function getCountAllevaluasi_akhlak($length, $start, $search){

        $count = array();
        // $this->db->select('count(id_evaluasi_akhlak) as recordsFiltered');
        $count['recordsFiltered'] = $this->db->table('ref_akhlak_detail')
                                             ->select('count(id_akhlak_detail) as recordsFiltered')
                                             ->where('active', 1)
                                             ->like('nm_akhlak_detail', $search)
                                             ->get()
                                             ->getRowArray()['recordsFiltered'];
                                             
        $count['recordsTotal'] = $this->db->table('ref_akhlak_detail')
                                             ->select('count(id_akhlak_detail) as recordsTotal')
                                             ->where('active', 1)
                                             ->get()
                                             ->getRowArray()['recordsTotal'];

        return $count;
    }

    public function getevaluasi_akhlakById($id_evaluasi_akhlak){
        return $this->db->table('tr_evaluasi_akhlak')
                        ->select('*')
                        ->where('active', 1)
                        ->where('id_evaluasi_akhlak', $id_evaluasi_akhlak)
                        ->get()
                        ->getRowArray();
    }

    public function insert_evaluasi_akhlak($data){
        $this->db->table('tr_evaluasi_akhlak')
                        ->insert($data);
        return $this->db->insertID();
    }

    public function update_evaluasi_akhlak($data){
        $this->db->table('tr_evaluasi_akhlak')
                 ->where('id_evaluasi_akhlak', $data['id_evaluasi_akhlak'])
                 ->update($data);
        return $data['id_evaluasi_akhlak'];
    }


    public function delete_evaluasi_akhlak($data){
        $this->db->table('tr_evaluasi_akhlak')
                 ->where('id_evaluasi_akhlak', $data['id_evaluasi_akhlak'])
                 ->update($data);
        return $data['id_evaluasi_akhlak'];
    }

    public function get_akhlak_detail($id_akhlak){
        return $this->db->table('ref_akhlak_detail')
                        ->select('*')
                        ->where('active', 1)
                        ->where('id_akhlak', $id_akhlak)
                        ->get()
                        ->getResultArray();
    }



    //COMBOBOX
    public function combobox_bu(){
        return $this->db->table('sso.ref_bu')
                        ->select('id_bu, nm_bu')
                        ->where('active', 1)
                        ->get()
                        ->getResultArray();
    }

    public function combobox_divisi(){
        return $this->db->table('absensi.ref_divisi')
                        ->select('id_divisi, nm_divisi')
                        ->where('active', 1)
                        ->get()
                        ->getResultArray();
    }

    public function combobox_divisi_sub($id_divisi){
        return $this->db->table('absensi.ref_divisi_sub')
                        ->select('id_divisi_sub, nm_divisi_sub')
                        ->where('active', 1)
                        ->where('id_divisi', $id_divisi)
                        ->get()
                        ->getResultArray();
    }

    public function combobox_kpi($id_bu, $id_divisi, $id_divisi_sub, $tahun){
        return $this->db->table('tr_kpi')
                        ->select('*')
                        ->where('active', 1)
                        ->where('id_bu', $id_bu)
                        ->where('id_divisi', $id_divisi)
                        ->where('id_divisi_sub', $id_divisi_sub)
                        ->where('tahun', $tahun)
                        ->get()
                        ->getResultArray();
    }

    public function combobox_kpi_atasan($id_bu, $id_divisi, $id_divisi_sub, $tahun){
        if (in_array(2, session()->get('level'))) {
            $str = ' and level_kpi = 1';
        }else{
            $str = ' and id_divisi_sub = '.$id_divisi_sub.' and level_kpi = (select max(level_kpi) from tr_evaluasi_akhlak where active = 1 
            and id_bu = '.$id_bu.' 
            and tahun = '.$tahun.' 
            and id_divisi = '.$id_divisi.' and id_divisi_sub = '.$id_divisi_sub.')';
        }

        return $this->db->query("select * from tr_evaluasi_akhlak
                                where active = 1 
                                and id_bu = ".$id_bu." 
                                and tahun = ".$tahun." 
                                and id_divisi = ".$id_divisi."
                                and status_approval = 2 ".$str)
                        ->getResultArray();
        // return $this->db->table('tr_kpi')
        //                 ->select('*')
        //                 ->where('active', 1)
        //                 ->where('id_bu', $id_bu)
        //                 ->where('id_divisi', $id_divisi)
        //                 ->where('id_divisi_sub', $id_divisi_sub)
        //                 ->where('tahun', $tahun)
        //                 ->get()
        //                 ->getResultArray();
    }

    public function combobox_pegawai_old(){
        $str = array();

            if (in_array(1, session()->get('level'))) {
                array_push($str, 2);
            }
            if (in_array(2, session()->get('level'))) {
                array_push($str, 3,5);
            }
            if (in_array(3, session()->get('level'))) {
                array_push($str, 4);
            }
            if (in_array(4, session()->get('level'))) {
                array_push($str, 5);
            }
    
            return $this->db->query("select z.id_user, contents as nm_pegawai, level_pegawai, active from (
                SELECT
                    id_user,
                    contents,
                    level as level_pegawai,
                    active
                FROM
                    absensi.ref_organisasi 
                WHERE
                    id_bu = ".session()->get('id_bu')."
                    AND id_divisi in (".implode(",", session()->get('id_divisi')).")
                    AND active = 1 
                    
                    UNION ALL
                    
                SELECT
                    b.id_user,
                    a.nm_pegawai,
                    5,
                    a.active
                FROM
                    absensi.ref_pegawai a
                    LEFT JOIN sso.ref_user b ON a.nik_pegawai = b.username 
                WHERE
                    a.id_bu = ".session()->get('id_bu')."
                    AND a.id_divisi in (".implode(",", session()->get('id_divisi')).")
                    AND a.id_divisi_sub in (".implode(",", session()->get('id_divisi_sub')).")
                    AND a.status_pegawai IN ( 'PKWT', 'PKWTT' ) 
                    AND a.nik_pegawai NOT IN (
                    SELECT
                        nik_pegawai 
                    FROM
                        absensi.ref_organisasi 
                    WHERE
                        id_bu = ".session()->get('id_bu')."
                    AND id_divisi in (".implode(",", session()->get('id_divisi')).")
                    AND id_divisi_sub in (".implode(",", session()->get('id_divisi_sub')).")
                    AND active = 1)
                    )z
                    where z.active = 1 and z.level_pegawai in (".implode(',', $str).")")->getResultArray();

        }
        public function combobox_pegawai(){
            $str = "";
            $arr = array();

            $kelas = $this->db->query("select kelas from sso.ref_bu where active = 1 and id_bu = ".session()->get('id_bu'))->getRowArray();
    
            if (in_array(0, session()->get('level'))) {
                return $this->db->query("select id_user, contents as nm_pegawai from absensi.ref_organisasi where parent in (".implode(",", session()->get('id_organisasi')).") and active = 1
    
                union all
                
                select id_user, contents from absensi.ref_organisasi where active = 1 and id_bu in(61,62,63,64) and level = 1")->getResultArray();
            }else{
                if(in_array(session()->get('id_bu'), [61,62,63,64])){
                    if (in_array(1, session()->get('level'))) {
                        array_push($arr, 2);
                        $str = ' and a.id_divisi_sub in ('.implode(",", session()->get('id_divisi_sub')).')';
                    }
                    if (in_array(2, session()->get('level'))) {
                        array_push($arr, 3);
                        $str = ' and a.id_divisi_sub in ('.implode(",", session()->get('id_divisi_sub')).')';
                    }
                    if (in_array(3, session()->get('level'))) {
                        array_push($arr, 4,5);
                        $str = ' and a.id_divisi_sub in ('.implode(",", session()->get('id_divisi_sub')).')';
                    }
    
                }else if(session()->get('id_bu') == 60){
                    if (in_array(1, session()->get('id_divisi'))) {
                        array_push($arr, 2,3);
                        $str = ' and a.id_divisi_sub in ('.implode(",", session()->get('id_divisi_sub')).')';
                    }else{
                        if (in_array(1, session()->get('level'))) {
                            array_push($arr, 2);
                            $str = ' and a.id_divisi_sub in ('.implode(",", session()->get('id_divisi_sub')).')';
                        }
                        if (in_array(2, session()->get('level'))) {
                            array_push($arr, 3,5);
                            $str = ' and a.id_divisi_sub in ('.implode(",", session()->get('id_divisi_sub')).')';
                        }
                    }
                }else if (!in_array(session()->get('id_bu'), [60,61,62,63,64])) {
                    if (in_array(1, session()->get('level'))) {
                        array_push($arr, 2);
                        $str = ' and a.id_divisi_sub in ('.implode(",", session()->get('id_divisi_sub')).')';
                    }
                    if (in_array(2, session()->get('level'))) {
                        array_push($arr, 3);
                        $str = ' and a.id_divisi_sub in ('.implode(",", session()->get('id_divisi_sub')).')';
                    }
                    if (in_array(3, session()->get('level'))) {
                        if (in_array($kelas['kelas'], ['C', 'D'])) {
                            array_push($arr, 5);
                        }else{
                            array_push($arr, 4);
                        }
                        $str = ' and (a.id_divisi_sub in ('.implode(",", session()->get('id_divisi_sub')).') or a.id_divisi in ('.implode(",", session()->get('id_divisi')).'))';
                    }
                    if (in_array(4, session()->get('level'))) {
                        array_push($arr, 5);
                        $str = ' and a.id_divisi_sub in ('.implode(",", session()->get('id_divisi_sub')).')';
                    }
                }
    
                return $this->db->query('select z.id_user, z.contents as nm_pegawai, z.id_divisi, z.id_divisi_sub from(SELECT
                                            b.id_user,
                                            b.contents,
                                            a.id_bu,
                                            a.id_divisi,
                                            a.id_divisi_sub,
                                            b.LEVEL 
                                        FROM
                                            absensi.ref_approval_access a
                                            LEFT JOIN absensi.ref_organisasi b ON a.id_bu = b.id_bu 
                                            AND a.id_divisi = b.id_divisi 
                                            AND a.id_divisi_sub = b.id_divisi_sub 
                                        WHERE
                                            a.id_organisasi IN ( '.implode(",", session()->get('id_organisasi')).' ) 
                                            AND a.fitur = 2 
                                            AND a.active = 1 
                                            AND b.active = 1
                                            AND a.level != 5
                                            
                                            UNION ALL
                                            
                                            SELECT
                                            b.id_user,
                                            a.nm_pegawai,
                                            a.id_bu,
                                            a.id_divisi,
                                            a.id_divisi_sub,
                                            5 as level 
                                        FROM
                                            absensi.ref_pegawai a
                                            LEFT JOIN sso.ref_user b on a.nik_pegawai = b.username
                                        WHERE
                                            a.active = 1 
                                            AND a.id_pegawai NOT IN ( SELECT id_pegawai FROM absensi.ref_organisasi WHERE active = 1 )
                                            AND a.status_pegawai IN ("PKWT","PKWTT")
                                            AND a.id_bu = '.session()->get('id_bu').'
                                            AND a.id_divisi in ('.implode(",", session()->get('id_divisi')).')
                                            '.$str.'
                                            )z
                                            where z.level in ('.implode(',', $arr).')
                                        ')
                                ->getResultArray();
            }
    
            }
}