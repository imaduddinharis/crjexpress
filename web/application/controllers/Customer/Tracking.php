<?php

require_once(APPPATH .'controllers/Res.php');

Class Tracking extends CI_Controller{

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
        // if($this->session->userdata('IS_LOGIN') == FALSE){
        //     redirect(base_url());
        // }
    }

    // menampilkan data kontak
    function index(){
        $data['title'] = 'Tracking | CRJExpress';
        $data['asset'] = $this->asset;
        if($this->session->userdata('IS_LOGIN_PPOB')){
            $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
        }
        if(isset($_POST['track'])){
            // $package = json_decode($this->curl->simple_get($this->API.'package?resi='.$this->input->post('resi')))->result;
            $package = json_decode($this->curl->simple_get($this->API.'package?resi='.$this->input->post('resi')))->result;
            // var_dump($this->input->post('resi'));
            $data['package'] = $package;
            $data['history'] = json_decode($this->curl->simple_get($this->API.'history?id_packages='.$package[0]->id_packages))->result;
            $data['content']=$this->load->view('customer/tracking/track',$data, true);
        }else if(isset($_GET['rn'])){
            // $package = json_decode($this->curl->simple_get($this->API.'package?resi='.$this->input->post('resi')))->result;
            $package = json_decode($this->curl->simple_get($this->API.'package?resi='.$_GET['rn']))->result;
            // var_dump($this->input->post('resi'));
            $data['package'] = $package;
            $data['history'] = json_decode($this->curl->simple_get($this->API.'history?id_packages='.$package[0]->id_packages))->result;
            $data['content']=$this->load->view('customer/tracking/track',$data, true);
        }else{
            $data['content']=$this->load->view('customer/tracking/index',$data, true);
        }
        
        $this->load->view('customer/template/index',$data);
    }
    function service(){
        $data['title'] = 'Home | CRJExpress';
        $data['asset'] = $this->asset;
        if($this->session->userdata('IS_LOGIN_PPOB')){
            $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
        }
        // $data['header']=$this->load->view('templates/header',$data, true);
        $data['content']=$this->load->view('customer/home/service',$data, true);
        // $data['footer']=$this->load->view('templates/footer',$data, true);
		
        $this->load->view('customer/template/index',$data);
    }
}