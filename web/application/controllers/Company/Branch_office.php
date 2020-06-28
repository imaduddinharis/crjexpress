<?php

require_once(APPPATH .'controllers/Res.php');

Class Branch_office extends CI_Controller{

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
        $data['title'] = 'Manage Branch Office';
        $data['asset'] = $this->asset;
        
        $data['boffice'] = json_decode($this->curl->simple_get($this->API.'branch_office'));
        $data['content']=$this->load->view('company/branch_office/index',$data, true);
        $this->load->view('company/template/index',$data);
    }

    
    // menampilkan data kontak
    function detail($id){
        $data['title'] = 'Package';
        $data['asset'] = $this->asset;
        
        $data['package'] = json_decode($this->curl->simple_get($this->API.'package?id_packages='.$id))->result[0];
        // $data['branch'] = json_decode($this->curl->simple_get($this->API.'branch_office?id='.$data['package']->branch_office))->result[0];
        $data['content']=$this->load->view('company/package/detail',$data, true);
        // $data['footer']=$this->load->view('templates/footer',$data, true);
		
        $this->load->view('company/template/index',$data);
    }

    // menampilkan data kontak
    function add(){
        $data['title'] = 'Branch Office - Add New Branch Office';
        $data['asset'] = $this->asset;
        
        $data['province'] = json_decode($this->curl->simple_get($this->API.'province'));
        $data['manager'] = json_decode($this->curl->simple_get($this->API.'user'));
        // var_dump($data['branch_office']);
        // return false;
        // $data['header']=$this->load->view('templates/header',$data, true);
        $data['content']=$this->load->view('company/branch_office/add',$data, true);
        // $data['footer']=$this->load->view('templates/footer',$data, true);
		
        $this->load->view('company/template/index',$data);
    }

    // insert data kontak
    function create(){
        if(isset($_POST['submit'])){
            $data = array(
                'province'  =>  $this->input->post('province'),
                'city'      =>  $this->input->post('city'),
                'village'   =>  $this->input->post('village'),
                'district'  =>  $this->input->post('district')
            );
            // var_dump($data);
            // return false;
            $insert =  json_decode($this->curl->simple_post($this->API.'branch_office', $data, array(CURLOPT_BUFFERSIZE => 10))); 
            if($insert->status == 'PDS1')
            {
                // $invoice = $insert->result->customer->invoice;
                // var_dump($invoice);
                redirect(base_url().'branch-office');
            }else
            {
                redirect(base_url().'branch-office/add');
            }
            
        }else{
            redirect(base_url().'branch-office/add');
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