<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class City extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    // GET:Auth
    function index_get() {
        $id = $this->get('id_city');
        $id_province = $this->get('id_province');
        $code = '';
        if ($id == '' && $id_province == '') {
            $response_data = $this->db->get('city')->result();
        } else if($id != '') {
            $this->db->where('id_city', $id);
            $response_data = $this->db->get('city')->result();
        } else if($id_province != '') {
            $this->db->where('id_province', $id_province);
            $response_data = $this->db->get('city')->result();
        }
        if(count($response_data)>0){
            $code = 'DSC1';
        }else{
            $code = 'DSC0';
        }
        $this->response(array('status' => $code, 'result' => $response_data, 200));
    }

    // POST:Auth
    function index_post() {
        $code = '';
        
        $data = array(
                    'id_city'   => $this->post('id_city'),
                    'id_province'   => $this->post('id_province'),
                    'name'          => $this->post('name')
                );
        $insert = $this->db->insert('city', $data);
        if ($insert) {
            $code = 'PDS1';
            $this->response(array('status' => $code, 'result' => $data, 200));
        } else {
            $code = 'PDS0';
            $this->response(array('status' => $code, 502));
        }
    }

    // PUT:Auth
    function index_put() {
        $this->response(array('status' => 'ERRRRR', 'message' => 'PUT IS NOT VALID IN THIS API', 404));
    }

    // DELETE:Auth
    function index_delete() {
        $this->response(array('status' => 'ERRRRR', 'message' => 'DELETE IS NOT VALID IN THIS API', 404));
    }

}
?>