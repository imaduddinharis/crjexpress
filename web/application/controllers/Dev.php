<?php

require_once(APPPATH .'controllers/Res.php');

Class Dev extends CI_Controller{

    var $API ="";
    var $asset ="";

    function __construct() {
        parent::__construct();
        
        /* API Host */
        $res = new Res();
        $this->API = $res->getApi();

        /* Library */
        $this->load->library('session');
        $this->load->library('curl');
        
        /* Helper */
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('path');

        /* Asset */
        $this->asset = base_url().'assets/';
        
        /* Authentication */
        if($this->session->userdata('IS_LOGIN') == FALSE){
            redirect(base_url());
        }
    }

    // menampilkan data kontak
    function index(){
        $data['title'] = 'Dashboard';
        $data['asset'] = $this->asset;
        
        // $data['header']=$this->load->view('templates/header',$data, true);
        $data['content']=$this->load->view('dev',$data, true);
        // $data['footer']=$this->load->view('templates/footer',$data, true);
		
        $this->load->view('company/template/index',$data);
    }
}