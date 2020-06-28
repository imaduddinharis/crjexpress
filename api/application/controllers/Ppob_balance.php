<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Ppob_balance extends REST_Controller {

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
        if ($id == '' && $action == '') {
            $this->db->select('ppob_customer.id_ppob_customer,
                                ppob_customer.phone_number,
                                ppob_customer.email,
                                ppob_balance.balance,
                                ppob_balance.created_at,
                                ppob_balance.updated_at
                                ');
            $this->db->from('ppob_customer');
            $this->db->join('ppob_balance', 'ppob_balance.id_ppob_customer = ppob_customer.id_ppob_customer', 'left');
            $this->db->order_by('ppob_customer.created_at','DESC');
            $response_data = $this->db->get()->result();
        }if ($id == '' && $action == 'countall') {
            $this->db->select_sum('balance');
            $response_data = $this->db->get('ppob_balance')->result();
        } else {
            $this->db->where('ppob_customer.id_ppob_customer', $id);
            $this->db->select('ppob_customer.id_ppob_customer,
                                ppob_customer.phone_number,
                                ppob_customer.email,
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
        $this->db->where('sid',$this->post('sid'));
        $this->db->limit(1);
        $this->db->order_by('created_at','DESC');
        $check = $this->db->get('ppob_history')->result();
        
        $data_history = array(
            'id_ppob_customer'  => $check[0]->id_ppob_customer,
            'description'       => 'top_up_balance',
            'amount'            => $check[0]->amount,
            'status'            => $this->post('status'),
            'sid'               => $this->post('sid')
        );
        // $this->response(array('status' => $code, 'result' => $check, 200));
        // return false;
        $this->db->insert('ppob_history', $data_history);

        $this->db->where('id_ppob_customer',$check[0]->id_ppob_customer);
        $check_balance = $this->db->get('ppob_balance')->result();
        $data = array(
            'balance'  => $check_balance[0]->balance + $check[0]->amount
        );
        $data_trx = array(
            'status'   => $this->post('status')
        );
        $this->db->where('ppob_account',$this->post('sid'));
        $this->db->update('ppob_transaction', $data_trx);
        $update = 0;
        if($this->post('status') == 'berhasil'){
            $this->db->where('id_ppob_customer',$check[0]->id_ppob_customer);
            $update = $this->db->update('ppob_balance', $data);
        }
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
            'description'       => 'top_up_balance',
            'amount'            => $this->put('balance'),
            'sid'               => $this->put('sid'),
            'status'            => 'Process'
        );
        $update = $this->db->insert('ppob_history', $data_balance);
        $data_transaction = array(
            'id_ppob_customer'  => $this->put('id_ppob_customer'),
            'ppob_type'         => 'top_up_balance',
            'qty'               => $this->put('balance'),
            'price'             => $this->put('balance'),
            'ppob_account'      => $this->put('sid'),
            'status'            => 'Process'
        );
        $update2 = $this->db->insert('ppob_transaction', $data_transaction);

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