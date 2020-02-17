<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Ppob_history extends REST_Controller {

    // var $table = 'users';

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    // GET:user || GET:user/{id}
    function index_get() {
        $id = $this->get('id');
        $action = $this->get('action');
        $code = '';
        if ($action == 'checking') {
            $this->db->where('id_ppob_customer', $id);
            $this->db->where_not_in('sid', 'NULL');
            $this->db->limit(1);
            $this->db->order_by('created_at','DESC');
            $response_data = $this->db->get('ppob_history')->result();
        }else if ($action == 'checking_ppob') {
            $this->db->where('id_ppob_customer', $id);
            $this->db->where('sid', NULL);
            $this->db->limit(1);
            $this->db->order_by('created_at','DESC');
            $response_data = $this->db->get('ppob_history')->result();
        } else {
            if ($id == '') {
                $response_data = $this->db->get('ppob_history')->result();
            } else {
                $this->db->where('id_ppob_customer', $id);
                $response_data = $this->db->get('ppob_history')->result();
            }
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
        $this->db->where('sid',$this->post('sid'));
        $this->db->limit(1);
        $this->db->order_by('created_at','DESC');
        $check = $this->db->get('ppob_history')->result();
        
        $data_history = array(
            'id_ppob_customer'  => $check[0]->id_ppob_customer,
            'description'       => 'Top up Balance',
            'amount'            => $check[0]->amount,
            'status'            => $this->post('status')
        );
        $this->db->insert('ppob_history', $data);

        $this->db->where('id_ppob_customer',$check[0]->id_ppob_customer);
        $check_balance = $this->db->get('ppob_balance')->result();
        $data = array(
            'balance'  => $check_balance[0]->balance + $check[0]->amount
        );
        $this->db->where('id_ppob_customer',$check[0]->id_ppob_customer);
        $update = $this->db->update('ppob_balance', $data);
        if ($update) {
            $code = 'PDS1';
            $this->response(array('status' => $code, 'result' => $data_history, 200));
        } else {
            $code = 'PDS0';
            $this->response(array('status' => $code, 502));
        }
    }

    // PUT:User
    function index_put() {
        $code = '';
        $data_balance = array(
            'id_ppob_customer'  => $this->put('id_ppob_customer'),
            'description'       => 'Top up Balance',
            'amount'            => $this->put('balance'),
            'status'            => 'Process'
        );
        $update = $this->db->insert('ppob_history', $data_balance);
        if ($update) {
            $code = 'UDS1';
            $this->response(array('status' => $code, 'result' => $data_balance, 200));
        } else {
            $code = 'UDS0';
            $this->response(array('status' => $code, 502));
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