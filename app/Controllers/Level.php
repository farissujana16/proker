<?php

namespace App\Controllers;

use App\Models\model_level;
use App\Models\model_menu;
// use \Mpdf\Mpdf;

class level extends BaseController
{
    protected $model_level;
    protected $model_menu;
    protected $uri;
    public function __construct()
    {
        $this->model_level = new model_level();
        $this->model_menu = new model_menu();
        $this->uri = current_url(true);
    }
    public function index()
    {
        if (session('id_user')) {
            $kd_menu_details = 'S01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                $data['id_user'] = session()->get('id_user');
                $data['nm_user'] = session()->get('nm_user');
                $data['id_level'] = session()->get('id_level');
                return view('level/index', $data);
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

    public function ax_data_level()
    {
        if (session('id_user')) {
            $kd_menu_details = 'S01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                $draw = $this->request->getVar('draw');
                $start = $this->request->getVar('start');
                $length = $this->request->getVar('length');
                $search = $this->request->getVar('search')['value'];
                $data = $this->model_level->getAllLevel($length, $start, $search);
                $count = $this->model_level->getCountAllLevel($length, $start, $search);

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


    public function ax_data_level_by_id(){

        if (session('id_user')) {
            $kd_menu_details = 'S01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                $id_level = $this->request->getvar('id_level');

                $data = $this->model_level->getLevelById($id_level);

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
            $kd_menu_details = 'S01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_level = $this->request->getvar('id_level');
                $nm_level = $this->request->getvar('nm_level');
                $active = $this->request->getvar('active');
        
                $data = array(
                    'id_level' => $id_level,
                    'nm_level' => $nm_level,
                    'active' => $active,
                );
                if ($id_level == 0) {
                    $data['id_level'] = $this->model_level->insert_level($data);
                }else{
                    $data['id_level'] = $this->model_level->update_level($data);
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
            $kd_menu_details = 'S01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_level = $this->request->getvar('id_level');
        
                $data = array(
                    'id_level' => $id_level,
                    'active' => 2
                );
        
                $data['id_level'] = $this->model_level->delete_level($data);
        
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


    //GROUPS ACCESS PAGE
    public function groups_access($id_level)
    {
        if (session('id_user')) {
            $kd_menu_details = 'S01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
               
                $data['id_level'] = $id_level;
                return view('level/group_access', $data);


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

    public function ax_data_menu_groups_access()
    {
        if (session('id_user')) {
            $kd_menu_details = 'S01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {

                $id_level = $this->request->getVar('id_level');
                $draw = $this->request->getVar('draw');
                $start = $this->request->getVar('start');
                $length = $this->request->getVar('length');
                $search = $this->request->getVar('search')['value'];
                $data = $this->model_level->getAlllevel_groups_access($length, $start, $search, $id_level);
                $count = $this->model_level->getCountAlllevel_groups_access($length, $start, $search);
        
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


    public function ax_set_group_access(){

        if (session('id_user')) {
            $kd_menu_details = 'S01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
               
                $id_level = $this->request->getvar('id_level');
                $id_menu_groups = $this->request->getvar('id_menu_groups');
                $id_menu_groups_access = $this->request->getvar('id_menu_groups_access');
                $active = $this->request->getvar('active');
        
                $data = array(
                    'id_level' => $id_level,
                    'id_menu_groups' => $id_menu_groups,
                    'active' => 1
                );
                if ($id_menu_groups_access == 0 && $active == 0) {
                    $data['id_menu_groups_acccess'] = $this->model_level->save_groups_access_data($data);
                }elseif($id_menu_groups_access != 0 && $active == 0){
                    $data += array('id_menu_groups_access' => $id_menu_groups_access);
                    $data['id_menu_groups_acccess'] = $this->model_level->update_groups_access_data($data);
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


    public function ax_unset_group_access(){

        if (session('id_user')) {
            $kd_menu_details = 'S01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
               
                $id_level = $this->request->getvar('id_level');
                $id_menu_groups = $this->request->getvar('id_menu_groups');
                $id_menu_groups_access = $this->request->getvar('id_menu_groups_access');
                $active = $this->request->getvar('active');
        
                $data = array(
                    'id_level' => $id_level,
                    'id_menu_groups' => $id_menu_groups,
                    'id_menu_groups_access' => $id_menu_groups_access,
                    'active' => 0
                );
        
                $data['id_menu_groups_acccess'] = $this->model_level->update_groups_access_data($data);
        
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


    //DETAILS ACCESS PAGE
    public function details_access($id_level)
    {
        if (session('id_user')) {
            $kd_menu_details = 'S01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
               
                $data['id_level'] = $id_level;
                return view('level/details_access', $data);

                
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

    public function ax_data_menu_details_access()
    {
        if (session('id_user')) {
            $kd_menu_details = 'S01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
               
                $id_level = $this->request->getVar('id_level');
                $draw = $this->request->getVar('draw');
                $start = $this->request->getVar('start');
                $length = $this->request->getVar('length');
                $search = $this->request->getVar('search')['value'];
                $data = $this->model_level->getAlllevel_details_access($length, $start, $search, $id_level);
                $count = $this->model_level->getCountAlllevel_details_access($length, $start, $search);
        
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


    public function ax_set_details_access(){
        if (session('id_user')) {
            $kd_menu_details = 'S01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
               
                $id_level = $this->request->getvar('id_level');
                $id_menu_details = $this->request->getvar('id_menu_details');
                $id_menu_details_access = $this->request->getvar('id_menu_details_access');
                $active = $this->request->getvar('active');
        
                $data = array(
                    'id_level' => $id_level,
                    'id_menu_details' => $id_menu_details,
                    'active' => 1
                );
                if ($id_menu_details_access == 0 && $active == 0) {
                    $data['id_menu_details_acccess'] = $this->model_level->save_details_access_data($data);
                }elseif($id_menu_details_access != 0 && $active == 0){
                    $data += array('id_menu_details_access' => $id_menu_details_access);
                    $data['id_menu_details_acccess'] = $this->model_level->update_details_access_data($data);
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


    public function ax_unset_details_access(){
        if (session('id_user')) {
            $kd_menu_details = 'S01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
               
                $id_level = $this->request->getvar('id_level');
                $id_menu_details = $this->request->getvar('id_menu_details');
                $id_menu_details_access = $this->request->getvar('id_menu_details_access');
                $active = $this->request->getvar('active');
        
                $data = array(
                    'id_level' => $id_level,
                    'id_menu_details' => $id_menu_details,
                    'id_menu_details_access' => $id_menu_details_access,
                    'active' => 0
                );
        
                $data['id_menu_details_acccess'] = $this->model_level->update_details_access_data($data);
        
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


    public function cetak(){
        $jenis = $this->request->getVar('jenis');

        if ($jenis == 1) {
            $this->_mPDF('Testing File','Testing');
        }else{
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename= Laporan_JulmahWfoRwLibur.xls");
            return view('level/excel');
        }
    }

    function _mPDF($judul, $isi){
        $mpdf = new \Mpdf\Mpdf(
            [
                'format' => 'A4',
                'orientation' => 'L'
            ]
        );
        $mpdf->WriteHTML($isi);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $mpdf->Output($judul.'.pdf','I');
    }
}
