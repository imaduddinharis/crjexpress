<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class History extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    // GET:Auth
    function index_get() {
        $id = $this->get('id_packages');
        $code = '';
        if ($id == '') {
            $response_data = $this->db->get('current_status')->result();
        } else {
            $this->db->where('id_packages', $id);
            $response_data = $this->db->get('current_status')->result();
        }
        if(count($response_data)>1){
            $code = 'DSC1';
        }else{
            $code = 'DSC0';
        }
        $this->response(array('status' => $code, 'result' => $response_data, 200));
    }

    // POST:Auth
    function index_post() {
        $code = '';
        
        if($this->post('action') == 'pickup'){
            $this->db->where('username', $this->post('username'));
            $check_courier = $this->db->get('employees')->result();
            
            $this->db->where('id_branch_offices',$check_courier[0]->branch_office);
            $this->db->from('branch_offices');
            $this->db->select('branch_offices.*,city.name as city_name');
            $this->db->join('city', 'city.id_city = branch_offices.city', 'left');
            $branch_office = $this->db->get()->result();
            $data = array(
                'id_packages'   => $this->post('id_packages'),
                'status'        => 'Pickup',
                'pic'           => $this->post('username'),
                'notes'         => 'Barang telah di pickup courier '.$branch_office[0]->city_name
            );
            $data_transaction = array(
                'status' => '01'
            );
            $this->db->where('id_packages', $this->post('id_packages'));
            $this->db->update('transactions', $data_transaction);
            // $this->response(array('status' => $code, 'result' => $data, 200));
            // return false;
        }else if($this->post('action') == 'drop'){
            $this->db->where('username', $this->post('username'));
            $check_courier = $this->db->get('employees')->result();
            
            $this->db->where('id_branch_offices',$check_courier[0]->branch_office);
            $this->db->from('branch_offices');
            $this->db->select('branch_offices.*,city.name as city_name');
            $this->db->join('city', 'city.id_city = branch_offices.city', 'left');
            $branch_office = $this->db->get()->result();
            $data = array(
                'id_packages'   => $this->post('id_packages'),
                'status'        => 'Drop',
                'pic'           => $this->post('username'),
                'notes'         => 'Barang telah di terima agent '.$branch_office[0]->city_name
            );
            $data_transaction = array(
                'status' => '02'
            );
            $this->db->where('id_packages', $this->post('id_packages'));
            $this->db->update('transactions', $data_transaction);
            // $this->response(array('status' => $code, 'result' => $data, 200));
            // return false;
        }else if($this->post('action') == 'received'){
            $this->db->where('username', $this->post('username'));
            $check_courier = $this->db->get('employees')->result();
            
            $this->db->where('id_branch_offices',$check_courier[0]->branch_office);
            $this->db->from('branch_offices');
            $this->db->select('branch_offices.*,city.name as city_name');
            $this->db->join('city', 'city.id_city = branch_offices.city', 'left');
            $branch_office = $this->db->get()->result();
            $data = array(
                'id_packages'   => $this->post('id_packages'),
                'status'        => 'Received',
                'pic'           => $this->post('username'),
                'notes'         => 'Barang telah di terima oleh '.$this->post('recipient')
            );
            $data_transaction = array(
                'status' => '03'
            );
            $this->db->where('id_packages', $this->post('id_packages'));
            $this->db->update('transactions', $data_transaction);
            // $this->response(array('status' => $code, 'result' => $data, 200));
            // return false;
        }else{
            $data = array(
                'id_packages'   => $this->post('id_packages'),
                'status'        => $this->post('status'),
                'pic'           => $this->post('pic'),
                'notes'         => $this->post('notes')
            );
        }
        $insert = $this->db->insert('current_status', $data);
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