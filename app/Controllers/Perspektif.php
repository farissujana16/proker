<?php

namespace App\Controllers;

use App\Models\model_perspektif;
use App\Models\model_menu;

class perspektif extends BaseController
{
    protected $model_perspektif;
    protected $model_menu;
    protected $uri;
    public function __construct()
    {
        $this->model_perspektif = new model_perspektif();
        $this->model_menu = new model_menu();
        $this->uri = current_url(true);
    }
    public function index()
    {
        if (session('id_user')) {
            $kd_menu_details = 'M01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                $data['id_user'] = session()->get('id_user');
                $data['nm_user'] = session()->get('nm_user');
                $data['id_level'] = session()->get('id_level');
                return view('perspektif/index', $data);
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


    public function details($id_perspektif)
    {
        if (session('id_user')) {
            $kd_menu_details = 'M01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                $data['id_user'] = session()->get('id_user');
                $data['nm_user'] = session()->get('nm_user');
                $data['id_level'] = session()->get('id_level');
                $data['perspektif'] = $this->model_perspektif->getperspektifById($id_perspektif);
                $data['combobox_divisi'] = $this->model_perspektif->combobox_divisi();
                return view('perspektif/details', $data);
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

    public function ax_data_perspektif()
    {
        if (session('id_user')) {
            $kd_menu_details = 'M01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $draw = $this->request->getVar('draw');
                $start = $this->request->getVar('start');
                $length = $this->request->getVar('length');
                $search = $this->request->getVar('search')['value'];
                $data = $this->model_perspektif->getAllperspektif($length, $start, $search);
                $count = $this->model_perspektif->getCountAllperspektif($length, $start, $search);
        
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


    public function ax_data_perspektif_by_id(){
        if (session('id_user')) {
            $kd_menu_details = 'M01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_perspektif = $this->request->getvar('id_perspektif');
        
                $data = $this->model_perspektif->getperspektifById($id_perspektif);
        
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
            $kd_menu_details = 'M01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_perspektif = $this->request->getvar('id_perspektif');
                $nm_perspektif = $this->request->getvar('nm_perspektif');
                $bobot = $this->request->getvar('bobot');
                $active = $this->request->getvar('active');
        
                $data = array(
                    'id_perspektif' => $id_perspektif,
                    'nm_perspektif' => $nm_perspektif,
                    'bobot' => $bobot,
                    'active' => 1,
                );
                if ($id_perspektif == 0) {
                    $data['id_perspektif'] = $this->model_perspektif->insert_perspektif($data);
                }else{
                    $data['id_perspektif'] = $this->model_perspektif->update_perspektif($data);
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
            $kd_menu_details = 'M01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_perspektif = $this->request->getvar('id_perspektif');
        
                $data = array(
                    'id_perspektif' => $id_perspektif,
                    'active' => 2
                );
        
                $data['id_perspektif'] = $this->model_perspektif->delete_perspektif($data);
        
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


    //DETAIL PAGE

    public function ax_data_perspektif_details()
    {
        if (session('id_user')) {
            $kd_menu_details = 'M01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $draw = $this->request->getVar('draw');
                $start = $this->request->getVar('start');
                $length = $this->request->getVar('length');
                $search = $this->request->getVar('search')['value'];
                $id_perspektif = $this->request->getVar('id_perspektif');
                $data = $this->model_perspektif->getAllperspektif_details($length, $start, $search, $id_perspektif);
                $count = $this->model_perspektif->getCountAllperspektif_details($length, $start, $search, $id_perspektif);
        
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

    public function ax_data_perspektif_by_id_details(){
        if (session('id_user')) {
            $kd_menu_details = 'M01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_perspektif_details = $this->request->getvar('id_perspektif_details');
        
                $data = $this->model_perspektif->getperspektifById_details($id_perspektif_details);
        
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


    public function ax_save_data_details(){
        if (session('id_user')) {
            $kd_menu_details = 'M01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_perspektif = $this->request->getvar('id_perspektif');
                $id_perspektif_details = $this->request->getvar('id_perspektif_details');
                $id_divisi = $this->request->getvar('id_divisi');
                $id_divisi_sub = $this->request->getvar('id_divisi_sub');
                $bobot = $this->request->getvar('bobot');
                $active = $this->request->getvar('active');
        
                $data = array(
                    'id_perspektif' => $id_perspektif,
                    'id_perspektif_details' => $id_perspektif_details,
                    'id_divisi' => $id_divisi,
                    'id_divisi_sub' => $id_divisi_sub,
                    'bobot' => $bobot,
                    'active' => 1,
                );
                if ($id_perspektif_details == 0) {
                    $data['id_perspektif_details'] = $this->model_perspektif->insert_perspektif_details($data);
                }else{
                    $data['id_perspektif_details'] = $this->model_perspektif->update_perspektif_details($data);
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

    public function ax_delete_data_details(){
        if (session('id_user')) {
            $kd_menu_details = 'M01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_perspektif_details = $this->request->getvar('id_perspektif_details');
        
                $data = array(
                    'id_perspektif_details' => $id_perspektif_details,
                    'active' => 2
                );
        
                $data['id_perspektif_details'] = $this->model_perspektif->delete_perspektif_details($data);
        
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
            $kd_menu_details = 'M01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_divisi = $this->request->getvar('id_divisi');
        
                $data = $this->model_perspektif->combobox_divisi_sub($id_divisi);
        
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
