<?php

namespace App\Controllers;

use App\Models\model_kpi;
use App\Models\model_menu;

class kpi extends BaseController
{
    protected $model_kpi;
    protected $model_menu;
    protected $uri;
    public function __construct()
    {
        $this->model_kpi = new model_kpi();
        $this->model_menu = new model_menu();
        $this->uri = current_url(true);
    }

    public function index()
    {
        if (session('id_user')) {
            $kd_menu_details = 'K01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                // dd(session()->get());
                $data['id_user'] = session()->get('id_user');
                $data['nm_user'] = session()->get('nm_user');
                $data['id_level'] = session()->get('id_level');
                // $data['combobox_bu'] = $this->model_kpi->combobox_bu();
                $data['combobox_perspektif'] = $this->model_kpi->combobox_perspektif();
                $data['combobox_satuan'] = $this->model_kpi->combobox_satuan();
                $data['combobox_tahun'] = range(date("Y")+1, 2020);
                $data['combobox_divisi'] = $this->model_kpi->combobox_divisi();
                if (count(session()->get('level')) > 0) {
                    $data['combobox_pegawai'] = $this->model_kpi->combobox_pegawai();
                    $data['jabatan'] = $this->model_kpi->get_jabatan(session()->get('id_user'),session()->get('level'));
                }

                if(session()->get('id_bu') != 60 && count(array_keys(session()->get('level'), 2)) > 1){
                    $data['combobox_bu'] = $this->model_kpi->combobox_bu(session()->get('id_user'));
                }
                // $data['combobox_kpi_atasan'] = $this->model_kpi->combobox_kpi_atasan();

                // dd(session()->get());
                
                return view('kpi/index', $data);
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

    public function kpi_bulanan()
    {
        if (session('id_user')) {
            $kd_menu_details = 'K01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                $data['id_user'] = session()->get('id_user');
                $data['nm_user'] = session()->get('nm_user');
                $data['id_level'] = session()->get('id_level');

                $id_divisi = $this->request->getGet('id_divisi');
                $id_divisi_sub = $this->request->getGet('id_divisi_sub');
                $level = $this->request->getGet('level');
                $tahun = $this->request->getGet('tahun');
                
                $data['tahun'] = $tahun;
                $data['divisi'] = $this->model_kpi->get_divisi($id_divisi);
                $data['divisi_sub'] = $this->model_kpi->get_divisi_sub($id_divisi_sub);
                $data['user'] = $this->model_kpi->get_user(session()->get('id_user'), $id_divisi, $id_divisi_sub);

                $data['kpi'] = $this->model_kpi->get_kpi($tahun, $id_divisi, $id_divisi_sub, $level, session()->get('id_user'));
                $data['perspektif'] = $this->model_kpi->get_perspektif(session()->get('id_bu'), $id_divisi);

                // dd($data['perspektif']);
                
                return view('kpi/kpi_bulanan', $data);
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

    public function ax_data_kpi()
    {
        if (session('id_user')) {
            $kd_menu_details = 'K01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $draw = $this->request->getVar('draw');
                $start = $this->request->getVar('start');
                $length = $this->request->getVar('length');
                $search = $this->request->getVar('search')['value'];

                $tahun = $this->request->getVar('filter_tahun');
                $pegawai = $this->request->getVar('filter_pegawai');

                $id_bu = $this->request->getVar('id_bu');
                $id_divisi = $this->request->getVar('id_divisi');
                $id_divisi_sub = $this->request->getVar('id_divisi_sub');
                $level = $this->request->getVar('level');

                $data = $this->model_kpi->getAllkpi($length, $start, $search, $tahun, $pegawai, $id_bu, $id_divisi, $id_divisi_sub, $level);
                $count = $this->model_kpi->getCountAllkpi($length, $start, $search, $tahun, $pegawai, $id_bu, $id_divisi, $id_divisi_sub, $level);

        
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


    public function ax_data_kpi_by_id(){
        if (session('id_user')) {
            $kd_menu_details = 'K01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_kpi = $this->request->getvar('id_kpi');
        
                $data = $this->model_kpi->getkpiById($id_kpi);
        
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
            $kd_menu_details = 'K01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_kpi = $this->request->getVar('id_kpi');
                $id_kpi_atasan = $this->request->getVar('id_kpi_atasan');
                $nm_kpi = $this->request->getVar('nm_kpi');
                $id_perspektif = $this->request->getVar('id_perspektif');
                $tahun = $this->request->getVar('tahun');
                $id_inisiatif = $this->request->getVar('id_inisiatif');
                $id_divisi = $this->request->getVar('id_divisi');
                $id_divisi_sub = $this->request->getVar('id_divisi_sub');
                $sub_bobot = $this->request->getVar('sub_bobot');
                $id_satuan = $this->request->getVar('id_satuan');
                $polaritas = $this->request->getVar('polaritas');
                $target = $this->request->getVar('target');
                $jenis_perhitungan = $this->request->getVar('jenis_perhitungan');
                $active = $this->request->getVar('active');
                $id_bu = $this->request->getVar('id_bu');
                
                // var_dump(session()->get('id_user'));die();
                $data = array(
                    'id_kpi' => $id_kpi,
                    'id_kpi_atasan' => $id_kpi_atasan,
                    'nm_kpi' => $nm_kpi,
                    'id_perspektif' => $id_perspektif,
                    'tahun' => $tahun,
                    'id_inisiatif' => $id_inisiatif,
                    'id_divisi' => $id_divisi,
                    'id_divisi_sub' => $id_divisi_sub,
                    'id_bu' => $id_bu,
                    'sub_bobot' => $sub_bobot,
                    'id_satuan' => $id_satuan,
                    'id_satuan' => $id_satuan,
                    'polaritas' => $polaritas,
                    'target' => str_replace(',','.',$target),
                    'jenis_perhitungan' => $jenis_perhitungan,
                    'active' => $active,
                    'cuser' => session()->get('id_user'),
                    'approve_dirkeu' => null,
                    'approve_dirsum' => null,
                    'approve_dirkom' => null,
                    'approve_dirtek' => null,
                    'status_approval' => 0,
                );

                if (session()->get('level')) {
                    $level_organisasi = $this->model_kpi->cek_organisasi($id_divisi, $id_divisi_sub, session()->get('id_user'), $id_bu)['level'];
                    // var_dump($level_organisasi);die();
                    if ($level_organisasi > 1) {
                        if ($id_kpi_atasan == 0) {
                            return json_encode(array('status' => 'error', 'message' => 'KPI Atasan belum dipilih')); 
                        }
                    }
                }else{
                    $id_inisiatif = $this->model_kpi->cek_inisiatif($id_kpi_atasan)['id_inisiatif'];
                    if ($id_kpi_atasan == 0) {
                        return json_encode(array('status' => 'error', 'message' => 'KPI Atasan belum dipilih')); 
                    }
                }

                
                $cek_perspektif = $this->model_kpi->cek_bobot_perspektif($id_inisiatif, $id_divisi, $id_divisi_sub, $tahun, session()->get('id_user'), $id_bu);
                
                $cek_data = $this->model_kpi->cek_batas($id_divisi, $id_divisi_sub, $tahun, session()->get('id_user'));
                // var_dump("Batas");die();
                // if (($cek_data['total'] + $sub_bobot ) <= 100) {
                    if ($id_kpi == 0) {
                        if ($polaritas != 0) {
                            if ((($cek_data['total'] + $sub_bobot ) <= 100) && (($cek_perspektif['total'] + $sub_bobot) <= $cek_perspektif['bobot_perspektif'])) {
                                $data['id_kpi'] = $this->model_kpi->insert_kpi($data);
                                return json_encode(array('status' => 'success', 'data' => $data));
                            }else if(($cek_data['total'] + $sub_bobot ) > 100){
                                return json_encode(array('status' => 'error', 'message' => 'Sub Bobot melebihi 100%'));
                            }else if(($cek_perspektif['total'] + $sub_bobot) > $cek_perspektif['bobot_perspektif']){
                                return json_encode(array('status' => 'error', 'message' => 'Sub Bobot melebihi bobot perspektif'));
                            }
                        }else{
                            $data['id_kpi'] = $this->model_kpi->insert_kpi($data);
                            return json_encode(array('status' => 'success', 'data' => $data));
                        }
                    }else{
                        if ($polaritas != 0) {
                            $current_sub_bobot = $this->model_kpi->getkpiById($id_kpi)['sub_bobot'];
                            if (((($cek_data['total'] - $current_sub_bobot) + $sub_bobot ) <= 100) && ((($cek_perspektif['total'] - $current_sub_bobot) + $sub_bobot) <= $cek_perspektif['bobot_perspektif'])) {
                                $data['id_kpi'] = $this->model_kpi->update_kpi($data);
                                return json_encode(array('status' => 'success', 'data' => $data));
                            }else if((($cek_data['total'] - $current_sub_bobot) + $sub_bobot ) > 100){
                                return json_encode(array('status' => 'error', 'message' => 'Sub Bobot melebihi 100%'));
                            }else if((($cek_data['total'] - $current_sub_bobot) + $sub_bobot ) > $cek_perspektif['bobot_perspektif']){
                                return json_encode(array('status' => 'error', 'message' => 'Sub Bobot melebihi bobot perspektif'));
                            }
                        }else{
                            $data['id_kpi'] = $this->model_kpi->update_kpi($data);
                            return json_encode(array('status' => 'success', 'data' => $data));
                        }


                        // $data['id_kpi'] = $this->model_kpi->update_kpi($data);
                        // return json_encode(array('status' => 'success', 'data' => $data));
                    }
                // }else{
                //     return json_encode(array('status' => 'error'));
                // }


                // return json_encode($data);
                
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
            $kd_menu_details = 'K01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_kpi = $this->request->getvar('id_kpi');
        
                $data = array(
                    'id_kpi' => $id_kpi,
                    'active' => 2
                );
        
                $data['id_kpi'] = $this->model_kpi->delete_kpi($data);
                $this->model_kpi ->delete_kpi_bulanan_all($data);
        
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
            $kd_menu_details = 'K01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_kpi = $this->request->getvar('id_kpi');
                $status = $this->request->getvar('status');

                $kpi = $this->model_kpi->getkpiById($id_kpi);
                if (in_array(0, session()->get('level'))) {
                    if (session()->get('id_bu') == $kpi['id_bu']) {
                        $data = array(
                            'id_kpi' => $id_kpi,
                            'status_approval' => $status,
                            'user_approval' => session()->get('id_user'),
                            'approve_dirkeu' => $status,
                            'approve_dirkom' => $status,
                            'approve_dirsum' => $status,
                            'approve_dirtek' => $status,
                        );
                    }else{
                        if(in_array(44, session()->get('id_divisi'))){
                            $data = array(
                                'id_kpi' => $id_kpi,
                                'approve_dirkeu' => $status,
                            );
                        }else if(in_array(45, session()->get('id_divisi'))){
                            $data = array(
                                'id_kpi' => $id_kpi,
                                'approve_dirsum' => $status,
                            );
                        }else if(in_array(46, session()->get('id_divisi'))){
                            $data = array(
                                'id_kpi' => $id_kpi,
                                'approve_dirkom' => $status,
                            );
                        }else if(in_array(47, session()->get('id_divisi'))){
                            $data = array(
                                'id_kpi' => $id_kpi,
                                'approve_dirtek' => $status,
                            );
                        }
                    } 
                }else{
                    $data = array(
                        'id_kpi' => $id_kpi,
                        'status_approval' => $status,
                        'user_approval' => session()->get('id_user'),
                    );
                }
        
        
                $data['id_kpi'] = $this->model_kpi->update_kpi($data);
        
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


    //KPI BULANAN
    public function ax_data_kpi_bulanan()
    {
        if (session('id_user')) {
            $kd_menu_details = 'K01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $draw = $this->request->getVar('draw');
                $start = $this->request->getVar('start');
                $length = $this->request->getVar('length');
                $search = $this->request->getVar('search')['value'];
                $id_kpi = $this->request->getVar('id_kpi');
                $data = $this->model_kpi->getAllkpi_bulanan($length, $start, $search, $id_kpi);
                $count = $this->model_kpi->getCountAllkpi_bulanan($length, $start, $search, $id_kpi);
        
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

    public function ax_save_data_bulanan(){
        if (session('id_user')) {
            $kd_menu_details = 'K01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                 
                $id_kpi = $this->request->getVar('id_kpi');
                $id_kpi_bulanan = $this->request->getVar('id_kpi_bulanan');
                $tahun = $this->request->getVar('tahun');
                $bulan = $this->request->getVar('bulan');
                $target_tahun = $this->request->getVar('target_tahun');
                $target_bulanan = $this->request->getVar('target_bulanan');
                $sub_bobot_bulanan = $this->request->getVar('sub_bobot_bulanan');
                $active = $this->request->getVar('active');
                
                // var_dump($cascading);die();
                $data = array(
                    'id_kpi' => $id_kpi,
                    'id_kpi_bulanan' => $id_kpi_bulanan,
                    'tahun' => $tahun,
                    'bulan' => $bulan,
                    'target_bulanan' => str_replace(',','.',$target_bulanan),
                    'sub_bobot_bulanan' => $sub_bobot_bulanan,
                    'active' => $active,
                    'status' => 0,
                    'cuser' => session()->get('id_user')
                );

                $kpi = $this->model_kpi->getkpiById($id_kpi);

                $cek_target = $this->model_kpi->cek_target_bulanan($id_kpi, $tahun);
                $cek_perspektif = $this->model_kpi->cek_bobot_perspektif_bulanan($kpi['id_inisiatif'], $kpi['id_divisi'], $kpi['id_divisi_sub'], $tahun, $bulan, session()->get('id_user'), session()->get('id_bu'));
                // var_dump($kpi);die();


                if ($id_kpi_bulanan == 0) {
                    if ($kpi['level_kpi'] != 5) {
                        if ($kpi['jenis_perhitungan'] == 1) {
                            if(($cek_perspektif['total'] + $sub_bobot_bulanan) > $cek_perspektif['bobot_perspektif']){
                                return json_encode(array('status' => 'error', 'message' => "Sub bobot melebihi bobot perspektif  "));
                            }elseif (($cek_target['total'] + str_replace(',','.',$target_bulanan)) <= $target_tahun) {
                                $data['id_kpi_bulanan'] = $this->model_kpi->insert_kpi_bulanan($data);
                                return json_encode(array('status' => 'success', 'data' => $data)); 
                            }else{
                                return json_encode(array('status' => 'error', 'message' => "Total Target Bulanan Melebihi Target Tahunan "));
                            }
                        }else if($kpi['jenis_perhitungan'] == 2){
                            if(($cek_perspektif['total'] + $sub_bobot_bulanan) > $cek_perspektif['bobot_perspektif']){
                                return json_encode(array('status' => 'error', 'message' => "Sub bobot melebihi bobot perspektif  "));
                            }elseif (($cek_target['total'] + str_replace(',','.',$target_bulanan))) {
                                $data['id_kpi_bulanan'] = $this->model_kpi->insert_kpi_bulanan($data);
                                return json_encode(array('status' => 'success', 'data' => $data)); 
                            }
                        }elseif ($kpi['jenis_perhitungan'] == 3) {
                            if(str_replace(',','.',$target_bulanan) > $target_tahun){
                                return json_encode(array('status' => 'error', 'message' => "Target Bulanan Melebihi Target Tahunan "));
                            }elseif(($cek_perspektif['total'] + $sub_bobot_bulanan) > $cek_perspektif['bobot_perspektif']){
                                return json_encode(array('status' => 'error', 'message' => "Sub bobot melebihi bobot perspektif  "));
                            }elseif (($cek_target['max_bobot'] < str_replace(',','.',$target_bulanan)) && str_replace(',','.',$target_bulanan) <= $target_tahun) {
                                $data['id_kpi_bulanan'] = $this->model_kpi->insert_kpi_bulanan($data);
                                return json_encode(array('status' => 'success', 'data' => $data)); 
                            }else{
                                return json_encode(array('status' => 'error', 'message' => "Target Tidak boleh lebih kecil dari bulan sebelumnya"));
                            }
                        }
                    }else{
                        $data['id_kpi_bulanan'] = $this->model_kpi->insert_kpi_bulanan($data);
                        return json_encode(array('status' => 'success', 'data' => $data)); 
                    }
                }else{
                    if ($kpi['level_kpi'] != 5) {
                        $target_bulan = $this->model_kpi->getkpiByIdBulanan($id_kpi_bulanan);
                        // var_dump($target_bulan);die();
    
                        if ($kpi['jenis_perhitungan'] == 1) {
                            if((($cek_perspektif['total'] - $target_bulan['sub_bobot_bulanan']) + $sub_bobot_bulanan ) > $cek_perspektif['bobot_perspektif']){
                                return json_encode(array('status' => 'error', 'message' => "Sub bobot melebihi bobot perpektif "));
                            }elseif ((($cek_target['total'] - $target_bulan['target_bulanan']) + str_replace(',','.',$target_bulanan)) <= $target_tahun) {
                                $data['id_kpi_bulanan'] = $this->model_kpi->update_kpi_bulanan($data);
                                return json_encode(array('status' => 'success', 'data' => $data));
                            }else{
                                return json_encode(array('status' => 'error', 'message' => "Total Target Bulanan Melebihi Target Tahunan "));
                            }
                        }elseif($kpi['jenis_perhitungan'] == 2){
                            if((($cek_perspektif['total'] - $target_bulan['sub_bobot_bulanan']) + $sub_bobot_bulanan ) > $cek_perspektif['bobot_perspektif']){
                                return json_encode(array('status' => 'error', 'message' => "Sub bobot melebihi bobot perpektif "));
                            }elseif ((($cek_target['total'] - $target_bulan['target_bulanan']) + str_replace(',','.',$target_bulanan))) {
                                $data['id_kpi_bulanan'] = $this->model_kpi->update_kpi_bulanan($data);
                                return json_encode(array('status' => 'success', 'data' => $data));
                            }
                        }elseif ($kpi['jenis_perhitungan'] == 3) {
                            if(str_replace(',','.',$target_bulanan) > $target_tahun){
                                return json_encode(array('status' => 'error', 'message' => "Target Bulanan Melebihi Target Tahunan "));
                            }elseif((($cek_perspektif['total'] - $target_bulan['sub_bobot_bulanan']) + $sub_bobot_bulanan ) > $cek_perspektif['bobot_perspektif']){
                                return json_encode(array('status' => 'error', 'message' => "Sub bobot melebihi bobot perpektif "));
                            }elseif (($target_bulan['max_sebelum'] < str_replace(',','.',$target_bulanan) && $target_bulan['min_sebelum'] > str_replace(',','.',$target_bulanan)) && str_replace(',','.',$target_bulanan) <= $target_tahun) {
                                $data['id_kpi_bulanan'] = $this->model_kpi->update_kpi_bulanan($data);
                                return json_encode(array('status' => 'success', 'data' => $data));
                            }else{
                                return json_encode(array('status' => 'error', 'message' => "Target Tidak boleh lebih kecil dari bulan sebelumnya atau lebih besar dari bulan selanjutnya"));
                            }
                        }
                    }else{
                        $data['id_kpi_bulanan'] = $this->model_kpi->update_kpi_bulanan($data);
                        return json_encode(array('status' => 'success', 'data' => $data));
                    }
                }
                
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

    public function ax_data_kpi_bulanan_by_id(){
        if (session('id_user')) {
            $kd_menu_details = 'K01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_kpi_bulanan = $this->request->getvar('id_kpi_bulanan');
        
                $data = $this->model_kpi->getkpiByIdBulanan($id_kpi_bulanan);
        
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

    public function ax_delete_data_bulanan(){
        if (session('id_user')) {
            $kd_menu_details = 'K01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_kpi_bulanan = $this->request->getvar('id_kpi_bulanan');
        
                $data = array(
                    'id_kpi_bulanan' => $id_kpi_bulanan,
                    'active' => 2
                );
        
                $data['id_kpi_bulanan'] = $this->model_kpi->delete_kpi_bulanan($data);
        
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

    public function combobox_inisiatif(){
        if (session('id_user')) {
            $kd_menu_details = 'K01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $tahun = $this->request->getvar('tahun');
        
                $data = $this->model_kpi->combobox_inisiatif($tahun);
        
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

    public function combobox_divisi(){
        if (session('id_user')) {
            $kd_menu_details = 'K01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_bu = $this->request->getvar('id_bu');
        
                $data = $this->model_kpi->combobox_divisi($id_bu);
        
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


    public function combobox_divisi_sub(){
        if (session('id_user')) {
            $kd_menu_details = 'K01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_divisi = $this->request->getvar('id_divisi');
        
                $data = $this->model_kpi->combobox_divisi_sub($id_divisi);
        
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
            $kd_menu_details = 'K01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                // $id_divisi = $this->request->getvar('id_divisi');
        
                $data = $this->model_kpi->combobox_kpi_atasan();
        
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
