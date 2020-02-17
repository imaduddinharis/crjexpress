<?php

require_once(APPPATH .'controllers/Res.php');

Class Login extends CI_Controller{

    var $API ="";
    var $APIKey ="";
    var $asset ="";

    function __construct() {
        parent::__construct();
        
        /* API Host */
        $res = new Res();
        $this->API = $res->getApi();
        $this->APIKey = $res->getApiKey();

        /* Library */
        $this->load->library('session');
        $this->load->library('curl');
        
        /* Helper */
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('path');

        /* Asset */
        $this->asset = base_url().'assets/';

        
        
    }

    // menampilkan data kontak
    function index(){
        /* Authentication */
        if($this->session->userdata('IS_LOGIN_PPOB') == TRUE){
            redirect(base_url());
        }

        $data['title'] = 'CRJExpress | Authentication';
        $data['asset'] = $this->asset;
        
        // $data['header']=$this->load->view('templates/header',$data, true);
        // $data['content']=$this->load->view('company/dashboard/index',$data, true);
        // $data['footer']=$this->load->view('templates/footer',$data, true);
		
        $this->load->view('customer/auth/index',$data);
    }

    // insert data kontak
    function post(){
        if(isset($_POST['login'])){
            $data = array(
                'phone'  =>  $this->input->post('phone'),
                'password'  =>  $this->input->post('password'),
                'action'  => 'login');
            $this->curl->http_header('APIKey',$this->APIKey);
            $login =  $this->curl->simple_post($this->API.'ppob_customer', $data, array(CURLOPT_BUFFERSIZE => 10));
            $login = json_decode($login);
            // var_dump($login);
            // return false;
            if($login->status == 'BAS1')
            {
                $data = array(
                    'cust_id'       => $login->result[0]->id_ppob_customer,
                    'phone_number'  => $login->result[0]->phone_number,
                    'email'         => $login->result[0]->email,
                    'username'      => $login->result[0]->username,
                    'fullname'      => $login->result[0]->fullname
                );
                $this->session->set_userdata('SESS_DATA',$data);
                $this->session->set_userdata('IS_LOGIN_PPOB',TRUE);
                $this->session->set_userdata('IS_LOGIN_PPOB_FAIL',FALSE);
                redirect(base_url().'home');
            }else
            {
                $this->session->set_userdata('IS_LOGIN_PPOB_FAIL',TRUE);
                redirect(base_url().'login');
            }
        }else{
            redirect(base_url().'home');
        }
    }

    function logout(){
        $this->session->sess_destroy();
        redirect(base_url().'home');
    }
}