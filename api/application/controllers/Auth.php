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
        
        $this->db->where('username', $this->post('username'));
        $this->db->where('password', md5($this->post('password')));
        $isValid = $this->db->get('users')->result();
        if (count($isValid) > 0) {
            $code = 'BAS1';
            $this->response(array('status' => $code,'token' => base64_encode($this->post('username').':'.md5($this->post('password').':'.date('His'))), 'result' => $isValid, 200));
        } else {
            $code = 'BAS0';
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