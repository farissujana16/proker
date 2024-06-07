<?php

namespace App\Models;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;


class model_kpi extends Model
{
    protected $db;
    // protected $table      = 'ref_kpi';
    // protected $primaryKey = 'id_kpi';
    // protected $useAutoIncrement = true;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    public function getAllkpi($length, $start, $search, $tahun, $id_user, $id_bu, $id_divisi, $id_divisi_sub, $level)
    {
        $str = "";

        if ($id_user == 0) {
            $info = $this->cek_jabatan(session()->get('username'));
            if (count(session()->get('level')) > 0) {
                $str = ' and z.id_bu in(' . implode(",", array_column($info, 'id_bu')) . ') and z.id_divisi in(' . implode(",", array_column($info, 'id_divisi')) . ') and z.id_divisi_sub in(' . implode(",", array_column($info, 'id_divisi_sub')) . ')';
            } else {
                $str = ' and z.id_bu in(' . implode(",", array_column($info, 'id_bu')) . ') and z.id_divisi in(' . implode(",", array_column($info, 'id_divisi')) . ') and z.id_divisi_sub in(' . implode(",", array_column($info, 'id_divisi_sub')) . ') and z.cuser = ' . session()->get('id_user') . '';
            }
        } else {
            if ($level != 5) {
                $str = ' and z.total_bulanan > 0 and z.id_bu = ' . $id_bu . ' and z.id_divisi = ' . $id_divisi . ' and z.id_divisi_sub = ' . $id_divisi_sub . ' and z.level_kpi = ' . $level . '';
            } else {
                $str = ' and z.total_bulanan > 0 and z.id_bu = ' . $id_bu . ' and z.id_divisi = ' . $id_divisi . ' and z.id_divisi_sub = ' . $id_divisi_sub . ' and z.level_kpi = ' . $level . ' and z.cuser = ' . $id_user . '';
            }
            // $user = $id_user;
        }

        return $this->db->table('(SELECT a.*,( SELECT count( id_kpi_bulanan ) FROM tr_kpi_bulanan WHERE id_kpi = a.id_kpi AND active = 1 ) AS total_bulanan FROM tr_kpi a ) z')
            ->select('z.*,
                        CASE WHEN z.id_bu = 60 THEN
                        (select bobot from ref_perspektif_details where id_perspektif = z.id_perspektif and id_divisi = z.id_divisi)
                        ELSE
                        (select bobot from ref_perspektif_details where id_perspektif = z.id_perspektif and jenis = 2)
                        END as bobot,
                        c.nm_inisiatif,
                        d.nm_perspektif')
            ->join('ref_inisiatif c', 'z.id_inisiatif = c.id_inisiatif', 'left')
            ->join('ref_perspektif d', 'z.id_perspektif = d.id_perspektif', 'left')
            ->where('z.active = 1 ')
            // ->whereIn('id_divisi', session()->get('id_divisi'))
            // ->whereIn('level_kpi', session()->get('level'))
            // ->whereIn('id_divisi_sub', session()->get('id_divisi_sub'))
            ->where('z.tahun = ' . $tahun . ' ' . $str . '')
            ->like('z.nm_kpi', $search)
            ->get($length, $start)
            ->getResultArray();
    }

    public function getCountAllkpi($length, $start, $search, $tahun, $id_user, $id_bu, $id_divisi, $id_divisi_sub, $level)
    {

        if ($id_user == 0) {
            $info = $this->cek_jabatan(session()->get('username'));
            if (count(session()->get('level')) > 0) {
                $str = ' and id_bu in(' . implode(",", array_column($info, 'id_bu')) . ') and id_divisi in(' . implode(",", array_column($info, 'id_divisi')) . ') and id_divisi_sub in(' . implode(",", array_column($info, 'id_divisi_sub')) . ')';
            } else {
                $str = ' and id_bu in(' . implode(",", array_column($info, 'id_bu')) . ') and id_divisi in(' . implode(",", array_column($info, 'id_divisi')) . ') and id_divisi_sub in(' . implode(",", array_column($info, 'id_divisi_sub')) . ') and cuser = ' . session()->get('id_user') . '';
            }
        } else {
            if ($level != 5) {
                $str = ' and id_bu = ' . $id_bu . ' and id_divisi = ' . $id_divisi . ' and id_divisi_sub = ' . $id_divisi_sub . ' and level_kpi = ' . $level . '';
            } else {
                $str = ' and id_bu = ' . $id_bu . ' and id_divisi = ' . $id_divisi . ' and id_divisi_sub = ' . $id_divisi_sub . ' and level_kpi = ' . $level . ' and cuser = ' . $id_user . '';
            }
            // $user = $id_user;
        }

        $count = array();
        // $this->db->select('count(id_kpi) as recordsFiltered');
        $count['recordsFiltered'] = $this->db->table('tr_kpi')
            ->select('count(id_kpi) as recordsFiltered')
            ->where('active = 1 ')
            //  ->whereIn('id_divisi', session()->get('id_divisi'))
            //  ->whereIn('level_kpi', session()->get('level'))
            //  ->whereIn('id_divisi_sub', session()->get('id_divisi_sub'))
            ->where('tahun = ' . $tahun . ' ' . $str . '')
            ->like('nm_kpi', $search)
            ->get()
            ->getRowArray()['recordsFiltered'];

        $count['recordsTotal'] = $this->db->table('tr_kpi')
            ->select('count(id_kpi) as recordsTotal')
            ->where('active = 1 ')
            //  ->whereIn('id_divisi', session()->get('id_divisi'))
            //  ->whereIn('level_kpi', session()->get('level'))
            //  ->whereIn('id_divisi_sub', session()->get('id_divisi_sub'))
            ->where('tahun = ' . $tahun . ' ' . $str . '')
            ->get()
            ->getRowArray()['recordsTotal'];

        return $count;
    }

    public function getkpiById($id_kpi)
    {
        return $this->db->table('tr_kpi')
            ->select('*')
            ->where('active', 1)
            ->where('id_kpi', $id_kpi)
            ->get()
            ->getRowArray();
    }

    public function insert_kpi($data)
    {
        $this->db->table('tr_kpi')
            ->insert($data);
        return $this->db->insertID();
    }

    public function update_kpi($data)
    {
        $this->db->table('tr_kpi')
            ->where('id_kpi', $data['id_kpi'])
            ->update($data);
        return $data['id_kpi'];
    }


    public function delete_kpi($data)
    {
        $this->db->table('tr_kpi')
            ->where('id_kpi', $data['id_kpi'])
            ->update($data);
        return $data['id_kpi'];
    }

    public function delete_kpi_bulanan_all($data)
    {
        $this->db->table('tr_kpi_bulanan')
            ->where('id_kpi', $data['id_kpi'])
            ->update($data);
    }





    //KPI BULANAN

    public function getAllkpi_bulanan($length, $start, $search, $id_kpi)
    {

        return $this->db->table('tr_kpi_bulanan')
            ->select('*')
            ->where('active = 1 ')
            ->where('id_kpi', $id_kpi)
            ->like('bulan', $search)
            ->get($length, $start)
            ->getResultArray();
    }

    public function getCountAllkpi_bulanan($length, $start, $search, $id_kpi)
    {


        $count = array();
        // $this->db->select('count(id_kpi) as recordsFiltered');
        $count['recordsFiltered'] = $this->db->table('tr_kpi_bulanan')
            ->select('count(id_kpi_bulanan) as recordsFiltered')
            ->where('active = 1 ')
            ->where('id_kpi', $id_kpi)
            ->like('bulan', $search)
            ->get()
            ->getRowArray()['recordsFiltered'];

        $count['recordsTotal'] = $this->db->table('tr_kpi_bulanan')
            ->select('count(id_kpi_bulanan) as recordsTotal')
            ->where('active = 1 ')
            ->where('id_kpi', $id_kpi)
            ->get()
            ->getRowArray()['recordsTotal'];

        return $count;
    }

    public function getkpiByIdBulanan($id_kpi_bulanan)
    {
        return $this->db->table('tr_kpi_bulanan')
            ->select('*, 
                                ( select max(target_bulanan) from tr_kpi_bulanan where active = 1 and id_kpi_bulanan != ' . $id_kpi_bulanan . ' and id_kpi_bulanan < ' . $id_kpi_bulanan . ' and id_kpi = (select id_kpi from tr_kpi_bulanan where id_kpi_bulanan = ' . $id_kpi_bulanan . ' and active = 1)) as max_sebelum,
                                ( select min(target_bulanan) from tr_kpi_bulanan where active = 1 and id_kpi_bulanan != ' . $id_kpi_bulanan . ' and id_kpi_bulanan > ' . $id_kpi_bulanan . ' and id_kpi = (select id_kpi from tr_kpi_bulanan where id_kpi_bulanan = ' . $id_kpi_bulanan . ' and active = 1)) as min_sebelum
                                ')
            ->where('active', 1)
            ->where('id_kpi_bulanan', $id_kpi_bulanan)
            ->get()
            ->getRowArray();
    }

    public function insert_kpi_bulanan($data)
    {
        $this->db->table('tr_kpi_bulanan')
            ->insert($data);
        return $this->db->insertID();
    }

    public function update_kpi_bulanan($data)
    {
        $this->db->table('tr_kpi_bulanan')
            ->where('id_kpi_bulanan', $data['id_kpi_bulanan'])
            ->update($data);
        return $data['id_kpi_bulanan'];
    }


    public function delete_kpi_bulanan($data)
    {
        $this->db->table('tr_kpi_bulanan')
            ->where('id_kpi_bulanan', $data['id_kpi_bulanan'])
            ->update($data);
        return $data['id_kpi_bulanan'];
    }


    //COMBOBOX
    public function combobox_bu($id_user)
    {
        return $this->db->table('absensi.ref_organisasi b')
            ->select('a.id_bu, a.nm_bu')
            ->join('sso.ref_bu a', 'b.id_bu = a.id_bu', 'left')
            ->where('a.active', 1)
            ->where('b.active', 1)
            ->where('b.id_user', $id_user)
            ->groupBy('a.id_bu')
            ->get()
            ->getResultArray();
    }

    public function combobox_perspektif()
    {
        return $this->db->table('ref_perspektif')
            ->select('id_perspektif, nm_perspektif')
            ->where('active', 1)
            ->get()
            ->getResultArray();
    }

    public function combobox_satuan()
    {
        return $this->db->table('ref_satuan')
            ->select('id_satuan, nm_satuan')
            ->where('active', 1)
            ->get()
            ->getResultArray();
    }

    public function combobox_divisi()
    {
        if (session()->get('level')) {
            $str = ' and id_divisi in(' . implode(",", session()->get('id_divisi')) . ') ';
        } else {
            $str = ' and id_divisi = ' . session()->get('divisi');
        }

        return $this->db->table('absensi.ref_divisi')
            ->select('id_divisi, nm_divisi')
            ->where('active = 1' . $str)
            // ->whereIn('id_divisi', session()->get('id_divisi'))
            ->get()
            ->getResultArray();
    }


    public function combobox_inisiatif($tahun)
    {
        return $this->db->table('ref_inisiatif a')
            ->select('a.*, b.nm_perspektif')
            ->join('ref_perspektif b', 'a.id_perspektif = b.id_perspektif', 'left')
            ->where('a.active', 1)
            ->where('a.tahun', $tahun)
            // ->whereIn('id_divisi_sub', session()->get('id_divisi_sub'))
            ->get()
            ->getResultArray();
    }


    public function combobox_divisi_sub($id_divisi)
    {
        if (session()->get('level')) {
            $str = ' and a.id_divisi_sub in(' . implode(",", session()->get('id_divisi_sub')) . ') ';
        } else {
            $str = ' and a.id_divisi_sub = ' . session()->get('divisi_sub');
        }

        return $this->db->table('absensi.ref_divisi_sub a')
            ->select('a.id_divisi_sub, a.nm_divisi_sub, b.level')
            ->join('absensi.ref_organisasi b', 'a.id_divisi_sub = b.id_divisi_sub', 'left')
            ->where('a.active != 2' . $str)
            ->where('a.id_divisi', $id_divisi)
            ->where('b.active', 1)
            ->groupBy('a.id_divisi_sub')
            // ->whereIn('id_divisi_sub', session()->get('id_divisi_sub'))
            ->get()
            ->getResultArray();
    }

    public function combobox_kpi_atasan()
    {

        $level = session()->get('level');
        $str = "";
        $divisi = "";
        $sub_divisi = "";

        if (in_array(2, $level)) {
            $str = ' and a.level_kpi = 1';
        } else if (in_array(3, $level)) {
            if (session()->get('id_bu') == 66) {
                $str = ' and a.level_kpi = 1';
            } else {
                $str = ' and a.level_kpi = 2';
            }
        } else if (in_array(4, $level)) {
            $str = ' and a.level_kpi = 3';
        } else if (empty($level)) {
            $str = ' and a.level_kpi in(2,3,4)';
            $str .= ' and (a.id_divisi_sub = ' . session()->get('divisi_sub') . ' or (level_kpi = (select max(level_kpi) from tr_kpi where active = 1 and level_kpi != 5 and id_bu = ' . session()->get('id_bu') . ' and id_divisi = ' . session()->get('divisi') . ')))';
        }


        if (!in_array(session()->get('id_bu'), [60])) {
            // $str .= ' and a.id_bu = '.session()->get('id_bu');
            if (!in_array(session()->get('id_bu'), [61, 62, 63, 64])) {
                if (in_array(2, $level)) {
                    $str .= ' and b.id_divre = ' . session()->get('id_divre');
                } else if (in_array(3, $level) && session()->get('id_bu') == 66) {
                    $str .= ' and b.id_divre = ' . session()->get('id_divre');
                } else {
                    $str .= ' and a.id_bu = ' . session()->get('id_bu');
                }
            } else {
                $str .= ' and a.id_bu = ' . session()->get('id_bu');
            }
        } else {
            if (count(session()->get('id_divisi')) > 0) {
                $divisi = ' and a.id_divisi in(' . implode(",", session()->get('id_divisi')) . ')';
                $sub_divisi = '';
            } else {
                $divisi = ' and a.id_divisi = ' . session()->get('divisi');
                // $sub_divisi = ' and id_divisi_sub = '.session()->get('divisi_sub');
            }
        }

        return $this->db->table('tr_kpi a')
            ->select('a.*')
            ->join('sso.ref_bu b', 'a.id_bu = b.id_bu', 'left')
            ->where('a.active = 1 ' . $str . $divisi . $sub_divisi . '')
            // ->whereIn('id_divisi', session()->get('id_divisi'))
            ->where('status_approval', 1)
            ->get()
            ->getResultArray();
    }

    public function combobox_pegawai_old()
    {
        $arr = array();
        $str = "";

        if (in_array(0, session()->get('level'))) {
            return $this->db->query("select id_user, contents as nm_pegawai from absensi.ref_organisasi where parent = " . session()->get('id_organisasi') . " and active = 1

            union all
            
            select id_user, contents from absensi.ref_organisasi where active = 1 and id_bu in(61,62,63,64) and level = 1")->getResultArray();
        } else {
            if (in_array(1, session()->get('level'))) {
                array_push($arr, 2);
            }
            if (in_array(2, session()->get('level'))) {
                array_push($arr, 3, 5);
            }
            if (in_array(3, session()->get('level'))) {
                array_push($arr, 4);
            }
            if (in_array(4, session()->get('level'))) {
                array_push($arr, 5);
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
                    id_bu = " . session()->get('id_bu') . "
                    AND id_divisi in (" . implode(",", session()->get('id_divisi')) . ")
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
                    a.id_bu = " . session()->get('id_bu') . "
                    AND a.id_divisi in (" . implode(",", session()->get('id_divisi')) . ")
                    AND a.id_divisi_sub in (" . implode(",", session()->get('id_divisi_sub')) . ")
                    AND a.status_pegawai IN ( 'PKWT', 'PKWTT' ) 
                    AND a.nik_pegawai NOT IN (
                    SELECT
                        nik_pegawai 
                    FROM
                        absensi.ref_organisasi 
                    WHERE
                        id_bu = " . session()->get('id_bu') . "
                    AND id_divisi in (" . implode(",", session()->get('id_divisi')) . ")
                    AND id_divisi_sub in (" . implode(",", session()->get('id_divisi_sub')) . ")
                    AND active = 1)
                    )z
                    where z.active = 1 and z.level_pegawai in (" . implode(',', $arr) . ")")->getResultArray();
        }
    }

    public function combobox_pegawai()
    {
        $str = "";
        $arr = array();
        $kelas = $this->db->query("select kelas from sso.ref_bu where active = 1 and id_bu = " . session()->get('id_bu'))->getRowArray();

        if (in_array(0, session()->get('level'))) {
            return $this->db->query("select id_user, contents as nm_pegawai, id_divisi, id_divisi_sub, id_bu, level from absensi.ref_organisasi where parent in (" . implode(",", session()->get('id_organisasi')) . ") and active = 1

            union all
            
            select id_user, contents as nm_pegawai, id_divisi, id_divisi_sub, id_bu, level from absensi.ref_organisasi where active = 1 and id_bu in(61,62,63,64,84,83) and level = 1

            union all

            select id_user, contents as nm_pegawai, id_divisi, id_divisi_sub, id_bu, level from absensi.ref_organisasi where active = 1 and id_bu in(66) and level = 3
            ")->getResultArray();
        } else {
            if (in_array(session()->get('id_bu'), [61, 62, 63, 64])) {
                if (in_array(1, session()->get('level'))) {
                    array_push($arr, 2);
                    $str = ' and a.id_divisi_sub in (' . implode(",", session()->get('id_divisi_sub')) . ')';
                }
                if (in_array(2, session()->get('level'))) {
                    array_push($arr, 3);
                    $str = ' and a.id_divisi_sub in (' . implode(",", session()->get('id_divisi_sub')) . ')';
                }
                if (in_array(3, session()->get('level'))) {
                    array_push($arr, 4, 5);
                    $str = ' and a.id_divisi_sub in (' . implode(",", session()->get('id_divisi_sub')) . ')';
                }
            } else if (session()->get('id_bu') == 60) {
                if (in_array(1, session()->get('id_divisi'))) {
                    array_push($arr, 2, 3);
                    $str = ' and a.id_divisi_sub in (' . implode(",", session()->get('id_divisi_sub')) . ')';
                } else {
                    if (in_array(1, session()->get('level'))) {
                        array_push($arr, 2);
                        $str = ' and a.id_divisi_sub in (' . implode(",", session()->get('id_divisi_sub')) . ')';
                    }
                    if (in_array(2, session()->get('level'))) {
                        array_push($arr, 3, 5);
                        $str = ' and a.id_divisi_sub in (' . implode(",", session()->get('id_divisi_sub')) . ')';
                    }
                }
            } else if (!in_array(session()->get('id_bu'), [60, 61, 62, 63, 64])) {
                if (in_array(1, session()->get('level'))) {
                    array_push($arr, 2);
                    $str = ' and a.id_divisi_sub in (' . implode(",", session()->get('id_divisi_sub')) . ')';
                }
                if (in_array(2, session()->get('level'))) {
                    array_push($arr, 3);
                    $str = ' and a.id_divisi_sub in (' . implode(",", session()->get('id_divisi_sub')) . ')';
                }
                if (in_array(3, session()->get('level'))) {
                    if (in_array($kelas['kelas'], ['C', 'D'])) {
                        array_push($arr, 5);
                    } else {
                        array_push($arr, 4);
                    }
                    $str = ' and (a.id_divisi_sub in (' . implode(",", session()->get('id_divisi_sub')) . ') or a.id_divisi in (' . implode(",", session()->get('id_divisi')) . '))';
                }
                if (in_array(4, session()->get('level'))) {
                    array_push($arr, 5);
                    $str = ' and a.id_divisi_sub in (' . implode(",", session()->get('id_divisi_sub')) . ')';
                }
            }

            return $this->db->query('select z.id_user, z.contents as nm_pegawai, id_bu, id_divisi, id_divisi_sub, level from(SELECT
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
                                        a.id_organisasi IN ( ' . implode(",", session()->get('id_organisasi')) . ' ) 
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
                                        AND a.id_bu = ' . session()->get('id_bu') . '
                                        AND a.id_divisi in (' . implode(",", session()->get('id_divisi')) . ')
                                        ' . $str . '
                                        
                                        )z
                                        where z.level in (' . implode(',', $arr) . ')
                                    ')
                ->getResultArray();
        }
    }


    //GET OTHER DATA

    public function get_bu($id_bu)
    {
        return $this->db->table('sso.ref_bu')
            ->select('id_bu, nm_bu')
            ->where('active', 1)
            ->where('id_bu', $id_bu)
            ->get()
            ->getRowArray();
    }

    public function get_divisi($id_divisi)
    {
        return $this->db->table('absensi.ref_divisi')
            ->select('id_divisi, nm_divisi')
            ->where('active', 1)
            ->where('id_divisi', $id_divisi)
            ->get()
            ->getRowArray();
    }

    public function get_divisi_sub($id_divisi_sub)
    {
        return $this->db->table('absensi.ref_divisi_sub')
            ->select('id_divisi_sub, nm_divisi_sub')
            ->where('active', 1)
            ->where('id_divisi_sub', $id_divisi_sub)
            ->get()
            ->getRowArray();
    }

    public function get_user($id_user, $id_divisi, $id_divisi_sub)
    {
        return $this->db->table('absensi.ref_organisasi a')
            ->select('a.contents, (select contents from absensi.ref_organisasi where id_organisasi = a.parent) as atasan')
            ->where('a.active', 1)
            ->where('a.id_user', $id_user)
            ->where('a.id_divisi', $id_divisi)
            ->where('a.id_divisi_sub', $id_divisi_sub)
            ->get()
            ->getRowArray();
    }

    public function get_jabatan($id_user, $level)
    {
        return $this->db->table('absensi.ref_organisasi')
            ->select('nm_organisasi, level, id_divisi, id_divisi_sub')
            ->where('active', 1)
            ->whereIn('level', $level)
            ->where('id_user', $id_user)
            ->get()
            ->getResultArray();
    }

    public function get_perspektif($id_bu, $id_divisi)
    {
        if ($id_bu != 60) {
            $str = ' and b.jenis = 2';
        } else {
            $str = ' and b.id_divisi = ' . $id_divisi;
        }
        return $this->db->table('ref_perspektif a')
            ->select('a.nm_perspektif, a.id_perspektif, b.bobot')
            ->join('ref_perspektif_details b', 'a.id_perspektif = b.id_perspektif', 'left')
            ->where('a.active = 1 and b.active = 1 ' . $str)
            ->get()
            ->getResultArray();
    }

    public function get_kpi($tahun, $id_divisi, $id_divisi_sub, $level, $id_user)
    {
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
                                        AND a.id_divisi = " . $id_divisi . "
                                        AND a.id_divisi_sub = " . $id_divisi_sub . "
                                        AND a.tahun = " . $tahun . "
                                        AND a.level_kpi = " . $level . "
                                        AND a.cuser = " . $id_user . "
                                        AND b.tahun = " . $tahun . "
                                        AND b.active = 1 
                                    ) z 
                                GROUP BY
                                    z.id_kpi")
            ->getResultArray();
    }


    //CHECKING DATA

    public function cek_batas($id_divisi, $id_divisi_sub, $tahun, $cuser)
    {
        return $this->db->table('tr_kpi')
            ->select('sum(sub_bobot) as total')
            ->where('active', 1)
            ->where('id_divisi', $id_divisi)
            ->where('id_divisi_sub', $id_divisi_sub)
            ->where('tahun', $tahun)
            ->where('cuser', $cuser)
            // ->whereIn('id_divisi', session()->get('id_divisi'))
            ->get()
            ->getRowArray();
    }

    public function cek_bobot_perspektif($id_inisiatif, $id_divisi, $id_divisi_sub, $tahun, $id_user, $id_bu)
    {
        $str = "";

        if ($id_bu == 60) {
            $str = ' and c.id_divisi = ' . $id_divisi;
        } else {
            $str = ' and c.jenis = 2';
        }

        return $this->db->table('tr_kpi')
            ->select('sum(sub_bobot) as total, (
                            SELECT
                                c.bobot 
                            FROM
                                ref_inisiatif a
                                LEFT JOIN ref_perspektif b USING ( id_perspektif )
                                LEFT JOIN ref_perspektif_details c ON b.id_perspektif = c.id_perspektif 
                            WHERE
                                a.active = 1 
                                AND b.active = 1 
                                AND a.id_inisiatif = ' . $id_inisiatif . ' 
                                ' . $str . '
                            ) AS bobot_perspektif ')
            ->where('active', 1)
            ->where('id_divisi', $id_divisi)
            ->where('id_divisi_sub', $id_divisi_sub)
            ->where('tahun', $tahun)
            ->where('cuser', $id_user)
            ->where('id_perspektif = (SELECT id_perspektif from ref_inisiatif where id_inisiatif = ' . $id_inisiatif . ')')
            // ->whereIn('id_divisi', session()->get('id_divisi'))
            ->get()
            ->getRowArray();
    }

    public function cek_bobot_perspektif_bulanan($id_inisiatif, $id_divisi, $id_divisi_sub, $tahun, $bulan, $id_user, $id_bu)
    {
        $str = "";

        if ($id_bu == 60) {
            $str = ' and c.id_divisi = ' . $id_divisi;
        } else {
            $str = ' and c.jenis = 2';
        }

        return $this->db->table('tr_kpi_bulanan a')
            ->select('sum(a.sub_bobot_bulanan) as total, (
                            SELECT
                                    c.bobot 
                                FROM
                                    ref_inisiatif a
                                    LEFT JOIN ref_perspektif b USING ( id_perspektif )
                                    LEFT JOIN ref_perspektif_details c ON b.id_perspektif = c.id_perspektif 
                                WHERE
                                    a.active = 1 
                                    AND b.active = 1 
                                    AND a.id_inisiatif = ' . $id_inisiatif . ' 
                                ' . $str . '
                            ) AS bobot_perspektif ')
            ->join('tr_kpi b', 'a.id_kpi = b.id_kpi', 'left')
            ->where('b.active', 1)
            ->where('a.active', 1)
            ->where('b.id_divisi', $id_divisi)
            ->where('b.id_divisi_sub', $id_divisi_sub)
            ->where('b.tahun', $tahun)
            ->where('a.bulan', $bulan)
            ->where('b.cuser', $id_user)
            ->where('b.id_perspektif = (SELECT id_perspektif from ref_inisiatif where id_inisiatif = ' . $id_inisiatif . ')')
            // ->whereIn('id_divisi', session()->get('id_divisi'))
            ->get()
            ->getRowArray();
    }

    public function cek_target_bulanan($id_kpi, $tahun)
    {
        return $this->db->table('tr_kpi a')
            ->select('b.jenis_satuan, 
                                COALESCE((SELECT sum(target_bulanan) FROM tr_kpi_bulanan where id_kpi = ' . $id_kpi . ' and tahun = ' . $tahun . ' and active = 1),0) as total, 
                                COALESCE((SELECT max(target_bulanan) FROM tr_kpi_bulanan where id_kpi = ' . $id_kpi . ' and tahun = ' . $tahun . ' and active = 1),0) as max_bobot')
            ->join('ref_satuan b', 'a.id_satuan = b.id_satuan', 'left')
            ->where('a.active', 1)
            ->where('a.id_kpi', $id_kpi)
            ->where('a.tahun', $tahun)
            ->get()
            ->getRowArray();
    }

    public function cek_organisasi($id_divisi, $id_divisi_sub, $id_user, $id_bu)
    {
        return $this->db->table('absensi.ref_organisasi')
            ->select('level')
            ->where('id_divisi', $id_divisi)
            ->where('id_divisi_sub', $id_divisi_sub)
            ->where('id_user', $id_user)
            ->where('id_bu', $id_bu)
            ->get()
            ->getRowArray();
    }

    public function cek_inisiatif($id_kpi_atasan)
    {
        return $this->db->table('tr_kpi')
            ->select('id_inisiatif')
            ->where('id_kpi', $id_kpi_atasan)
            ->get()
            ->getRowArray();
    }

    function cek_jabatan($id_user)
    {
        return $this->db->query('select z.* from(select id_bu, id_divisi, id_divisi_sub from absensi.ref_organisasi where active = 1 and nik_pegawai = ' . $id_user . '
        union all
        select id_bu, id_divisi, id_divisi_sub from absensi.ref_pegawai where active = 1 and nik_pegawai = ' . $id_user . ' and status_pegawai in("PKWT", "PKWTT"))z
        GROUP BY z.id_bu, z.id_divisi, z.id_divisi_sub
        ')
            ->getResultArray();
    }
}
