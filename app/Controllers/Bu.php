<?php

namespace App\Controllers;

use App\Models\model_bu;
use App\Models\model_menu;

class bu extends BaseController
{
    protected $model_bu;
    protected $model_menu;
    protected $uri;
    public function __construct()
    {
        $this->model_bu = new model_bu();
        $this->model_menu = new model_menu();
        $this->uri = current_url(true);
    }
    public function index()
    {
        if (session('id_user')) {
            $kd_menu_details = 'S03'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                $data['id_user'] = session()->get('id_user');
                $data['nm_user'] = session()->get('nm_user');
                $data['id_level'] = session()->get('id_level');
                return view('bu/index', $data);
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

    public function ax_data_bu()
    {
        if (session('id_user')) {
            $kd_menu_details = 'S03'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $draw = $this->request->getVar('draw');
                $start = $this->request->getVar('start');
                $length = $this->request->getVar('length');
                $search = $this->request->getVar('search')['value'];
                $data = $this->model_bu->getAllbu($length, $start, $search);
                $count = $this->model_bu->getCountAllbu($length, $start, $search);
        
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


    public function ax_data_bu_by_id(){
        if (session('id_user')) {
            $kd_menu_details = 'S03'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_bu = $this->request->getvar('id_bu');
        
                $data = $this->model_bu->getbuById($id_bu);
        
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
            $kd_menu_details = 'S03'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_bu = $this->request->getvar('id_bu');
                $nm_bu = $this->request->getvar('nm_bu');
                $active = $this->request->getvar('active');
        
                $data = array(
                    'id_bu' => $id_bu,
                    'nm_bu' => $nm_bu,
                    'active' => $active,
                );
                if ($id_bu == 0) {
                    $data['id_bu'] = $this->model_bu->insert_bu($data);
                }else{
                    $data['id_bu'] = $this->model_bu->update_bu($data);
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
            $kd_menu_details = 'S03'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_bu = $this->request->getvar('id_bu');
        
                $data = array(
                    'id_bu' => $id_bu,
                    'active' => 2
                );
        
                $data['id_bu'] = $this->model_bu->delete_bu($data);
        
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




    //BUSSINESS ACCESS
    
        public function access($id_bu){
            if (session('id_user')) {
                $kd_menu_details = 'S03'; //CUSTOM CODE FROM DATABASE
                $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
                if (!empty($access)) {
                    $data['id_user'] = session()->get('id_user');
                    $data['nm_user'] = session()->get('nm_user');
                    $data['id_level'] = session()->get('id_level');

                    $data['id_bu'] = $id_bu;
                    $data['combobox_user'] = $this->model_bu->combobox_user();
                    return view('bu/access', $data);
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

        public function ax_data_bu_access()
    {
        if (session('id_user')) {
            $kd_menu_details = 'S03'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $draw = $this->request->getVar('draw');
                $start = $this->request->getVar('start');
                $length = $this->request->getVar('length');
                $search = $this->request->getVar('search')['value'];

                $id_bu = $this->request->getPost('id_bu');

                $data = $this->model_bu->getAllbu_access($length, $start, $search, $id_bu);
                $count = $this->model_bu->getCountAllbu_access($length, $start, $search, $id_bu);
        
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

    public function ax_data_bu_access_by_id(){
        if (session('id_user')) {
            $kd_menu_details = 'S03'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_bu_access = $this->request->getvar('id_bu_access');
        
                $data = $this->model_bu->getbu_accessById($id_bu_access);
        
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


    public function ax_save_data_access(){
        if (session('id_user')) {
            $kd_menu_details = 'S03'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_bu_access = $this->request->getvar('id_bu_access');
                $id_bu = $this->request->getvar('id_bu');
                $id_user = $this->request->getvar('id_user');
                $active = $this->request->getvar('active');
        
                $data = array(
                    'id_bu_access' => $id_bu_access,
                    'id_bu' => $id_bu,
                    'id_user' => $id_user,
                    'active' => $active,
                );
                if ($id_bu_access == 0) {
                    $data['id_bu_access'] = $this->model_bu->insert_bu_access($data);
                }else{
                    $data['id_bu_access'] = $this->model_bu->update_bu_access($data);
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

    public function ax_delete_data_access(){
        if (session('id_user')) {
            $kd_menu_details = 'S03'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_bu_access = $this->request->getvar('id_bu_access');
        
                $data = array(
                    'id_bu_access' => $id_bu_access,
                    'active' => 2
                );
        
                $data['id_bu_access'] = $this->model_bu->delete_bu_access($data);
        
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




