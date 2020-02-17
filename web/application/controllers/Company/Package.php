<?php

require_once(APPPATH .'controllers/Res.php');

Class Package extends CI_Controller{

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
        $data['title'] = 'Package';
        $data['asset'] = $this->asset;
        
        if(isset($_GET['search']) && $_GET['search'] != ""){
            $data['package'] = json_decode($this->curl->simple_get($this->API.'package?bo='.$this->session->userdata('SESS_DATA')['branch_office'].'&resi='.$_GET['search']));
        }else{
            $data['package'] = json_decode($this->curl->simple_get($this->API.'package?bo='.$this->session->userdata('SESS_DATA')['branch_office']));
        }
        $data['content']=$this->load->view('company/package/index',$data, true);
        $this->load->view('company/template/index',$data);
    }
    function picked(){
        $data['title'] = 'Package';
        $data['asset'] = $this->asset;
        
        
        if($this->session->userdata('SESS_DATA')['role'] == 'courier'){
            if(isset($_GET['search']) && $_GET['search'] != ""){
                $data['list'] = json_decode($this->curl->simple_get($this->API.'package?pic='.$this->session->userdata('SESS_DATA')['username'].'&resi='.$_GET['search']));
                $data['package'] = json_decode($this->curl->simple_get($this->API.'package?resi='.$_GET['search']));
            }else{
                $data['list'] = json_decode($this->curl->simple_get($this->API.'package?pic='.$this->session->userdata('SESS_DATA')['username']));
                $data['package'] = json_decode($this->curl->simple_get($this->API.'package'));
            }
        }else{
            if(isset($_GET['search']) && $_GET['search'] != ""){
                $data['list'] = json_decode($this->curl->simple_get($this->API.'package'));
                $data['package'] = json_decode($this->curl->simple_get($this->API.'package?resi='.$_GET['search']));
            }else{
                $data['list'] = json_decode($this->curl->simple_get($this->API.'package'));
                $data['package'] = json_decode($this->curl->simple_get($this->API.'package'));
            }
        }
        $data['content']=$this->load->view('company/package/pickup',$data, true);
        $this->load->view('company/template/index',$data);
    }

    // menampilkan data kontak
    function detail($id){
        
        $data['title'] = 'Package - Detail';
        $data['asset'] = $this->asset;
        
        $data['package'] = json_decode($this->curl->simple_get($this->API.'package?id_packages='.$id))->result[0];
        $data['history'] = json_decode($this->curl->simple_get($this->API.'history?id_packages='.$id))->result;
        $data['branch'] = json_decode($this->curl->simple_get($this->API.'branch_office?id='.$data['package']->branch_office))->result[0];
        $data['content']=$this->load->view('company/package/detail',$data, true);
        // $data['footer']=$this->load->view('templates/footer',$data, true);
		
        $this->load->view('company/template/index',$data);
    }

    function pickup(){
        if(isset($_POST['pickup'])){
            $data = array(
                'id_packages'       =>  $this->input->post('id_package'),
                'username'          =>  $this->session->userdata('SESS_DATA')['username'],
                'action'            => 'pickup'                
            );
            // var_dump($data);
            // return false;
            $insert =  json_decode($this->curl->simple_post($this->API.'history', $data, array(CURLOPT_BUFFERSIZE => 10))); 
            // var_dump($insert);
            // return false;
            if($insert->status == 'PDS1')
            {
                // $invoice = $insert->result->customer->invoice;
                // var_dump($invoice);
                redirect(base_url().'pickup-package');
            }else
            {
                redirect(base_url().'package/detail/'.$this->input->post('id_package'));
            }
            
        }else{
            redirect(base_url().'package/new-package');
        }
    }
    function drop(){
        if(isset($_POST['drop'])){
            $data = array(
                'id_packages'       =>  $this->input->post('id_package'),
                'username'          =>  $this->session->userdata('SESS_DATA')['username'],
                'action'            => 'drop'                
            );
            // var_dump($data);
            // return false;
            $insert =  json_decode($this->curl->simple_post($this->API.'history', $data, array(CURLOPT_BUFFERSIZE => 10))); 
            // var_dump($insert);
            // return false;
            if($insert->status == 'PDS1')
            {
                // $invoice = $insert->result->customer->invoice;
                // var_dump($invoice);
                redirect(base_url().'pickup-package');
            }else
            {
                redirect(base_url().'package/detail/'.$this->input->post('id_package'));
            }
            
        }else{
            redirect(base_url().'package/new-package');
        }
    }
    function receive(){
        if(isset($_POST['drop'])){
            $data = array(
                'id_packages'       =>  $this->input->post('id_package'),
                'username'          =>  $this->session->userdata('SESS_DATA')['username'],
                'recipient'         =>  $this->input->post('recipient'),
                'action'            => 'received'                
            );
            // var_dump($data);
            // return false;
            $insert =  json_decode($this->curl->simple_post($this->API.'history', $data, array(CURLOPT_BUFFERSIZE => 10))); 
            // var_dump($insert);
            // return false;
            if($insert->status == 'PDS1')
            {
                // $invoice = $insert->result->customer->invoice;
                // var_dump($invoice);
                redirect(base_url().'pickup-package');
            }else
            {
                redirect(base_url().'package/detail/'.$this->input->post('id_package'));
            }
            
        }else{
            redirect(base_url().'package/new-package');
        }
    }

    // menampilkan data kontak
    function add(){
        $data['title'] = 'Package - Add New Package';
        $data['asset'] = $this->asset;
        
        $data['province'] = json_decode($this->curl->simple_get($this->API.'province'));
        // var_dump($data['provinsi']->semuaprovinsi);
        // return false;
        // $data['header']=$this->load->view('templates/header',$data, true);
        $data['content']=$this->load->view('company/package/add',$data, true);
        // $data['footer']=$this->load->view('templates/footer',$data, true);
		
        $this->load->view('company/template/index',$data);
    }

    // insert data kontak
    function create(){
        if(isset($_POST['submit'])){
            if($this->input->post('insurance')!=NULL){
                $insurance = 'on';
            }else{
                $insurance = 'off';
            }
            $data = array(
                'package_type'      =>  $this->input->post('package_type'),
                'package_notes'   =>  $this->input->post('package_notes'),
                'weight'            =>  $this->input->post('weight'),
                'packaging_type'    =>  $this->input->post('packaging_type'),
                'branch_office'     =>  $this->session->userdata('SESS_DATA')['branch_office'],
                'sender'            =>  $this->input->post('sender_name'),
                'sender_phone'      =>  $this->input->post('sender_phone'),
                'sender_mail'       =>  $this->input->post('sender_mail'),
                'recipient'         =>  $this->input->post('recipient_name'),
                'recipient_phone'   =>  $this->input->post('recipient_phone'),
                'recipient_mail'    =>  $this->input->post('recipient_mail'),
                'service'           =>  $this->input->post('service'),
                'insurance'         =>  $insurance,
                'pic'               =>  $this->session->userdata('SESS_DATA')['username'],
                'dest_province'     =>  $this->input->post('province'),
                'dest_city'         =>  $this->input->post('city'),
                'dest_district'     =>  $this->input->post('district'),
                'dest_village'      =>  $this->input->post('village'),
                'detail'            =>  $this->input->post('address_detail')
            );
            // var_dump($data);
            // return false;
            $insert =  json_decode($this->curl->simple_post($this->API.'package', $data, array(CURLOPT_BUFFERSIZE => 10))); 
            if($insert->status == 'PDS1')
            {
                $invoice = $insert->result->customer->invoice;
                // var_dump($invoice);
                redirect(base_url().'package/invoice/'.$invoice);
            }else
            {
                redirect(base_url().'package/new-package');
            }
            
        }else{
            redirect(base_url().'package/new-package');
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