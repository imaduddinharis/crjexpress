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
        redirect(base_url().'dashboard');
    }
}