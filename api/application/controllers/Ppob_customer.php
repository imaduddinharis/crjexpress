<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Ppob_customer extends REST_Controller {

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
            $this->db->select('ppob_customer.id_ppob_customer,
                                ppob_customer.phone_number,
                                ppob_customer.email,
                                ppob_customer.fullname,
                                ppob_customer.username,
                                ppob_customer.status,
                                ppob_balance.balance,
                                ppob_balance.created_at,
                                ppob_balance.updated_at
                                ');
            $this->db->from('ppob_customer');
            $this->db->join('ppob_balance', 'ppob_balance.id_ppob_customer = ppob_customer.id_ppob_customer', 'left');
            $this->db->order_by('ppob_customer.created_at','DESC');
            $response_data = $this->db->get()->result();
        } else {
            $this->db->where('ppob_customer.id_ppob_customer', $id);
            $this->db->select('ppob_customer.id_ppob_customer,
                                ppob_customer.phone_number,
                                ppob_customer.email,
                                ppob_customer.fullname,
                                ppob_customer.username,
                                ppob_customer.status,
                                ppob_balance.balance,
                                ppob_balance.created_at,
                                ppob_balance.updated_at
                                ');
            $this->db->from('ppob_customer');
            $this->db->join('ppob_balance', 'ppob_balance.id_ppob_customer = ppob_customer.id_ppob_customer', 'left');
            $this->db->order_by('ppob_customer.created_at','DESC');
            $response_data = $this->db->get()->result();
        }
        if(count($response_data)>0){
            $code = 'DSC1';
        }else{
            $code = 'DSC0';
        }
        $this->response(array('status' => $code, 'result' => $response_data, 200));
    }

    // POST:user
    function index_post() {
        $code = '';
        $role = array('agent','manager','courier');
        if($this->post('action') == 'login'){
            $this->db->where('status', 'active');
            $this->db->where('phone_number', $this->post('phone'));
            $this->db->where('password', md5($this->post('password')));
            $isValid = $this->db->get('ppob_customer')->result();

            $this->db->where('status', 'active');
            $this->db->where('email', $this->post('phone'));
            $this->db->where('password', md5($this->post('password')));
            $isValid2 = $this->db->get('ppob_customer')->result();
            if (count($isValid)>0) {
                $code = 'BAS1';
                $this->response(array('status' => $code, 'result' => $isValid, 200));
            }else if (count($isValid2)>0) {
                $code = 'BAS1';
                $this->response(array('status' => $code, 'result' => $isValid2, 200));
            } else {
                $code = 'BAS0';
                $this->response(array('status' => $code, 502));
            }
        }else if($this->post('action') == 'confirm'){
            $this->db->where('token', $this->post('token'));
            $select = $this->db->get('ppob_customer')->result();
            $data = array('status'=>'active','token'=>'');
            $this->db->where('token', $this->post('token'));
            $update = $this->db->update('ppob_customer', $data);
            if ($update && count($select)>0) {
                $code = 'BAS1';
                $this->response(array('status' => $update, 'message' => 'Thank you for joining us, now you can enjoy crjexpress services easily', 200));
            } else {
                $code = 'BAS0';
                $this->response(array('status' => $code, 'message' => 'This page has expired', 502));
            }
        }else if($this->post('action') == 'register'){
            $data = array(
                'fullname'  => $this->post('fullname'),
                'username'         => $this->post('username'),
                'phone_number'  => $this->post('phone'),
                'email'         => $this->post('email'),
                'token'         => md5($this->post('phone')).md5($this->post('password')),
                'password'      => md5($this->post('password')),
                'status'        => 'inactive'
            );
            $register = $this->db->insert('ppob_customer', $data);
            $id_ppob_customer = $this->db->insert_id();
            if ($register) {
                $data_balance = array(
                    'id_ppob_customer'  => $id_ppob_customer,
                    'balance'           => 0,
                );
                $this->db->insert('ppob_balance', $data_balance);
                $code = 'PDS1';
                $this->response(array('status' => $code, 'result' => $data, 200));
            } else {
                $code = 'PDS0';
                $this->response(array('status' => $code, 502));
            }
        }else{
            $code = 'PDS0';
            $this->response(array('status' => $code,'message' => 'CHECK YOUR ACTION DATA', 502));
        }
    }

    // PUT:User
    function index_put() {
        $code = '';
        $action = $this->put('action');
        $headers = $this->input->get_request_header('APIKey');
        // $this->response(array('status' => $code, 'message' => $this->input->get_request_header(),502));
        $this->db->where('api_key', $headers);
        $validation = $this->db->get('platform')->result();
        if(count($validation) > 0) {
            if($action == 'check'){
                $this->db->where('email', $this->put('email'));
                $this->db->where('phone_number', $this->put('phone'));
                $update = $this->db->get('ppob_customer')->result();
                if (count($update)>0) {
                    $code = 1;
                    $this->response(array('status' => $code, 200));
                } else {
                    $code = 0;
                    $this->response(array('status' => $code, 502));
                }
            }else if($action == 'update'){
                $data = array(
                    'password'      => md5($this->put('password')),
                );
                $this->db->where('phone_number', $this->put('phone'));
                $update = $this->db->update('ppob_customer', $data);
                if ($update) {
                    $code = 1;
                    $this->response(array('status' => $code, 200));
                } else {
                    $code = 0;
                    $this->response(array('status' => $code, 502));
                }
            }else{
                $code = 'UDS0';
                $this->response(array('status' => $code,'message' => 'CHECK YOUR ACTION', 502));
            }
        }
    }

    // DELETE:User
    function index_delete() {
        $id_users = $this->delete('id_users');
        $id_employees = $this->delete('id_employees');
        
        $this->db->where('id_users', $id_users);
        $delete = $this->db->delete('users');

        $this->db->where('id_employees', $id_employees);
        $deletes = $this->db->delete('employees');

        $this->db->where('id_employees', $id_employees);
        $deletess = $this->db->delete('employees_detail');

        if ($delete && $deletes && $deletess && $id_users != NULL && $id_employees != NULL ) {
            $code = 'DDS1';
            $this->response(array('status' => $code), 201);
        } else {
            $code = 'DDS0';
            $this->response(array('status' => $code, 502));
        }
    }

}
?>