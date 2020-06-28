<?php

require_once(APPPATH .'controllers/Res.php');

Class History extends CI_Controller{

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
        $this->asset = base_url().'assets/customer/';
        
        /* Authentication */
        if(!$this->session->userdata('IS_LOGIN_PPOB')){
            redirect(base_url().'home');
        }
    }

    // menampilkan data kontak
    function index(){
        $data['title'] = 'Home | CRJExpress';
        $data['asset'] = $this->asset;
        $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
        $data['trx'] = json_decode($this->curl->simple_get($this->API.'ppob_transaction?custid='.$this->session->userdata('SESS_DATA')['cust_id']))->result;
        // $data['header']=$this->load->view('templates/header',$data, true);
        $data['content']=$this->load->view('customer/history/index',$data, true);
        // $data['footer']=$this->load->view('templates/footer',$data, true);
		
        $this->load->view('customer/template/index',$data);
    }
    
}