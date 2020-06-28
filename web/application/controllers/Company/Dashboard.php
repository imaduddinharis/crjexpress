<?php

require_once(APPPATH .'controllers/Res.php');

Class Dashboard extends CI_Controller{

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
        $data['package'] = count(json_decode($this->curl->simple_get($this->API.'package'))->result);
        $data['customer'] = count(json_decode($this->curl->simple_get($this->API.'ppob_customer'))->result);
        $data['employee'] = count(json_decode($this->curl->simple_get($this->API.'user'))->result);
        $data['trx'] = count(json_decode($this->curl->simple_get($this->API.'ppob_transaction'))->result);
        $data['bo'] = count(json_decode($this->curl->simple_get($this->API.'branch_office'))->result);
        $data['area'] = count(json_decode($this->curl->simple_get($this->API.'area'))->result);

        $data_mp = array(
            'commands'  => 'balance',
            'username'  => '081210113977',
            'sign'      => md5('0812101139773345e28cae81da00334bl')
        );
        $post_mp = json_decode($this->curl->simple_post('https://api.mobilepulsa.net/v1/legacy/index', json_encode($data_mp), array(CURLOPT_BUFFERSIZE => 10)));
        $data['balance'] = $post_mp->data->balance;
        $data['cust_balance'] = json_decode($this->curl->simple_get($this->API.'ppob_balance?action=countall'))->result[0]->balance;
        $data['content']=$this->load->view('company/dashboard/index',$data, true);
        // $data['footer']=$this->load->view('templates/footer',$data, true);
		
        $this->load->view('company/template/index',$data);
    }
}