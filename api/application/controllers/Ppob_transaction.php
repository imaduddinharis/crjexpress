<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Ppob_transaction extends REST_Controller {

    // var $table = 'users';

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    // GET:user || GET:user/{id}
    function index_get() {
        $id = $this->get('id');
        $custid = $this->get('custid');
        $action = $this->get('action');
        $code = '';
        if ($id == '' && $action == '' && $custid == '') {
            $response_data = $this->db->get('ppob_transaction')->result();
        }else if($action == 'check') {
            $this->db->order_by('created_at','DESC');
            $this->db->limit(1);
            $response_data = $this->db->get('ppob_transaction')->result();
        }else if($custid != '') {
            $this->db->order_by('created_at','DESC');
            $this->db->where('ppob_transaction.id_ppob_customer', $custid);
            $response_data = $this->db->get('ppob_transaction')->result();
        }else {
            $this->db->where('ppob_transaction.id_ppob_transaction', $id);
            $response_data = $this->db->get('ppob_transaction')->result();
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
        $data = array(
            'ppob_type'         => $this->post('ppob_type'),
            'ppob_account'      => $this->post('ppob_account'),
            'id_ppob_customer'  => $this->post('id_ppob_customer'),
            'qty'               => $this->post('qty'),
            'price'             => $this->post('price'),
            'status'            => $this->post('status'),
        );
        $insert = $this->db->insert('ppob_transaction', $data);
        $id_transaction = $this->db->insert_id();
        if ($insert) {
            $data_history = array(
                'id_ppob_customer'  => $this->post('id_ppob_customer'),
                'description'       => $this->post('ppob_type'),
                'amount'            => $this->post('price'),
                'status'            => 'PROCESS'
            );
            $this->db->insert('ppob_history', $data_history);
            
            // $this->db->where('id_ppob_customer',$this->post('id_ppob_customer'));
            // $check = $this->db->get('ppob_balance')->result();
        
            // $data_balance = array(
            //     'balance'   => $check[0]->balance - $this->post('price')
            // );
            // $this->db->where('id_ppob_customer', $this->post('id_ppob_customer'));
            // $this->db->update('ppob_balance', $data_balance);
            

            $code = 'PDS1';
            $this->response(array('status' => $code, 'id_trx' => $id_transaction, 'result' => $data, 200));
        } else {
            $code = 'PDS0';
            $this->response(array('status' => $code, 502));
        }
    }

    // PUT:User
    function index_put() {
        $code = '';
        $data = array(
                'status'  => $this->put('status')
                );
        $this->db->where('id_ppob_transaction', $this->put('id_ppob_transaction'));
        $update = $this->db->update('ppob_transaction', $data);
        if ($update) {
            $this->db->where('id_ppob_transaction', $this->put('id_ppob_transaction'));
            $check = $this->db->get('ppob_transaction')->result();
            
            $data_history = array(
                'id_ppob_customer'  => $check[0]->id_ppob_customer,
                'description'       => $check[0]->ppob_type,
                'amount'            => $check[0]->price,
                'status'            => $this->put('status')
            );
            $this->db->insert('ppob_history', $data_history);

            $this->db->where('id_ppob_customer',$check[0]->id_ppob_customer);
            $check_balance = $this->db->get('ppob_balance')->result();
        
            $data_balance = array(
                'balance'   => $check_balance[0]->balance - $check[0]->price
            );
            if($this->put('rc')!='' && $this->put('rc')=='00'){
                $this->db->where('id_ppob_customer', $check[0]->id_ppob_customer);
                $this->db->update('ppob_balance', $data_balance);
            }
            

            $code = 'UDS1';
            $this->response(array('status' => $code, 'result' => $data, 200));
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