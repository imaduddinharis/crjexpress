<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Service extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    // GET:Service || GET:Service/{id}
    function index_get() {
        $id = $this->get('id');
        $code = '';
        if ($id == '') {
            $response_data = $this->db->get('service')->result();
        } else {
            $this->db->where('id_service', $id);
            $response_data = $this->db->get('service')->result();
        }
        if(count($response_data)>1){
            $code = 'DSC1';
        }else{
            $code = 'DSC0';
        }
        $this->response(array('status' => $code, 'result' => $response_data, 200));
    }

    // POST:Service
    function index_post() {
        $code = '';
        
        $data = array(
                    'service_name'         => $this->post('service_name'),
                    'description'  => $this->post('description')
                );
        $insert = $this->db->insert('service', $data);
        if ($insert) {
            $code = 'PDS1';
            $this->response(array('status' => $code, 'result' => $data, 200));
        } else {
            $code = 'PDS0';
            $this->response(array('status' => $code, 502));
        }
    }

    // PUT:Service
    function index_put() {
        $code = '';
        $id = $this->put('id');
        
        $data = array(
                'service_name'         => $this->put('service_name'),
                'description'  => $this->put('description')
                );
        $this->db->where('id_service', $id);
        $update = $this->db->update('service', $data);
        if ($update) {
            $code = 'UDS1';
            $this->response(array('status' => $code, 'result' => $data, 200));
        }else {
            $code = 'UDS0';
            $this->response(array('status' => $code, 502));
        }
    }

    // DELETE:Service
    function index_delete() {
        $id = $this->delete('id');
        
        $this->db->where('id_service', $id);
        $delete = $this->db->delete('service');
        if ($delete && $id != NULL) {
            $code = 'DDS1';
            $this->response(array('status' => $code), 201);
        } else {
            $code = 'DDS0';
            $this->response(array('status' => $code, 502));
        }
    }

}
?>