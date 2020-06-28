<?php

require_once(APPPATH .'controllers/Res.php');

Class Topup extends CI_Controller{

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
        if($this->session->userdata('IS_LOGIN_PPOB') == FALSE){
            redirect(base_url());
        }
    }

    // menampilkan data kontak
    function index(){
        $data['title'] = 'Home | CRJExpress';
        $data['asset'] = $this->asset;
        $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
        // $data['header']=$this->load->view('templates/header',$data, true);
        if(isset($_GET['success'])&& $_GET['success'] == 'true'){
            $data['content']=$this->load->view('customer/topup/processing',$data, true);
        }else if(isset($_GET['status'])&& $_GET['status'] == 'success'){
            $data['content']=$this->load->view('customer/topup/success',$data, true);
        }else if(isset($_GET['status'])&& $_GET['status'] == 'failed'){
            $data['content']=$this->load->view('customer/topup/index',$data, true);
        }else{
            $data['content']=$this->load->view('customer/topup/index',$data, true);
        }
        
        // $data['footer']=$this->load->view('templates/footer',$data, true);
		
        $this->load->view('customer/template/index',$data);
    }
    function process(){
        if($this->input->post('nominal')<10001){
            redirect(base_url().'topup-saldo?status=failed');
        }else{
            $data_topup = array(
                'key'      => 'CB9D6431-79B4-4B10-A9B5-E2F3E65435CD', // API Key Merchant / Penjual
                'action'   => 'payment',
                'product'  => 'Topup CRJWallet',
                'price'    => $this->input->post('nominal'), // Total Harga
                'quantity' => 1,
                'buyer_phone' => $this->session->userdata('SESS_DATA')['phone_number'],
                'comments' => 'Topup Saldo CRJWallet', // Optional
                'ureturn'  => base_url().'topup-saldo',
                'unotify'  => $this->API.'ppob_balance',
                'ucancel'  => base_url().'topup-saldo',
                'format'   => 'json'
            );
            $post_topup = json_decode($this->curl->simple_post('https://my.ipaymu.com/payment', $data_topup, array(CURLOPT_BUFFERSIZE => 10)));
            // var_dump($post_topup);
            $data_balance = array(
                'id_ppob_customer'  => $this->session->userdata('SESS_DATA')['cust_id'],
                'balance'           => $this->input->post('nominal'),
                'sid'               => $post_topup->sessionID
            );
            $update =  $this->curl->simple_put($this->API.'ppob_balance', $data_balance, array(CURLOPT_BUFFERSIZE => 10));
            if($update){
                redirect($post_topup->url);
            }
        }
    }
}