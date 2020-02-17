<?php

require_once('Res.php');

Class Routing extends CI_Controller{

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
    }

    // menampilkan data kontak
    function index(){
        if($this->session->userdata('IS_LOGIN') == TRUE){
            redirect(base_url().'dashboard');
        }else if($this->session->userdata('IS_LOGIN_PPOB') == TRUE){
            redirect(base_url().'home');
        }else if($this->session->userdata('IS_LOGIN') == FALSE){
            redirect(base_url().'auth');
        }else{
            redirect(base_url().'home');
        }
    }
    function home(){
        redirect(base_url().'home');
    }
}