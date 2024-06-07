<?php

namespace App\Controllers;

use App\Models\model_inisiatif;
use App\Models\model_menu;

class inisiatif extends BaseController
{
    protected $model_inisiatif;
    protected $model_menu;
    protected $uri;
    public function __construct()
    {
        $this->model_inisiatif = new model_inisiatif();
        $this->model_menu = new model_menu();
        $this->uri = current_url(true);
    }
    public function index()
    {
        if (session('id_user')) {
            $kd_menu_details = 'M04'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                $data['id_user'] = session()->get('id_user');
                $data['nm_user'] = session()->get('nm_user');
                $data['id_level'] = session()->get('id_level');
                $data['combobox_perspektif'] = $this->model_inisiatif->combobox_perspektif();
                $data['combobox_tahun'] = range(date("Y")+1, 2020);
                return view('inisiatif/index', $data);
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

    public function ax_data_inisiatif()
    {
        if (session('id_user')) {
            $kd_menu_details = 'M04'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $draw = $this->request->getVar('draw');
                $start = $this->request->getVar('start');
                $length = $this->request->getVar('length');
                $search = $this->request->getVar('search')['value'];
                $data = $this->model_inisiatif->getAllinisiatif($length, $start, $search);
                $count = $this->model_inisiatif->getCountAllinisiatif($length, $start, $search);
        
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


    public function ax_data_inisiatif_by_id(){
        if (session('id_user')) {
            $kd_menu_details = 'M04'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_inisiatif = $this->request->getvar('id_inisiatif');
        
                $data = $this->model_inisiatif->getinisiatifById($id_inisiatif);
        
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
            $kd_menu_details = 'M04'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_inisiatif = $this->request->getvar('id_inisiatif');
                $nm_inisiatif = $this->request->getvar('nm_inisiatif');
                $id_perspektif = $this->request->getvar('id_perspektif');
                $tahun = $this->request->getvar('tahun');
                $active = $this->request->getvar('active');
        
                $data = array(
                    'id_inisiatif' => $id_inisiatif,
                    'nm_inisiatif' => $nm_inisiatif,
                    'id_perspektif' => $id_perspektif,
                    'tahun' => $tahun,
                    'active' => $active,
                );
                if ($id_inisiatif == 0) {
                    $data['id_inisiatif'] = $this->model_inisiatif->insert_inisiatif($data);
                }else{
                    $data['id_inisiatif'] = $this->model_inisiatif->update_inisiatif($data);
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
            $kd_menu_details = 'M04'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_inisiatif = $this->request->getvar('id_inisiatif');
        
                $data = array(
                    'id_inisiatif' => $id_inisiatif,
                    'active' => 2
                );
        
                $data['id_inisiatif'] = $this->model_inisiatif->delete_inisiatif($data);
        
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
