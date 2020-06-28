<?php

require_once(APPPATH .'controllers/Res.php');

Class Register extends CI_Controller{

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

        // $this->sendmail('adila@crjexpress.id','Click the link below to activate your account <br> <a href="https://crjexpress.id/confirm?enc=8a7581f6c03509d9186e8d43a3eacb994200b3c7fdd78097f392ad5c04f0d1e7">click here</a>','[CONFIRM ACCOUNT #085156710657]');
        
        // $data['header']=$this->load->view('templates/header',$data, true);
        // $data['content']=$this->load->view('company/dashboard/index',$data, true);
        // $data['footer']=$this->load->view('templates/footer',$data, true);
		
        $this->load->view('customer/auth/register',$data);
    }

    // insert data kontak
    function post(){
        if(isset($_POST['register'])){
            // var_dump($this->input->post('password') == $this->input->post('confirm_password'));
            // return false;
            if($this->input->post('password') != $this->input->post('confirm_password')){
                $this->session->set_userdata('IS_LOGIN_PPOB_FAIL',TRUE);
                redirect(base_url().'register');
            }
            $data = array(
                'fullname'  =>  $this->input->post('fullname'),
                'username'  =>  $this->input->post('username'),
                'email'  =>  $this->input->post('email'),
                'phone'  =>  $this->input->post('phone'),
                'password'  =>  $this->input->post('password'),
                'action'  => 'register');
            $this->curl->http_header('APIKey',$this->APIKey);
            $login =  $this->curl->simple_post($this->API.'ppob_customer', $data, array(CURLOPT_BUFFERSIZE => 10));
            $login = json_decode($login);
            // var_dump($login);
            // return false;
            
            if($login->status == 'PDS1')
            {
                $email = $this->input->post('email');
                $subject = '[CONFIRM ACCOUNT #'.$this->input->post('phone').']';
                $message = 'Click the link below to activate your account <br>';
                $message .= '<a href="'.base_url().'confirm?enc='.md5($this->input->post('phone')).md5($this->input->post('password')).'">click here</a>';
                $this->sendmail($email,$message,$subject);
                redirect(base_url().'login');
            }else
            {
                $this->session->set_userdata('IS_LOGIN_PPOB_FAIL',TRUE);
                redirect(base_url().'register');
            }
        }else{
            redirect(base_url().'home');
        }
    }

    function confirm(){

        if($this->session->userdata('IS_LOGIN_PPOB') == TRUE){
            redirect(base_url());
        }
        if(!isset($_GET['enc'])){
            redirect(base_url());
        }
        
        $data = array(
            'token'  =>  $_GET['enc'],
            'action'  => 'confirm');
        $this->curl->http_header('APIKey',$this->APIKey);
        $confirm =  $this->curl->simple_post($this->API.'ppob_customer', $data, array(CURLOPT_BUFFERSIZE => 10));
        $confirm = json_decode($confirm);

        $data['response'] = $confirm->message;

        $data['title'] = 'CRJExpress | Confirm';
        $data['asset'] = $this->asset;
        $this->load->view('customer/auth/confirm_account',$data);
    }

    function logout(){
        $this->session->sess_destroy();
        redirect(base_url().'home');
    }

    function sendmail($email,$message,$subject){
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
        $this->email->from('support@crjexpress.id', 'CRJ Express'); // Email dan nama pengirim
        $this->email->to($email); // Ganti dengan email tujuan Anda
        $this->email->attach($this->asset.'img/brand/blue.png');
        $this->email->subject($subject);
        $this->email->message($message);
        if ($this->email->send()) {
            return true;
        } else {
            return false;
        }
    }
}