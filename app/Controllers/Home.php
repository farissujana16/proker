<?php

namespace App\Controllers;

class Home extends BaseController
{
    private $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    public function error()
    {
        return view('404_page');
    }

    public function index()
    {

        if (session('id_user')) {
            return redirect()->back();
        }
        return view('login');
    }

    public function relogin()
    {
        if (!empty($this->request->getVar('url'))) {
            // $alamat = $this->request->getGet('url');
            $alamat = $this->request->getVar('url');
            // $pecah = explode(' ', $data['url']);
            $pecah = explode(' ', $alamat);
            $str = '';
            // $data['url'] = '';
            // if (count($pecah)>0) {
            //     $alamat = $pecah[0].'/';
            //     for ($x=1;$x<count($pecah);$x++) {
            //         $str .= $pecah[$x].'/';
            //     }

            // } else {
            //     $str = $alamat;
            // }
            // print_r($data['url']);die;
            $data['url'] = $alamat;
            $data['alert'] = "Silahkan login kembali";
            // var_dump($data);die();
            return view('login', $data);

            //jika seasson login belum sudah ada maka tampilkan home
            if (session('id_user')) {
                //jika seasson ada direct ke home
                return redirect()->to('dashboard');
            }
        } else {
            $data['alert'] = "Silahkan login kembali";
            return view('login', $data);
            //jika seasson login belum sudah ada maka tampilkan home
            if (session('id_user')) {
                //jika seasson ada direct ke home
                return redirect()->to('dashboard');
            }
        }
    }

    // public function login()
    // {
    //     return view('login');
    // }

    public function proses()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getVar('password');

        $query = $this->db->table('sso.ref_user a')
            ->select('a.id_user, a.nm_user, a.username, a.id_perusahaan, e.id_bu, d.nm_bu, d.id_divre, e.id_divisi, e.id_divisi_sub, e.id_posisi, a.active, a.cdate, a.cuser, a.developer,a.password, b.nm_perusahaan, b.alloc, b.language, c.id_level, c.nm_level, f.level, f.id_organisasi')
            ->join('sso.ref_perusahaan b', ' a.id_perusahaan = b.id_perusahaan', 'left')
            ->join('sso.ref_user_aplikasi c', ' a.id_user = c.id_user', 'left')
            ->join('absensi.ref_pegawai e', ' a.username = e.nik_pegawai', 'left')
            ->join('sso.ref_bu d', ' e.id_bu = d.id_bu', 'left')
            ->join('absensi.ref_organisasi f', 'a.id_user = f.id_user', 'left')
            ->where('a.username', $username)
            ->where('c.kd_aplikasi', 'eproker')
            ->where('a.active', 1)
            ->get()->getRowArray();

        if ($query) {
            $level = $this->db->table('absensi.ref_organisasi')->select('level')->where('id_user', $query['id_user'])->where('active', 1)->get()->getResultArray();
            $id_divisi = $this->db->table('absensi.ref_organisasi')->select('id_divisi')->where('id_user', $query['id_user'])->where('active', 1)->get()->getResultArray();
            $id_divisi_sub = $this->db->table('absensi.ref_organisasi')->select('id_divisi_sub')->where('id_user', $query['id_user'])->where('active', 1)->get()->getResultArray();
            $id_organisasi = $this->db->table('absensi.ref_organisasi')->select('id_organisasi')->where('id_user', $query['id_user'])->where('active', 1)->get()->getResultArray();
            // var_dump(md5($password));die();
            // echo $query['password'];
            //    if (password_verify($password, $query['password'])) {
            if (md5($password) == $query['password']) {
                $sess = [
                    'nm_user' => $query['nm_user'],
                    'id_user' => $query['id_user'],
                    'username' => $query['username'],
                    // 'password' => $query['password'],
                    'id_level' => $query['id_level'],
                    'nm_level' => $query['nm_level'],
                    'id_bu' => $query['id_bu'],
                    'level' => array_column($level, 'level'),
                    'id_divisi' => array_column($id_divisi, 'id_divisi'),
                    'id_divisi_sub' => array_column($id_divisi_sub, 'id_divisi_sub'),
                    'id_perusahaan' => $query['id_perusahaan'],
                    'nm_perusahaan' => $query['nm_perusahaan'],
                    'divisi' => $query['id_divisi'],
                    'divisi_sub' => $query['id_divisi_sub'],
                    'id_organisasi' => array_column($id_organisasi, 'id_organisasi'),
                    'id_divre' => $query['id_divre'],
                    'id_posisi' => $query['id_posisi'],

                    'active' => $query['active'],
                ];
                // var_dump($sess);die();
                session()->set($sess);
                if ($this->request->getPost('url_access') != '') {
                    return redirect()->to(base_url() . $this->request->getPost('url_access'));
                } else {
                    return redirect()->to(base_url() . 'dashboard');
                }
            } else {
                return redirect()->back()->with('error', 'Password Salah');
            }
        } else {
            return redirect()->back()->with('error', 'User Tidak Ditemukan');
        }
    }


    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url());
    }
}
