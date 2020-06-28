<?php

require_once(APPPATH .'controllers/Res.php');

Class Dev extends CI_Controller{

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
        $data['title'] = 'CRJExpress';
        $data['asset'] = $this->asset;
        
        // $data['header']=$this->load->view('templates/header',$data, true);
        $data['content']=$this->load->view('dev',$data, true);
        // $data['footer']=$this->load->view('templates/footer',$data, true);
		
        $this->load->view('company/template/index',$data);
    }

    function sync(){
        return false;
        // $province = json_decode($this->curl->simple_get('http://dev.farizdotid.com/api/daerahindonesia/provinsi', array(CURLOPT_BUFFERSIZE => 10)));
        // var_dump($province);
        // return false;
        // foreach($province->semuaprovinsi as $prov){
        //     $dataprovince = array(
        //         'id_province'       =>  $prov->id,
        //         'name'      =>  $prov->nama);
        //     $insert =  $this->curl->simple_post($this->API.'/province', $dataprovince, array(CURLOPT_BUFFERSIZE => 10));
            
        //     $cities = json_decode($this->curl->simple_get('http://dev.farizdotid.com/api/daerahindonesia/provinsi/'.$prov->id.'/kabupaten', array(CURLOPT_BUFFERSIZE => 10)));
        //     foreach($cities->kabupatens as $city){
        //         $datacities = array(
        //             'id_province'       =>  $city->id_prov,
        //             'id_city'       =>  $city->id,
        //             'name'      =>  $city->nama);
        //         $insert =  $this->curl->simple_post($this->API.'/city', $datacities, array(CURLOPT_BUFFERSIZE => 10));
                $districts = json_decode($this->curl->simple_get($this->API.'/district', array(CURLOPT_BUFFERSIZE => 10)));
                // var_dump($districts->result[0]->id_district);
                // return false;
                // count($districts->result)
                $i = 0;
                // $start = $_GET['s'];
                // $end = $_GET['e'];
                $vv=array();
                $villagess = json_decode($this->curl->simple_get($this->API.'/village',array(CURLOPT_BUFFERSIZE => 10)));
                foreach($villagess->result as $vil){
                    array_push($vv,$vil->id_village);
                }
                // var_dump($vv);
                // return false;
                echo date('His');
                $xxx = array();
                for($x=0;$x<count($districts->result);$x++){
                    // var_dump($districts->result[$x]->id_district);
                    
                    $villages = json_decode($this->curl->simple_get('http://dev.farizdotid.com/api/daerahindonesia/provinsi/kabupaten/kecamatan/'.$districts->result[$x]->id_district.'/desa',array(CURLOPT_BUFFERSIZE => 10)));
                    // array_push(array($districts->result[$x]->id_district => $villages->desas));
                    foreach($villages->desas as $village){
                        if(!in_array($village->id_kecamatan,$vv)){
                            array_push($xxx,array(
                                'id_district'       =>  $village->id_kecamatan,
                                'id_village'       =>  $village->id,
                                'name'      =>  $village->nama)
                            );
                        }
                        // $datavillages = array(
                        //     'id_district'       =>  $village->id_kecamatan,
                        //     'id_village'       =>  $village->id,
                        //     'name'      =>  $village->nama);
                        //     $i++;
                        // $insert =  $this->curl->simple_post($this->API.'/village', $datavillages, array(CURLOPT_BUFFERSIZE => 10));
                    }
                }
                var_dump($xxx);
                echo '<br>'.count($xxx);
                echo '<br>'.date('His');
                return false;
                
                foreach($districts->result as $district){
                    $datadistricts = array(
                        'id_district'       =>  $district->id_district,
                        'id_city'       =>  $district->id_city,
                        'name'      =>  $district->name);
                    // $insert =  $this->curl->simple_post($this->API.'/district', $datadistricts, array(CURLOPT_BUFFERSIZE => 10));
                    $villages = json_decode($this->curl->simple_get('http://dev.farizdotid.com/api/daerahindonesia/provinsi/kabupaten/kecamatan/'.$district->id_district.'/desa',array(CURLOPT_BUFFERSIZE => 10)));
                    foreach($villages->desas as $village){
                        $datavillages = array(
                            'id_district'       =>  $village->id_kecamatan,
                            'id_village'       =>  $village->id,
                            'name'      =>  $village->nama);
                            $i++;
                        // $insert =  $this->curl->simple_post($this->API.'/village', $datavillages, array(CURLOPT_BUFFERSIZE => 10));
                    }
                }
                echo $i;
            // }
        // }
    }
}