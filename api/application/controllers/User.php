<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class User extends REST_Controller {

    // var $table = 'users';

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    // GET:user || GET:user/{id}
    function index_get() {
        $id = $this->get('id');
        $code = '';
        if ($id == '') {
            $response_data = $this->db->get('users')->result();
        } else {
            $this->db->where('id_users', $id);
            $response_data = $this->db->get('users')->result();
        }
        if(count($response_data)>1){
            $code = 'DSC1';
        }else{
            $code = 'DSC0';
        }
        $this->response(array('status' => $code, 'result' => $response_data, 200));
    }

    // POST:user
    function index_post() {
        $code = '';
        $role = array('superuser','admin','manager','kurir');
        if(in_array($this->post('role'),$role)){
            $data = array(
                        'username'  => $this->post('username'),
                        'password'  => md5($this->post('password')),
                        'email'     => $this->post('email'),
                        'role'      => $this->post('role')
                    );
            $insert = $this->db->insert('users', $data);
            if ($insert) {
                $code = 'PDS1';
                $this->response(array('status' => $code, 'result' => $data, 200));
            } else {
                $code = 'PDS0';
                $this->response(array('status' => $code, 502));
            }
        }else{
            $code = 'PDS0';
            $this->response(array('status' => $code,'message' => 'CHECK YOUR INPUT ROLE', 502));
        }
    }

    // PUT:User
    function index_put() {
        $code = '';
        $id = $this->put('id');
        $role = array('superuser','admin','manager','kurir');
        if(in_array($this->put('role'),$role)){
            $data = array(
                    'username'  => $this->put('username'),
                    'password'  => md5($this->put('password')),
                    'email'     => $this->put('email'),
                    'role'      => $this->put('role')
                    );
            $this->db->where('id_users', $id);
            $update = $this->db->update('users', $data);
            if ($update) {
                $code = 'UDS1';
                $this->response(array('status' => $code, 'result' => $data, 200));
            } else {
                $code = 'UDS0';
                $this->response(array('status' => $code, 502));
            }
        }else{
            $code = 'UDS0';
            $this->response(array('status' => $code,'message' => 'CHECK YOUR INPUT ROLE', 502));
        }
    }

    // DELETE:User
    function index_delete() {
        $id = $this->delete('id');
        
        $this->db->where('id_users', $id);
        $delete = $this->db->delete('users');
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