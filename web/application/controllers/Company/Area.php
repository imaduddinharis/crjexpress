<?php

require_once(APPPATH .'controllers/Res.php');

Class Area extends CI_Controller{

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
        $data['title'] = 'Manage Office Area';
        $data['asset'] = $this->asset;
        
        $data['area'] = json_decode($this->curl->simple_get($this->API.'area'));
        $data['content']=$this->load->view('company/area/index',$data, true);
        $this->load->view('company/template/index',$data);
    }

    
    // menampilkan data kontak
    function detail($id){
        $data['title'] = 'Manage Area '.$id;
        $data['asset'] = $this->asset;
        
        $data['area'] = json_decode($this->curl->simple_get($this->API.'area?id='.$id))->result[0];
        $data['content']=$this->load->view('company/area/detail',$data, true);
        
        $this->load->view('company/template/index',$data);
    }

    // menampilkan data kontak
    function add(){
        $data['title'] = 'Office Area - Add New Office Area';
        $data['asset'] = $this->asset;
        
        $data['office'] = json_decode($this->curl->simple_get($this->API.'branch_office?request=ROAC'));
        // var_dump($data['office']);
        // return false;
        $data['content']=$this->load->view('company/area/add',$data, true);
        
        $this->load->view('company/template/index',$data);
    }

    // insert data kontak
    function create(){
        if(isset($_POST['submit'])){
            $data = array(
                'type'              =>  1,
                'area_name'         =>  $this->input->post('area_name'),
                'area_description'  =>  $this->input->post('area_description'),
                'office_id'         =>  $this->input->post('office_id')
            );
            // var_dump($data);
            // return false;
            $insert =  json_decode($this->curl->simple_post($this->API.'area', $data, array(CURLOPT_BUFFERSIZE => 10))); 
            if($insert->status == 'PDS1')
            {
                // $invoice = $insert->result->customer->invoice;
                // var_dump($invoice);
                redirect(base_url().'office-area');
            }else
            {
                redirect(base_url().'office-area/add');
            }
            
        }else{
            redirect(base_url().'office-area/add');
        }
    }

    function add_branch_office($id){
        $data['title'] = 'Office Area - Add Branch Office to Area';
        $data['asset'] = $this->asset;
        $data['id'] = $id;
        
        $data['office'] = json_decode($this->curl->simple_get($this->API.'branch_office?request=ROAC'));
        // var_dump($data['office']);
        // return false;
        $data['content']=$this->load->view('company/area/add-branch-office',$data, true);
        
        $this->load->view('company/template/index',$data);
    }

    // insert data kontak
    function create_branch_office(){
        if(isset($_POST['submit'])){
            $data = array(
                'type'              =>  2,
                'id_office_area'         =>  $this->input->post('id_office_area'),
                'branch_office'         =>  $this->input->post('office_id')
            );
            // var_dump($data);
            // return false;
            $insert =  json_decode($this->curl->simple_post($this->API.'area', $data, array(CURLOPT_BUFFERSIZE => 10))); 
            if($insert->status == 'PDS1')
            {
                // $invoice = $insert->result->customer->invoice;
                // var_dump($invoice);
                redirect(base_url().'office-area/detail/'.$this->input->post('id_office_area'));
            }else
            {
                redirect(base_url().'office-area/add-branch-office'.$this->input->post('id_office_area'));
            }
            
        }else{
            redirect(base_url().'office-area/add-branch-office'.$this->input->post('id_office_area'));
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
    function delete($id){
        if(empty($id)){
            redirect('kontak');
        }else{
            $delete =  $this->curl->simple_delete($this->API.'/kontak', array('id'=>$id), array(CURLOPT_BUFFERSIZE => 10)); 
            if($delete)
            {
                $this->session->set_flashdata('hasil','Delete Data Berhasil');
            }else
            {
               $this->session->set_flashdata('hasil','Delete Data Gagal');
            }
            redirect('kontak');
        }
    }
}