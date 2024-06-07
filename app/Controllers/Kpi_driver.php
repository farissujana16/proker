<?php

namespace App\Controllers;

use App\Models\model_kpi_driver;
use App\Models\model_menu;

class kpi_driver extends BaseController
{
    protected $model_kpi_driver;
    protected $model_menu;
    protected $uri;
    public function __construct()
    {
        $this->model_kpi_driver = new model_kpi_driver();
        $this->model_menu = new model_menu();
        $this->uri = current_url(true);
    }
    public function index()
    {
        if (session('id_user')) {
            $kd_menu_details = 'M05'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                $data['id_user'] = session()->get('id_user');
                $data['nm_user'] = session()->get('nm_user');
                $data['id_level'] = session()->get('id_level');
                $data['combobox_satuan'] = $this->model_kpi_driver->combobox_satuan();
                $data['combobox_tahun'] = range(date("Y")+1, 2020);
                return view('kpi_driver/index', $data);
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

    public function ax_data_kpi_driver()
    {
        if (session('id_user')) {
            $kd_menu_details = 'M05'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $draw = $this->request->getVar('draw');
                $start = $this->request->getVar('start');
                $length = $this->request->getVar('length');
                $search = $this->request->getVar('search')['value'];
                $tahun = $this->request->getVar('tahun');
                $data = $this->model_kpi_driver->getAllkpi_driver($length, $start, $search, $tahun);
                $count = $this->model_kpi_driver->getCountAllkpi_driver($length, $start, $search, $tahun);
        
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


    public function ax_data_kpi_driver_by_id(){
        if (session('id_user')) {
            $kd_menu_details = 'M05'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_kpi_driver = $this->request->getvar('id_kpi_driver');
        
                $data = $this->model_kpi_driver->getkpi_driverById($id_kpi_driver);
        
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
            $kd_menu_details = 'M05'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_kpi_driver = $this->request->getVar('id_kpi_driver');
                $nm_kpi_driver = $this->request->getVar('nm_kpi_driver');
                $sub_bobot = $this->request->getVar('sub_bobot');
                $target = $this->request->getVar('target');
                $target_bulanan = $this->request->getVar('target_bulanan');
                $id_satuan = $this->request->getVar('id_satuan');
                $tahun = $this->request->getVar('tahun');
                $active = $this->request->getVar('active');
        
                $data = array(
                    'id_kpi_driver' => $id_kpi_driver,
                    'nm_kpi_driver' => $nm_kpi_driver,
                    'sub_bobot' => $sub_bobot,
                    'target' => $target,
                    'target_bulanan' => $target_bulanan,
                    'id_satuan' => $id_satuan,
                    'tahun' => $tahun,
                    'active' => $active
                );
                if ($id_kpi_driver == 0) {
                    $data['id_kpi_driver'] = $this->model_kpi_driver->insert_kpi_driver($data);
                }else{
                    $data['id_kpi_driver'] = $this->model_kpi_driver->update_kpi_driver($data);
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
            $kd_menu_details = 'M05'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_kpi_driver = $this->request->getvar('id_kpi_driver');
        
                $data = array(
                    'id_kpi_driver' => $id_kpi_driver,
                    'active' => 2
                );
        
                $data['id_kpi_driver'] = $this->model_kpi_driver->delete_kpi_driver($data);
        
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
