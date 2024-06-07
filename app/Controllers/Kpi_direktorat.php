<?php

namespace App\Controllers;

use App\Models\model_kpi_direktorat;
use App\Models\model_menu;

class kpi_direktorat extends BaseController
{
    protected $model_kpi_direktorat;
    protected $model_menu;
    protected $uri;
    public function __construct()
    {
        $this->model_kpi_direktorat = new model_kpi_direktorat();
        $this->model_menu = new model_menu();
        $this->uri = current_url(true);
    }
    public function index()
    {
        if (session('id_user')) {
            $kd_menu_details = 'M06'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                $data['id_user'] = session()->get('id_user');
                $data['nm_user'] = session()->get('nm_user');
                $data['id_level'] = session()->get('id_level');
                $data['combobox_perspektif'] = $this->model_kpi_direktorat->combobox_perspektif();
                $data['combobox_tahun'] = range(date("Y")+1, 2020);
                return view('kpi_direktorat/index', $data);
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

    public function ax_data_kpi_direktorat()
    {
        if (session('id_user')) {
            $kd_menu_details = 'M06'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $draw = $this->request->getVar('draw');
                $start = $this->request->getVar('start');
                $length = $this->request->getVar('length');
                $search = $this->request->getVar('search')['value'];
                $data = $this->model_kpi_direktorat->getAllkpi_direktorat($length, $start, $search);
                $count = $this->model_kpi_direktorat->getCountAllkpi_direktorat($length, $start, $search);
        
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


    public function ax_data_kpi_direktorat_by_id(){
        if (session('id_user')) {
            $kd_menu_details = 'M06'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_kpi_direktorat = $this->request->getvar('id_kpi_direktorat');
        
                $data = $this->model_kpi_direktorat->getkpi_direktoratById($id_kpi_direktorat);
        
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
            $kd_menu_details = 'M06'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_kpi_direktorat = $this->request->getvar('id_kpi_direktorat');
                $nm_kpi_direktorat = $this->request->getvar('nm_kpi_direktorat');
                $tahun = $this->request->getvar('tahun');
                $active = $this->request->getvar('active');
        
                $data = array(
                    'id_kpi_direktorat' => $id_kpi_direktorat,
                    'nm_kpi_direktorat' => $nm_kpi_direktorat,
                    'tahun' => $tahun,
                    'active' => $active,
                );
                if ($id_kpi_direktorat == 0) {
                    $data['id_kpi_direktorat'] = $this->model_kpi_direktorat->insert_kpi_direktorat($data);
                }else{
                    $data['id_kpi_direktorat'] = $this->model_kpi_direktorat->update_kpi_direktorat($data);
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
            $kd_menu_details = 'M06'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_kpi_direktorat = $this->request->getvar('id_kpi_direktorat');
        
                $data = array(
                    'id_kpi_direktorat' => $id_kpi_direktorat,
                    'active' => 2
                );
        
                $data['id_kpi_direktorat'] = $this->model_kpi_direktorat->delete_kpi_direktorat($data);
        
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
