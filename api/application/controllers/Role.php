<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Role extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    // GET:Role || GET:Role/{id}
    function index_get() {
        $id = $this->get('id');
        $code = '';
        if ($id == '') {
            $response_data = $this->db->get('roles')->result();
        } else {
            $this->db->where('id_roles', $id);
            $response_data = $this->db->get('roles')->result();
        }
        if(count($response_data)>1){
            $code = 'DSC1';
        }else{
            $code = 'DSC0';
        }
        $this->response(array('status' => $code, 'result' => $response_data, 200));
    }

    // POST:Role
    function index_post() {
        $code = '';
        
        $data = array(
                    'role_name'         => $this->post('role_name'),
                    'role_description'  => $this->post('role_description')
                );
        $insert = $this->db->insert('roles', $data);
        if ($insert) {
            $code = 'PDS1';
            $this->response(array('status' => $code, 'result' => $data, 200));
        } else {
            $code = 'PDS0';
            $this->response(array('status' => $code, 502));
        }
    }

    // PUT:Role
    function index_put() {
        $code = '';
        $id = $this->put('id');
        
        $data = array(
                'role_name'         => $this->put('role_name'),
                'role_description'  => $this->put('role_description')
                );
        $this->db->where('id_roles', $id);
        $update = $this->db->update('roles', $data);
        if ($update) {
            $code = 'UDS1';
            $this->response(array('status' => $code, 'result' => $data, 200));
        }else {
            $code = 'UDS0';
            $this->response(array('status' => $code, 502));
        }
    }

    // DELETE:Role
    function index_delete() {
        $id = $this->delete('id');
        
        $this->db->where('id_roles', $id);
        $delete = $this->db->delete('roles');
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