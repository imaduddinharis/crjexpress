<?php

require_once(APPPATH .'controllers/Res.php');

Class Forgot_password extends CI_Controller{

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
		
        $this->load->view('customer/auth/forgot_password',$data);
    }

    function confirm(){
        /* Authentication */
        if($this->session->userdata('IS_LOGIN_PPOB') == TRUE){
            redirect(base_url());
        }

        $data['title'] = 'CRJExpress | Authentication';
        $data['asset'] = $this->asset;
        
        // $data['header']=$this->load->view('templates/header',$data, true);
        // $data['content']=$this->load->view('company/dashboard/index',$data, true);
        // $data['footer']=$this->load->view('templates/footer',$data, true);
		
        $this->load->view('customer/auth/confirm_forgot',$data);
    }

    // insert data kontak
    function post(){
        if(isset($_POST['forgot'])){
            if($this->input->post('password') != $this->input->post('confirm_password')){
                $this->session->set_userdata('CONFIRM_PASSWORD',FALSE);
                redirect(base_url().'forgot-password');
            }
            $data = array(
                'email'     =>  $this->input->post('email'),
                'phone'     =>  $this->input->post('phone'),
                'action'    =>  'check');
            $this->curl->http_header('APIKey',$this->APIKey);
            $check =  json_decode($this->curl->simple_put($this->API.'ppob_customer', $data, array(CURLOPT_BUFFERSIZE => 10)));
            if($check->status == 1)
            {
                date_default_timezone_set('Asia/Jakarta');
                $startTime = date('Y-m-d H:i:s');
                $cenvertedTime = date('Y-m-d H:i:s',strtotime('+3 minutes',strtotime($startTime)));
                // var_dump($cenvertedTime);
                // return false;
                $this->session->set_userdata('ACCOUNT_INVALID',FALSE);
                $this->session->set_userdata('CONFIRM_PASSWORD',TRUE);
                $code = rand(1000, 9999);
                $tmp_data = array(
                    'email'     =>  $this->input->post('email'),
                    'phone'     =>  $this->input->post('phone'),
                    'password'  =>  $this->input->post('password'),
                    'expired'   =>  $cenvertedTime,
                    'code'      =>  $code);
                $this->session->set_userdata('SESS_TMP',$tmp_data);
                $sendmail = $this->sendmail($this->input->post('email'),$this->input->post('phone'),$code);
                // var_dump($sendmail);
                // return false;
                redirect(base_url().'forgot-password/confirm');
            }else
            {
                $this->session->set_userdata('ACCOUNT_INVALID',TRUE);
                redirect(base_url().'forgot-password');
            }
        }else if(isset($_POST['confirm'])){
            if($this->input->post('code') != $this->session->userdata('SESS_TMP')['code']){
                $this->session->set_userdata('CONFIRM_PASSWORD',FALSE);
                redirect(base_url().'forgot-password');
            }
            $data = array(
                'password'  =>  $this->session->userdata('SESS_TMP')['password'],
                'phone'     =>  $this->session->userdata('SESS_TMP')['phone'],
                'action'    =>  'update');
            $this->curl->http_header('APIKey',$this->APIKey);
            $check =  json_decode($this->curl->simple_put($this->API.'ppob_customer', $data, array(CURLOPT_BUFFERSIZE => 10)));
            // var_dump($data);
            //     return false;
            if($check->status == 1)
            {
                $this->session->sess_destroy();
                redirect(base_url().'login');
            }else
            {
                $this->session->set_userdata('ACCOUNT_INVALID',TRUE);
                redirect(base_url().'forgot-password');
            }
        }else{
            redirect(base_url().'login');
        }
    }

    function sendmail($email,$hp,$code){
        $cust = explode('@',$email);
        $config = [
            'useragent' => 'CodeIgniter',
            'protocol'  => 'smtp',
            'mailpath'  => '/usr/sbin/sendmail',
            'smtp_host' => 'ssl://mail.crjexpress.id',
            'smtp_user' => 'support@crjexpress.id', // Ganti dengan email gmail Anda
            'smtp_pass' => '+supportcrjexpress', // Password gmail Anda
            'smtp_port' => 465,
            'smtp_keepalive' => TRUE,
            'smtp_crypto' => 'SSL',
            'wordwrap'  => TRUE,
            'wrapchars' => 80,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'validate'  => TRUE,
            'crlf'      => "\r\n",
            'newline'   => "\r\n",
        ];
        $this->load->library('email', $config); // Load library email dan konfigurasinya
        $this->email->from('no-reply@crjexpress.id', 'CRJ Express'); // Email dan nama pengirim
        $this->email->to($email); // Ganti dengan email tujuan Anda
        $this->email->attach($this->asset.'img/brand/blue.png');
        $this->email->subject('Forgot Password '.$hp);
        $this->email->message("Dear ".$cust[0].", <br> This is your code to confirm change password ".$code);
        if ($this->email->send()) {
            return true;
        } else {
            return false;
        }
    }
}