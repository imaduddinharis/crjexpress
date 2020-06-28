<?php

require_once(APPPATH .'controllers/Res.php');

Class Ppob extends CI_Controller{

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

    

    function index(){
        $data['title'] = 'PPOB Transaction';
        $data['asset'] = $this->asset;
        $data['ppob'] = json_decode($this->curl->simple_get($this->API.'ppob_transaction'));
        $data['content']=$this->load->view('company/ppob/index',$data, true);
        $this->load->view('company/template/index',$data);
    }
    function customer(){
        $data['title'] = 'PPOB Transaction';
        $data['asset'] = $this->asset;
        $data['ppob'] = json_decode($this->curl->simple_get($this->API.'ppob_customer'));
        $data['content']=$this->load->view('company/ppob/customer',$data, true);
        $this->load->view('company/template/index',$data);
    }

    
}