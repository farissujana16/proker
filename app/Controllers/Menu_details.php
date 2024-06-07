<?php

namespace App\Controllers;

use App\Models\model_menu_details;
use App\Models\model_menu;

class menu_details extends BaseController
{
    protected $model_menu_details;
    protected $model_menu;
    protected $uri;
    public function __construct()
    {
        $this->model_menu_details = new model_menu_details();
        $this->model_menu = new model_menu();
        $this->uri = current_url(true);
    }
    public function index()
    {
        if (session('id_user')) {
            $kd_menu_details = 'S05'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
               
                $data['combobox_menu_groups'] = $this->model_menu_details->combobox_menu_groups();
                return view('menu_details/index', $data);

                
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

    public function ax_data_menu_details()
    {
        if (session('id_user')) {
            $kd_menu_details = 'S05'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $draw = $this->request->getVar('draw');
                $start = $this->request->getVar('start');
                $length = $this->request->getVar('length');
                $search = $this->request->getVar('search')['value'];
                $data = $this->model_menu_details->getAllmenu_details($length, $start, $search);
                $count = $this->model_menu_details->getCountAllmenu_details($length, $start, $search);
        
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


    public function ax_data_menu_details_by_id(){
        if (session('id_user')) {
            $kd_menu_details = 'S05'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
               
                $id_menu_details = $this->request->getvar('id_menu_details');
        
                $data = $this->model_menu_details->getmenu_detailsById($id_menu_details);
        
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
            $kd_menu_details = 'S05'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
               
                $id_menu_details = $this->request->getvar('id_menu_details');
                $nm_menu_details = $this->request->getvar('nm_menu_details');
                $kd_menu_details = $this->request->getvar('kd_menu_details');
                $url = $this->request->getvar('url');
                $position = $this->request->getvar('position');
                $id_menu_groups = $this->request->getvar('id_menu_groups');
                $active = $this->request->getvar('active');
        
                $data = array(
                    'id_menu_details' => $id_menu_details,
                    'id_menu_groups' => $id_menu_groups,
                    'nm_menu_details' => $nm_menu_details,
                    'kd_menu_details' => $kd_menu_details,
                    'url' => $url,
                    'position' => $position,
                    'active' => $active,
                );
                if ($id_menu_details == 0) {
                    $data['id_menu_details'] = $this->model_menu_details->insert_menu_details($data);
                }else{
                    $data['id_menu_details'] = $this->model_menu_details->update_menu_details($data);
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
            $kd_menu_details = 'S05'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
               
                
                $id_menu_details = $this->request->getvar('id_menu_details');
        
                $data = array(
                    'id_menu_details' => $id_menu_details,
                    'active' => 2
                );
        
                $data['id_menu_details'] = $this->model_menu_details->delete_menu_details($data);
        
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
