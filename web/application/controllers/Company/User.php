<?php

require_once(APPPATH .'controllers/Res.php');

Class User extends CI_Controller{

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
        $data['title'] = 'Manage User';
        $data['asset'] = $this->asset;
        
        $data['users'] = json_decode($this->curl->simple_get($this->API.'user'))->result;
        $data['content']=$this->load->view('company/user/index',$data, true);
        $this->load->view('company/template/index',$data);
    }

    // menampilkan data kontak
    function detail($id){
        $data['title'] = 'Package';
        $data['asset'] = $this->asset;
        
        $data['package'] = json_decode($this->curl->simple_get($this->API.'package?id_packages='.$id))->result[0];
        $data['branch'] = json_decode($this->curl->simple_get($this->API.'branch_office?id='.$data['package']->branch_office))->result[0];
        $data['content']=$this->load->view('company/package/detail',$data, true);
        // $data['footer']=$this->load->view('templates/footer',$data, true);
		
        $this->load->view('company/template/index',$data);
    }

    // menampilkan data kontak
    function add(){
        $data['title'] = 'Manage User - Add New User';
        $data['asset'] = $this->asset;
        
        $data['branch_office'] = json_decode($this->curl->simple_get($this->API.'branch_office'));
        // var_dump($data['branch_office']);
        // return false;
        // $data['header']=$this->load->view('templates/header',$data, true);
        $data['content']=$this->load->view('company/user/add',$data, true);
        // $data['footer']=$this->load->view('templates/footer',$data, true);
		
        $this->load->view('company/template/index',$data);
    }

    // insert data kontak
    function create(){
        if(isset($_POST['submit'])){
            $data = array(
                'username'      =>  $this->input->post('username'),
                'password'      =>  $this->input->post('password'),
                'email'         =>  $this->input->post('email'),
                'role'          =>  $this->input->post('position'),
                'fullname'      =>  $this->input->post('fullname'),
                'address'       =>  $this->input->post('address'),
                'phone_number'  =>  $this->input->post('phone_number'),
                'branch_office' =>  $this->input->post('branch_office')
            );
            // var_dump($data);
            // return false;
            $insert =  json_decode($this->curl->simple_post($this->API.'user', $data, array(CURLOPT_BUFFERSIZE => 10))); 
            if($insert->status == 'PDS1')
            {
                // $invoice = $insert->result->customer->invoice;
                // var_dump($invoice);
                redirect(base_url().'manage-user');
            }else
            {
                redirect(base_url().'manage-user/add');
            }
            
        }else{
            redirect(base_url().'manage-user/add');
        }
    }

    function invoice($invoice){
        $data['title'] = 'Package - Invoice';
        $data['asset'] = $this->asset;
        $data['package'] = json_decode($this->curl->simple_get($this->API.'package?invoice='.$invoice));
        $data['branch'] = json_decode($this->curl->simple_get($this->API.'branch_office?id='.$data['package']->result[0]->branch_office));

        // var_dump($data['branch']);
        // return false;

        $data['content']=$this->load->view('company/package/invoice',$data, true);
        
        $this->load->view('company/template/index',$data);
    }

    // edit data kontak
    function edit(){
        if(isset($_POST['submit'])){
            $data = array(
                'id'       =>  $this->input->post('id'),
                'nama'      =>  $this->input->post('nama'),
                'nomor'=>  $this->input->post('nomor'));
            $update =  $this->curl->simple_put($this->API.'/kontak', $data, array(CURLOPT_BUFFERSIZE => 10)); 
            if($update)
            {
                $this->session->set_flashdata('hasil','Update Data Berhasil');
            }else
            {
               $this->session->set_flashdata('hasil','Update Data Gagal');
            }
            redirect('kontak');
        }else{
            $params = array('id'=>  $this->uri->segment(3));
            $data['datakontak'] = json_decode($this->curl->simple_get($this->API.'/kontak',$params));
            $this->load->view('kontak/edit',$data);
        }
    }

    // delete data kontak
    function delete(){
        if(isset($_POST['delete'])){
            $data = array(
                'id_users'  => $this->input->post('id_users'),
                'id_employees' => $this->input->post('id_employees')
            );
            $delete =  $this->curl->simple_delete($this->API.'user', $data, array(CURLOPT_BUFFERSIZE => 10));
            redirect(base_url().'manage-user');
        }else{
            redirect(base_url().'manage-user');
        }
    }
}