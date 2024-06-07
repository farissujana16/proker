<?php

namespace App\Controllers;

use App\Models\model_laporan_spkd;
use App\Models\model_menu;

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\ValidationException;

class laporan_spkd extends BaseController
{
    protected $model_laporan_spkd;
    protected $model_menu;
    protected $uri;
    public function __construct()
    {
        $this->model_laporan_spkd = new model_laporan_spkd();
        $this->model_menu = new model_menu();
        $this->uri = current_url(true);
    }

    public function index()
    {
        if (session('id_user')) {
            $kd_menu_details = 'L01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                $data['id_user'] = session()->get('id_user');
                $data['nm_user'] = session()->get('nm_user');
                $data['id_level'] = session()->get('id_level');
                $data['combobox_tahun'] = range(date("Y")+1, 2020);
                $data['combobox_bu'] = $this->model_laporan_spkd->combobox_bu();
                return view('laporan_spkd/index', $data);
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

    public function laporan()
    {
        if (session('id_user')) {
            // $kd_menu_details = 'L01'; //CUSTOM CODE FROM DATABASE
            // $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            // if (!empty($access)) {
                $tahun = $this->request->getGet('tahun');
                $bulan = $this->request->getGet('bulan');
                $id_bu = $this->request->getGet('id_bu');
                $id_divisi = $this->request->getGet('id_divisi');
                $id_divisi_sub = $this->request->getGet('id_divisi_sub');
                $id_user = $this->request->getGet('id_user');


                $data['bu'] = $this->model_laporan_spkd->get_bu($id_bu);
                $data['divisi'] = $this->model_laporan_spkd->get_divisi($id_divisi);
                $data['divisi_sub'] = $this->model_laporan_spkd->get_divisi_sub($id_divisi_sub);
                $data['tahun'] = $tahun;
                $data['bulan'] = $this->getbulan($bulan);
                
                $data['perspektif'] = $this->model_laporan_spkd->get_perspektif($id_bu, $id_divisi);
                
                $cek = $this->model_laporan_spkd->cek_user($id_user);
                if (count($cek) > 0) {
                    $data['user'] = $this->model_laporan_spkd->get_user($id_user, $id_divisi, $id_divisi_sub);
                    $data['evaluasi'] = $this->model_laporan_spkd->get_evaluasi($tahun, $bulan, $id_bu, $id_divisi, $id_divisi_sub, $id_user, 0);
                    $data['qr_pembuat'] = $this->qrCode("Dibuat oleh ".$data['user']['contents']);
                    $data['qr_atasan'] = $this->qrCode("Disetujui oleh ".$data['user']['atasan']);
                    return view('laporan_spkd/laporan_atasan', $data);
                }else{
                    $data['user'] = $this->model_laporan_spkd->get_user_staff($id_user, $id_bu, $id_divisi, $id_divisi_sub);
                    $data['evaluasi'] = $this->model_laporan_spkd->get_evaluasi($tahun, $bulan, $id_bu, $id_divisi, $id_divisi_sub, $id_user, $data['user']['id_posisi']);
                    // dd($data['evaluasi']);
                    $data['qr_pembuat'] = $this->qrCode("Dibuat oleh ".$data['user']['contents']);
                    $data['qr_atasan'] = $this->qrCode("Disetujui oleh ".$data['user']['atasan']);
                    return view('laporan_spkd/laporan_staff', $data);
                }
            // }else{
            //     return view('404_page');
            // }
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


    public function laporan_akhlak()
    {
        if (session('id_user')) {
            // $kd_menu_details = 'L01'; //CUSTOM CODE FROM DATABASE
            // $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            // if (!empty($access)) {
                $tahun = $this->request->getGet('tahun');
                $bulan = $this->request->getGet('bulan');
                $id_bu = $this->request->getGet('id_bu');
                $id_divisi = $this->request->getGet('id_divisi');
                $id_divisi_sub = $this->request->getGet('id_divisi_sub');
                $id_user = $this->request->getGet('id_user');


                $data['bu'] = $this->model_laporan_spkd->get_bu($id_bu);
                $data['divisi'] = $this->model_laporan_spkd->get_divisi($id_divisi);
                $data['divisi_sub'] = $this->model_laporan_spkd->get_divisi_sub($id_divisi_sub);
                $data['tahun'] = $tahun;
                $data['bulan'] = $this->getbulan($bulan);
                
                $data['akhlak'] = $this->model_laporan_spkd->get_akhlak();
                $data['evaluasi_akhlak'] = $this->model_laporan_spkd->get_evaluasi_akhlak($id_user, $bulan, $tahun);

                $cek = $this->model_laporan_spkd->cek_user($id_user);
                if (count($cek) > 0) {
                    $data['user'] = $this->model_laporan_spkd->get_user($id_user, $id_divisi, $id_divisi_sub);
                    // $data['evaluasi'] = $this->model_laporan_spkd->get_evaluasi($tahun, $bulan, $id_bu, $id_divisi, $id_divisi_sub, $id_user, 0);
                    $data['qr_pembuat'] = $this->qrCode("Dibuat oleh ".$data['user']['contents']);
                    $data['qr_atasan'] = $this->qrCode("Disetujui oleh ".$data['user']['atasan']);
                }else{
                    $data['user'] = $this->model_laporan_spkd->get_user_staff($id_user, $id_bu, $id_divisi, $id_divisi_sub);
                    // $data['evaluasi'] = $this->model_laporan_spkd->get_evaluasi($tahun, $bulan, $id_bu, $id_divisi, $id_divisi_sub, $id_user, $data['user']['id_posisi']);
                    $data['qr_pembuat'] = $this->qrCode("Dibuat oleh ".$data['user']['contents']);
                    $data['qr_atasan'] = $this->qrCode("Disetujui oleh ".$data['user']['atasan']);
                }
                // dd($data['evaluasi_akhlak']);
                return view('laporan_spkd/laporan_akhlak', $data);
            // }else{
            //     return view('404_page');
            // }
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

    public function ax_data_laporan_spkd()
    {
        if (session('id_user')) {
            $kd_menu_details = 'L01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $draw = $this->request->getVar('draw');
                $start = $this->request->getVar('start');
                $length = $this->request->getVar('length');
                $search = $this->request->getVar('search')['value'];
                $data = $this->model_laporan_spkd->getAlllaporan_spkd($length, $start, $search);
                $count = $this->model_laporan_spkd->getCountAlllaporan_spkd($length, $start, $search);
        
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


    public function ax_data_laporan_spkd_by_id(){
        if (session('id_user')) {
            $kd_menu_details = 'L01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_laporan_spkd = $this->request->getvar('id_laporan_spkd');
        
                $data = $this->model_laporan_spkd->getlaporan_spkdById($id_laporan_spkd);
        
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
            $kd_menu_details = 'L01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_laporan_spkd = $this->request->getvar('id_laporan_spkd');
                $nm_laporan_spkd = $this->request->getvar('nm_laporan_spkd');
                $bobot_level_1 = $this->request->getvar('bobot_level_1');
                $bobot_level_2 = $this->request->getvar('bobot_level_2');
                $bobot_level_3 = $this->request->getvar('bobot_level_3');
                $active = $this->request->getvar('active');
        
                $data = array(
                    'id_laporan_spkd' => $id_laporan_spkd,
                    'nm_laporan_spkd' => $nm_laporan_spkd,
                    'bobot_level_1' => $bobot_level_1,
                    'bobot_level_2' => $bobot_level_2,
                    'bobot_level_3' => $bobot_level_3,
                    'active' => $active,
                );
                if ($id_laporan_spkd == 0) {
                    $data['id_laporan_spkd'] = $this->model_laporan_spkd->insert_laporan_spkd($data);
                }else{
                    $data['id_laporan_spkd'] = $this->model_laporan_spkd->update_laporan_spkd($data);
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
            $kd_menu_details = 'L01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_laporan_spkd = $this->request->getvar('id_laporan_spkd');
        
                $data = array(
                    'id_laporan_spkd' => $id_laporan_spkd,
                    'active' => 2
                );
        
                $data['id_laporan_spkd'] = $this->model_laporan_spkd->delete_laporan_spkd($data);
        
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


    public function combobox_divisi(){
        if (session('id_user')) {
            $kd_menu_details = 'L01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_bu = $this->request->getvar('id_bu');
        
                $data = $this->model_laporan_spkd->combobox_divisi($id_bu);
        
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
            $kd_menu_details = 'L01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_divisi = $this->request->getvar('id_divisi');
        
                $data = $this->model_laporan_spkd->combobox_divisi_sub($id_divisi);
        
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


    public function combobox_pegawai(){
        if (session('id_user')) {
            $kd_menu_details = 'L01'; //CUSTOM CODE FROM DATABASE
            $access = $this->model_menu->selectaccess(session()->get('id_level'), $kd_menu_details);
            if (!empty($access)) {
                
                $id_divisi = $this->request->getvar('id_divisi');
                $id_divisi_sub = $this->request->getvar('id_divisi_sub');
        
                $data = $this->model_laporan_spkd->combobox_pegawai($id_divisi, $id_divisi_sub);
        
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

    function qrCode($isian){
        $writer = new PngWriter();

        // Create QR code
        $qrCode = QrCode::create($isian)
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(ErrorCorrectionLevel::Low)
            ->setSize(300)
            ->setMargin(10)
            ->setRoundBlockSizeMode(RoundBlockSizeMode::Margin)
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));

        // Create generic logo
        $logo = Logo::create('assets/images/survei.png')
            ->setResizeToWidth(100)
            ->setPunchoutBackground(true)
        ;

        // Create generic label
        $label = Label::create('Label')
            ->setTextColor(new Color(255, 0, 0));

        $result = $writer->write($qrCode);
        return $result->getDataUri();
    }

    function getbulan($i){
        $bulan = ["Januari" , "Februari" , "Maret" , "April" , "Mei" , "Juni" , "Juli" ,
        "Agustus" , "September" , "Oktober" , "November" , "Desember"];

        return $bulan[$i - 1];
    }
}
