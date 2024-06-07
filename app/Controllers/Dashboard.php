<?php

namespace App\Controllers;

use App\Models\model_dashboard;
// use \Mpdf\Mpdf;

class dashboard extends BaseController
{
    protected $model_dashboard;
    protected $uri;
    public function __construct()
    {
        $this->model_dashboard = new model_dashboard();
        $this->uri = current_url(true);
    }
    public function index()
    {
        if (session('id_user')) {

            return view('dashboard');

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
