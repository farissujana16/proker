<?php

namespace App\Controllers;

use App\Models\model_evaluasi;
use App\Models\model_menu;

class evaluasi extends BaseController
{
    protected $model_evaluasi;
    protected $model_menu;
    protected $uri;
    public function __construct()
    {
        $this->model_evaluasi = new model_evaluasi();
        $this->model_menu = new model_menu();
        $this->uri = current_url(true);
    }
    public function index()
    {
        if (session('id_user')) {
            $kd_menu_details = 'SP03'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                $data['id_user'] = session()->get('id_user');
                $data['nm_user'] = session()->get('nm_user');
                $data['id_level'] = session()->get('id_level');
                $data['tahun'] = range(2023, date('Y'));
                if (session()->get('level')) {
                    $data['combobox_pegawai'] = $this->model_evaluasi->combobox_pegawai();
                    $data['jabatan'] = $this->model_evaluasi->get_jabatan(session()->get('id_user'),session()->get('level'));
                }
                // dd($data['combobox_pegawai']);
                // dd(session()->get('divisi'));

                return view('evaluasi/index', $data);
            }else{
                return view('404_page');
            }
        }else{
            if ($this->uri->getSegment(1) != null || $this->uri->getSegment(1) != "") {
                $url = $this->uri->getSegment(1);
                if ($this->uri->getSegment(2) != null || $this->uri->getSegment(2) != "") {
                    $url = $url.' '.$this->uri->getSegment(2);
                }
                return redirect()->to('home/relogin?url='.$url);
            } else {
                return redirect()->to('/');
            }
        }
        
    }

    public function ax_data_evaluasi()
    {
        if (session('id_user')) {
            $kd_menu_details = 'SP03'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $draw = $this->request->getVar('draw');
                $start = $this->request->getVar('start');
                $length = $this->request->getVar('length');
                $search = $this->request->getVar('search')['value'];
                
                $bulan = $this->request->getVar('bulan');
                $tahun = $this->request->getVar('tahun');
                $id_user = $this->request->getVar('id_user');
                $id_bu = $this->request->getVar('id_bu');
                $id_divisi = $this->request->getVar('id_divisi');
                $id_divisi_sub = $this->request->getVar('id_divisi_sub');
                $level = $this->request->getVar('level');
                
                $data = $this->model_evaluasi->getAllevaluasi($length, $start, $search, $bulan, $tahun, $id_user, $id_bu, $id_divisi, $id_divisi_sub, $level);
                $count = $this->model_evaluasi->getCountAllevaluasi($length, $start, $search, $bulan, $tahun, $id_user, $id_bu, $id_divisi, $id_divisi_sub, $level);
        
                return json_encode(array('recordsTotal' => $count['recordsTotal'], 'recordsFiltered' => $count['recordsFiltered'], 'draw' => $draw, 'search' => $search, 'data' => $data ));

                
            }else{
                return view('404_page');
            }
        }else{
            if ($this->uri->getSegment(1) != null || $this->uri->getSegment(1) != "") {
                $url = $this->uri->getSegment(1);
                if ($this->uri->getSegment(2) != null || $this->uri->getSegment(2) != "") {
                    $url = $url.' '.$this->uri->getSegment(2);
                }
                return redirect()->to('home/relogin?url='.$url);
            } else {
                return redirect()->to('/');
            }
        }
        
        
    }


    public function ax_data_evaluasi_by_id(){
        if (session('id_user')) {
            $kd_menu_details = 'SP03'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_spkd = $this->request->getvar('id_spkd');
                $bulan = $this->request->getvar('bulan');

        
                $data = $this->model_evaluasi->getevaluasiById($id_spkd, $bulan);
        
                return json_encode($data);

                
            }else{
                return view('404_page');
            }
        }else{
            if ($this->uri->getSegment(1) != null || $this->uri->getSegment(1) != "") {
                $url = $this->uri->getSegment(1);
                if ($this->uri->getSegment(2) != null || $this->uri->getSegment(2) != "") {
                    $url = $url.' '.$this->uri->getSegment(2);
                }
                return redirect()->to('home/relogin?url='.$url);
            } else {
                return redirect()->to('/');
            }
        }
        
    }


    public function ax_save_data(){
        if (session('id_user')) {
            $kd_menu_details = 'SP03'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_spkd_evaluasi = $this->request->getvar('id_spkd_evaluasi');
                $id_spkd = $this->request->getvar('id_spkd');
                $id_kpi = $this->request->getvar('id_kpi');
                $target_bulan = $this->request->getvar('target_bulan');
                $realisasi = $this->request->getvar('realisasi');
                $bulan = $this->request->getvar('bulan');
                $tahun = $this->request->getvar('tahun');
                $penyebab = $this->request->getVar('penyebab');
                $tindakan_perbaikan = $this->request->getVar('tindakan_perbaikan');
                $target_perbaikan = $this->request->getVar('target_perbaikan');
                $waktu_perbaikan = $this->request->getVar('waktu_perbaikan');
                $cuser = session()->get('id_user');
                $active = 1;
        
                $data = array(
                    'id_spkd' => $id_spkd,
                    'target_bulan' => str_replace(',','.',$target_bulan),
                    'realisasi' => str_replace(',','.',$realisasi),
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                    'cuser' => $cuser,
                    'active' => $active,
                    'status' => 0,
                );

                $data2 = array(
                    'id_spkd' => $id_spkd,
                    'penyebab' => $penyebab,
                    'tindakan_perbaikan' => $tindakan_perbaikan,
                    'target_perbaikan' => $target_perbaikan,
                    'waktu_perbaikan' => $waktu_perbaikan,
                    'active' => $active,
                    'cuser' => $cuser,
                );

                if (session()->get('id_posisi') == 10) {
                    $data['id_kpi_driver'] = $id_kpi;
                }else{
                    $data['id_kpi'] = $id_kpi;
                }


                if ($id_spkd == 0) {
                    $data['id_spkd'] = $this->model_evaluasi->insert_evaluasi($data);
                    $data2['id_spkd'] = $data['id_spkd'];
                    $this->model_evaluasi->insert_evaluasi_spkd($data2);
                }else{
                    $spkd = $this->model_evaluasi->getevaluasiById($id_spkd, $bulan);
                    
                    if ($spkd['status'] == 2) {
                        $data['status'] = 1;
                    }else{
                        $data['status'] = 0;
                    }
                    $data['id_spkd'] = $this->model_evaluasi->update_evaluasi($data);
                    $this->model_evaluasi->update_evaluasi_spkd($data2);
                }

                return json_encode($data);
                
            }else{
                return view('404_page');
            }
        }else{
            if ($this->uri->getSegment(1) != null || $this->uri->getSegment(1) != "") {
                $url = $this->uri->getSegment(1);
                if ($this->uri->getSegment(2) != null || $this->uri->getSegment(2) != "") {
                    $url = $url.' '.$this->uri->getSegment(2);
                }
                return redirect()->to('home/relogin?url='.$url);
            } else {
                return redirect()->to('/');
            }
        }


    }

    public function ax_delete_data(){
        if (session('id_user')) {
            $kd_menu_details = 'SP03'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_evaluasi = $this->request->getvar('id_evaluasi');
        
                $data = array(
                    'id_evaluasi' => $id_evaluasi,
                    'active' => 2
                );
        
                $data['id_evaluasi'] = $this->model_evaluasi->delete_evaluasi($data);
        
                return json_encode($data);

                
            }else{
                return view('404_page');
            }
        }else{
            if ($this->uri->getSegment(1) != null || $this->uri->getSegment(1) != "") {
                $url = $this->uri->getSegment(1);
                if ($this->uri->getSegment(2) != null || $this->uri->getSegment(2) != "") {
                    $url = $url.' '.$this->uri->getSegment(2);
                }
                return redirect()->to('home/relogin?url='.$url);
            } else {
                return redirect()->to('/');
            }
        }
    }


    public function ax_approve_data(){
        if (session('id_user')) {
            $kd_menu_details = 'SP03'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_spkd = $this->request->getvar('id_spkd');

                $data = array(
                    'id_spkd' => $id_spkd,
                    'status' => 1
                );
        
                $data['id_spkd'] = $this->model_evaluasi->update_evaluasi($data);
        
                return json_encode($data);

                
            }else{
                return view('404_page');
            }
        }else{
            if ($this->uri->getSegment(1) != null || $this->uri->getSegment(1) != "") {
                $url = $this->uri->getSegment(1);
                if ($this->uri->getSegment(2) != null || $this->uri->getSegment(2) != "") {
                    $url = $url.' '.$this->uri->getSegment(2);
                }
                return redirect()->to('home/relogin?url='.$url);
            } else {
                return redirect()->to('/');
            }
        }
        
    }

    public function ax_reject_data(){
        if (session('id_user')) {
            $kd_menu_details = 'SP03'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_spkd = $this->request->getvar('id_spkd');
                $keterangan = $this->request->getvar('keterangan');

                $data = array(
                    'id_spkd' => $id_spkd,
                    'keterangan' => $keterangan,
                    'status' => 2
                );
        
                $data['id_spkd'] = $this->model_evaluasi->update_evaluasi($data);
        
                return json_encode($data);

                
            }else{
                return view('404_page');
            }
        }else{
            if ($this->uri->getSegment(1) != null || $this->uri->getSegment(1) != "") {
                $url = $this->uri->getSegment(1);
                if ($this->uri->getSegment(2) != null || $this->uri->getSegment(2) != "") {
                    $url = $url.' '.$this->uri->getSegment(2);
                }
                return redirect()->to('home/relogin?url='.$url);
            } else {
                return redirect()->to('/');
            }
        }
        
    }

    public function ax_get_kpi(){
        if (session('id_user')) {
            $kd_menu_details = 'SP03'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_user = $this->request->getVar('id_user');
                $id_divisi = implode(',', session()->get('id_divisi'));
                $tgl = $this->request->getvar('tgl');
                $year = explode('-', $tgl);
                $tahun = $year[0];
        
                $data = $this->model_evaluasi->get_kpi($id_user, $id_divisi, $tgl, $tahun);
        
                return json_encode($data);

                
            }else{
                return view('404_page');
            }
        }else{
            if ($this->uri->getSegment(1) != null || $this->uri->getSegment(1) != "") {
                $url = $this->uri->getSegment(1);
                if ($this->uri->getSegment(2) != null || $this->uri->getSegment(2) != "") {
                    $url = $url.' '.$this->uri->getSegment(2);
                }
                return redirect()->to('home/relogin?url='.$url);
            } else {
                return redirect()->to('/');
            }
        }
    }

    
}
