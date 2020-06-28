<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Auth extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    // GET:Auth
    function index_get() {
        $this->response(array('status' => 'ERRRRR', 'message' => 'GET IS NOT VALID IN THIS API', 404));
    }

    // POST:Auth
    function index_post() {
        $code = '';
        
        $headers = $this->input->get_request_header('APIKey');
        // $this->response(array('status' => $code, 'message' => $this->input->get_request_header(),502));
        $this->db->where('api_key', $headers);
        $validation = $this->db->get('platform')->result();
        if(count($validation) > 0) {     
            $this->db->where('username', $this->post('username'));
            $this->db->where('password', md5($this->post('password')));
            $isValid = $this->db->get('users')->result();
            if (count($isValid) > 0) {
                $code = 'BAS1';
                $this->db->where('username', $this->post('username'));
                $this->db->select('employees.id_employees,
                                    employees.position,
                                    employees.branch_office,
                                    employees_detail.fullname,
                                    employees_detail.address,
                                    employees_detail.phone_number,
                                    employees_detail.photo
                                ');
            $this->db->from('employees');
            $this->db->join('employees_detail', 'employees_detail.id_employees = employees.id_employees', 'left');
            $user_info = $this->db->get()->result();
            $this->response(array('status' => $code,'token' => base64_encode($this->post('username').':'.md5($this->post('password').':'.date('His'))), 'result' => array('account'=>$isValid,'detail'=>$user_info), 200));
            } else {
                $code = 'BAS0';
                $this->response(array('status' => $code, 'message' => 'Username or Password incorrect',502));
            }
        }else{
            $code = 'BAS0';
            $this->response(array('status' => $code, 'message' => 'Authentication Failed',502));
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