<?php

namespace App\Controllers;

use App\Models\model_evaluasi_akhlak;
use App\Models\model_menu;

class evaluasi_akhlak extends BaseController
{
    protected $model_evaluasi_akhlak;
    protected $model_menu;
    protected $uri;
    public function __construct()
    {
        $this->model_evaluasi_akhlak = new model_evaluasi_akhlak();
        $this->model_menu = new model_menu();
        $this->uri = current_url(true);
    }
    public function index()
    {
        if (session('id_user')) {
            $kd_menu_details = 'SP02'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                // dd(session()->get());
                $data['id_user'] = session()->get('id_user');
                $data['nm_user'] = session()->get('nm_user');
                $data['id_level'] = session()->get('id_level');
                $data['combobox_bu'] = $this->model_evaluasi_akhlak->combobox_bu();
                $data['combobox_divisi'] = $this->model_evaluasi_akhlak->combobox_divisi();
                $data['tahun'] = range(2023, date('Y'));
                // $data['combobox_divisi_sub'] = $this->model_evaluasi_akhlak->combobox_divisi_sub();
                if (session()->get('level')) {
                    $data['combobox_pegawai'] = $this->model_evaluasi_akhlak->combobox_pegawai();
                }
                return view('evaluasi_akhlak/index', $data);
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

    public function ax_data_evaluasi_akhlak()
    {
        if (session('id_user')) {
            $kd_menu_details = 'SP02'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $draw = $this->request->getVar('draw');
                $start = $this->request->getVar('start');
                $length = $this->request->getVar('length');
                $search = $this->request->getVar('search')['value'];
                
                $bulan = $this->request->getVar('bulan');
                $tahun = $this->request->getVar('tahun');
                $id_user = $this->request->getVar('id_user');

                $data = $this->model_evaluasi_akhlak->getAllevaluasi_akhlak($length, $start, $search, $bulan, $tahun, $id_user);
                $count = $this->model_evaluasi_akhlak->getCountAllevaluasi_akhlak($length, $start, $search);

                // dd($data);
        
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


    public function ax_data_evaluasi_akhlak_by_id(){
        if (session('id_user')) {
            $kd_menu_details = 'SP02'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_evaluasi_akhlak = $this->request->getvar('id_evaluasi_akhlak');
        
                $data = $this->model_evaluasi_akhlak->getevaluasi_akhlakById($id_evaluasi_akhlak);
        
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
            $kd_menu_details = 'SP02'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_evaluasi_akhlak = $this->request->getvar('id_evaluasi_akhlak');
                $id_akhlak = $this->request->getvar('id_akhlak');
                $id_akhlak_detail = $this->request->getvar('id_akhlak_detail');
                $nilai = $this->request->getvar('nilai');
                $id_user = $this->request->getvar('id_user');
                $id_divisi = $this->request->getvar('id_divisi');
                $id_divisi_sub = $this->request->getvar('id_divisi_sub');
                $bulan = $this->request->getvar('bulan');
                $tahun = $this->request->getvar('tahun');
        
                $data = array(
                    'id_evaluasi_akhlak' => $id_evaluasi_akhlak,
                    'id_akhlak' => $id_akhlak,
                    'id_akhlak_detail' => $id_akhlak_detail,
                    'nilai' => $nilai,
                    'id_user' => $id_user,
                    'id_divisi' => $id_divisi,
                    'id_divisi_sub' => $id_divisi_sub,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                    'cuser' => session()->get('id_user'),
                    'active' => 1,
                );

                // var_dump($kpi_wajib);die();

                // if (in_array(1, session()->get('level'))) {
                //     $level_kpi = 1;
                // }elseif(in_array(2, session()->get('level'))){
                //     $level_kpi = 2;
                // }elseif(in_array(3, session()->get('level'))){
                //     $level_kpi = 3;
                // }elseif(in_array(4, session()->get('level'))){
                //     $level_kpi = 4;
                // }else{
                //     $level_kpi = 5;
                // }



                if ($id_evaluasi_akhlak == 0) {
                    $data['id_evaluasi_akhlak'] = $this->model_evaluasi_akhlak->insert_evaluasi_akhlak($data);
                }else{
                    $data['id_evaluasi_akhlak'] = $this->model_evaluasi_akhlak->update_evaluasi_akhlak($data);
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
            $kd_menu_details = 'SP02'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_evaluasi_akhlak = $this->request->getvar('id_evaluasi_akhlak');
        
                $data = array(
                    'id_evaluasi_akhlak' => $id_evaluasi_akhlak,
                    'active' => 2
                );
        
                $data['id_evaluasi_akhlak'] = $this->model_evaluasi_akhlak->delete_evaluasi_akhlak($data);
        
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


    public function ax_get_detail(){
        if (session('id_user')) {
            $kd_menu_details = 'SP02'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_akhlak = $this->request->getvar('id_akhlak');
        
                $data = $this->model_evaluasi_akhlak->get_akhlak_detail($id_akhlak);
        
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



    //COMBOBOX
    public function combobox_divisi_sub(){
        if (session('id_user')) {
            $kd_menu_details = 'SP02'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_divisi = $this->request->getvar('id_divisi');
        
                $data = $this->model_evaluasi_akhlak->combobox_divisi_sub($id_divisi);
        
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

    public function combobox_kpi(){
        if (session('id_user')) {
            $kd_menu_details = 'SP02'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_bu = $this->request->getvar('id_bu');
                $id_divisi = $this->request->getvar('id_divisi');
                $id_divisi_sub = $this->request->getvar('id_divisi_sub');
                $tahun = $this->request->getvar('tahun');
        
                $data = $this->model_evaluasi_akhlak->combobox_kpi($id_bu, $id_divisi, $id_divisi_sub, $tahun);
        
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

    public function combobox_kpi_atasan(){
        if (session('id_user')) {
            $kd_menu_details = 'SP02'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_bu = $this->request->getvar('id_bu');
                $id_divisi = $this->request->getvar('id_divisi');
                $id_divisi_sub = $this->request->getvar('id_divisi_sub');
                $tahun = $this->request->getvar('tahun');
        
                $data = $this->model_evaluasi_akhlak->combobox_kpi_atasan($id_bu, $id_divisi, $id_divisi_sub, $tahun);

        
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
