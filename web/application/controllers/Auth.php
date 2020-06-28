<?php

require_once(APPPATH .'controllers/Res.php');

Class Auth extends CI_Controller{

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
        if($this->session->userdata('IS_LOGIN') == TRUE){
            redirect(base_url());
        }

        $data['title'] = 'CRJExpress | Authentication';
        $data['asset'] = $this->asset;
        
        // $data['header']=$this->load->view('templates/header',$data, true);
        // $data['content']=$this->load->view('company/dashboard/index',$data, true);
        // $data['footer']=$this->load->view('templates/footer',$data, true);
		
        $this->load->view('auth/index',$data);
    }

    // insert data kontak
    function login(){
        if(isset($_POST['login'])){
            $data = array(
                'username'  =>  $this->input->post('username'),
                'password'  =>  $this->input->post('password'));
            $this->curl->http_header('APIKey',$this->APIKey);
            $login =  $this->curl->simple_post($this->API.'auth', $data, array(CURLOPT_BUFFERSIZE => 10));
            $login = json_decode($login);
            // var_dump($login);
            // return false;
            if($login->status == 'BAS1')
            {
                $role = '';                
                if($login->result->account[0]->role == 'manager'){
                    $cek = json_decode($this->curl->simple_get($this->API.'area?id='.$login->result->detail[0]->branch_office));
                    if(count($cek->result)>0){
                        $role = 'manager-area';
                    }else{
                        $role = 'manager';
                    }
                }else{
                    $role = $login->result->account[0]->role;
                }
                // var_dump($login);
                // return false;
                $data = array(
                    'status'        => $login->status,
                    'token'         => $login->token,
                    'username'      => $login->result->account[0]->username,
                    'role'          => $role,
                    'branch_office' => $login->result->detail[0]->branch_office
                );
                $this->session->set_userdata('SESS_DATA',$data);
                $this->session->set_userdata('IS_LOGIN',TRUE);
                $this->session->set_userdata('IS_LOGIN_FAIL',FALSE);
                redirect(base_url().'routing');
            }else
            {
                $this->session->set_userdata('IS_LOGIN_FAIL',TRUE);
                redirect(base_url().'routing');
            }
        }else{
            redirect(base_url().'routing');
        }
    }

    function logout(){
        $this->session->sess_destroy();
        redirect(base_url().'routing');
    }
}