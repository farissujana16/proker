<?php

namespace App\Models;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;


class model_evaluasi extends Model
{
    protected $db;
    // protected $table      = 'ref_evaluasi';
    // protected $primaryKey = 'id_evaluasi';
    // protected $useAutoIncrement = true;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    public function getAllevaluasi($length, $start, $search, $bulan, $tahun, $id_user, $id_bu, $id_divisi, $id_divisi_sub, $level)
    {
        if ($id_user == 0) {
            $info = $this->cek_jabatan(session()->get('username'));
            if (count(session()->get('level')) > 0) {
                $str = ' and a.id_bu in(' . implode(",", array_column($info, 'id_bu')) . ') and a.id_divisi in(' . implode(",", array_column($info, 'id_divisi')) . ') and a.id_divisi_sub in(' . implode(",", array_column($info, 'id_divisi_sub')) . ')';
            } else {
                $str = ' and a.id_bu in(' . implode(",", array_column($info, 'id_bu')) . ') and a.id_divisi in(' . implode(",", array_column($info, 'id_divisi')) . ') and a.id_divisi_sub in(' . implode(",", array_column($info, 'id_divisi_sub')) . ') and a.cuser = ' . session()->get('id_user') . '';
            }
            $cuser = session()->get('id_user');
        } else {
            if ($level != 5) {
                $str = ' and a.id_bu = ' . $id_bu . ' and a.id_divisi = ' . $id_divisi . ' and a.id_divisi_sub = ' . $id_divisi_sub . ' and a.level_kpi = ' . $level . '';
            } else {
                $str = ' and a.id_bu = ' . $id_bu . ' and a.id_divisi = ' . $id_divisi . ' and a.id_divisi_sub = ' . $id_divisi_sub . ' and a.level_kpi = ' . $level . ' and a.cuser = ' . $id_user . '';
            }
            $cuser = $id_user;
        }

        if (session()->get('id_posisi') == 10) {
            return $this->db->table('( SELECT id_kpi_driver as id_kpi, nm_kpi_driver as nm_kpi, sub_bobot, nm_satuan, target, 2 as polaritas target_bulanan FROM tr_kpi_driver WHERE active = 1 and tahun = ' . $tahun . ' )z')
                ->select('z.*,
                            COALESCE (( SELECT id_spkd FROM tr_spkd WHERE id_kpi_driver = z.id_kpi and bulan = ' . $bulan . ' and tahun = ' . $tahun . ' and cuser = ' . $cuser . ' ), 0 ) AS id_spkd,
                            COALESCE (( SELECT target_bulan FROM tr_spkd WHERE id_kpi_driver = z.id_kpi and bulan = ' . $bulan . ' and tahun = ' . $tahun . ' and cuser = ' . $cuser . ' ), NULL ) AS target_bulan,
                            COALESCE (( SELECT realisasi FROM tr_spkd WHERE id_kpi_driver = z.id_kpi and bulan = ' . $bulan . ' and tahun = ' . $tahun . ' and cuser = ' . $cuser . '), NULL ) AS realisasi,
                            COALESCE (( SELECT pencapaian FROM tr_spkd WHERE id_kpi_driver = z.id_kpi and bulan = ' . $bulan . ' and tahun = ' . $tahun . ' and cuser = ' . $cuser . '), NULL ) AS pencapaian,
                            COALESCE (( SELECT nilai FROM tr_spkd WHERE id_kpi_driver = z.id_kpi and bulan = ' . $bulan . ' and tahun = ' . $tahun . ' and cuser = ' . $cuser . '), NULL ) AS nilai,
                            COALESCE (( SELECT STATUS FROM tr_spkd WHERE id_kpi_driver = z.id_kpi and bulan = ' . $bulan . ' and tahun = ' . $tahun . ' and cuser = ' . $cuser . '), NULL ) AS status')
                ->like('z.nm_kpi', $search)
                ->get($start, $length)
                ->getResultArray();;
        } else {
            return $this->db->table(
                '(
                            select a.id_kpi,a.nm_kpi, a.sub_bobot, a.nm_satuan, a.target, a.active, a.level_kpi, a.polaritas, a.cuser,b.target_bulanan 
                            from tr_kpi a 
                            left join tr_kpi_bulanan b USING ( id_kpi ) 
                            where a.tahun = ' . $tahun . ' 
                            ' . $str . '
                            and a.status_approval = 1 
                            AND b.tahun = ' . $tahun . '
                            AND b.bulan = ' . $bulan . '
                            and a.active = 1) as z'
            )
                ->select('z.* ,
                            COALESCE((select id_spkd from tr_spkd where id_kpi = z.id_kpi and bulan = ' . $bulan . ' and tahun = ' . $tahun . ' and cuser = ' . $cuser . '),0) as id_spkd,
                            COALESCE((select target_bulan from tr_spkd where id_kpi = z.id_kpi and bulan = ' . $bulan . ' and tahun = ' . $tahun . ' and cuser = ' . $cuser . '),null) as target_bulan,
                            COALESCE((select realisasi from tr_spkd where id_kpi = z.id_kpi and bulan = ' . $bulan . ' and tahun = ' . $tahun . ' and cuser = ' . $cuser . '),null) as realisasi,
                            COALESCE((select pencapaian from tr_spkd where id_kpi = z.id_kpi and bulan = ' . $bulan . ' and tahun = ' . $tahun . ' and cuser = ' . $cuser . '),null) as pencapaian,
                            COALESCE((select nilai from tr_spkd where id_kpi = z.id_kpi and bulan = ' . $bulan . ' and tahun = ' . $tahun . ' and cuser = ' . $cuser . '),null) as nilai,
                            COALESCE((select status from tr_spkd where id_kpi = z.id_kpi and bulan = ' . $bulan . ' and tahun = ' . $tahun . ' and cuser = ' . $cuser . '),null) as status')
                ->where('z.active', 1)
                ->like('z.nm_kpi', $search)
                ->get($start, $length)
                ->getResultArray();
        }
    }

    public function getCountAllevaluasi($length, $start, $search, $bulan, $tahun, $id_user)
    {

        $count = array();
        if ($id_user == 0) {
            $user = session()->get('id_user');
        } else {
            $user = $id_user;
        }
        if (session()->get('id_posisi') == 10) {
            $count['recordsFiltered'] = $this->db->table('tr_kpi_driver a')
                ->select('count(a.id_kpi_driver) as recordsFiltered')
                ->where('a.active', 1)
                ->like('a.nm_kpi_driver', $search)
                ->get()
                ->getRowArray()['recordsFiltered'];

            $count['recordsTotal'] = $this->db->table('tr_kpi_driver a')
                ->select('count(a.id_kpi_driver) as recordsTotal')
                ->where('a.active', 1)
                ->get()
                ->getRowArray()['recordsTotal'];
        } else {
            $count['recordsFiltered'] = $this->db->table('tr_kpi a')
                ->select('count(a.id_kpi) as recordsFiltered')
                ->join('tr_kpi_bulanan b', 'a.id_kpi = b.id_kpi', 'left')
                ->where('a.active', 1)
                ->where('a.cuser', $user)
                ->where('a.tahun', $tahun)
                ->where('b.tahun', $tahun)
                ->where('b.bulan', $bulan)
                ->like('nm_kpi', $search)
                ->get()
                ->getRowArray()['recordsFiltered'];

            $count['recordsTotal'] = $this->db->table('tr_kpi a')
                ->select('count(a.id_kpi) as recordsTotal')
                ->join('tr_kpi_bulanan b', 'a.id_kpi = b.id_kpi', 'left')
                ->where('a.active', 1)
                ->where('a.cuser', $user)
                ->where('a.tahun', $tahun)
                ->where('b.tahun', $tahun)
                ->where('b.bulan', $bulan)
                ->get()
                ->getRowArray()['recordsTotal'];
        }

        return $count;
    }

    public function getevaluasiById($id_spkd, $bulan)
    {
        return $this->db->table('tr_spkd a')
            ->select('b.nm_satuan, b.target, b.nm_kpi, c.target_bulanan, a.id_kpi, a.id_spkd, a.realisasi, a.keterangan, a.status')
            ->join("tr_kpi b", "a.id_kpi = b.id_kpi", "left")
            ->join("tr_kpi_bulanan c", "b.id_kpi = c.id_kpi", "left")
            ->where('a.active', 1)
            ->where('b.active', 1)
            ->where('a.id_spkd', $id_spkd)
            ->where('c.bulan', $bulan)
            ->get()
            ->getRowArray();
    }

    public function insert_evaluasi($data)
    {
        $this->db->table('tr_spkd')
            ->insert($data);
        return $this->db->insertID();
    }

    public function update_evaluasi($data)
    {
        $this->db->table('tr_spkd')
            ->where('id_spkd', $data['id_spkd'])
            ->update($data);
        return $data['id_spkd'];
    }

    public function insert_evaluasi_spkd($data)
    {
        $this->db->table('tr_spkd_evaluasi')
            ->insert($data);
        return $this->db->insertID();
    }

    public function update_evaluasi_spkd($data)
    {
        $this->db->table('tr_spkd_evaluasi')
            ->where('id_spkd', $data['id_spkd'])
            ->update($data);
        return $data['id_spkd'];
    }


    public function delete_evaluasi($data)
    {
        $this->db->table('tr_spkd')
            ->where('id_spkd', $data['id_spkd'])
            ->update($data);
        return $data['id_spkd'];
    }


    public function get_kpi($id_user, $id_divisi, $tgl, $tahun)
    {
        return $this->db->query('select z.*, 
        COALESCE((select pencapaian from tr_spkd where id_kpi_personal = z.id_kpi_personal and tgl_spkd like "%' . $tgl . '%"),0) as pencapaian, 
        COALESCE((select id_spkd from tr_spkd where id_kpi_personal = z.id_kpi_personal and tgl_spkd like "%' . $tgl . '%"),0) as id_spkd
        from(
            select * from tr_kpi_personal where cuser = ' . $id_user . ' and id_bu = 60 and id_divisi in (' . $id_divisi . ') and tahun = ' . $tahun . ' and status_approval = 2 and active = 1
        )z')->getResultArray();
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


    //COMBOBOX

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

            return $this->db->query('select z.id_user, z.contents as nm_pegawai, z.id_divisi, z.id_divisi_sub, id_bu, level from(SELECT
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
