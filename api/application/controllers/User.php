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
            $this->db->where_not_in('users.role','superuser');
            $this->db->select('users.username,
                                users.email,
                                users.role,
                                users.id_users,
                                employees.id_employees,
                                employees_detail.fullname,
                                employees_detail.address,
                                employees_detail.phone_number,
                                employees.position,
                                employees_detail.photo,
                                employees.branch_office,
                                village.name as office_village,
                                district.name as office_district,
                                city.name as office_city,
                                province.name as office_province,
                                users.created_at,
                                users.updated_at
                                ');
            $this->db->from('users');
            $this->db->join('employees', 'employees.username = users.username', 'left');
            $this->db->join('employees_detail', 'employees_detail.id_employees = employees.id_employees', 'left');
            $this->db->join('branch_offices', 'branch_offices.id_branch_offices = employees.branch_office', 'left');
            $this->db->join('province', 'province.id_province = branch_offices.province', 'left');
            $this->db->join('city', 'city.id_city = branch_offices.city', 'left');
            $this->db->join('district', 'district.id_district = branch_offices.district', 'left');
            $this->db->join('village', 'village.id_village = branch_offices.village', 'left');
            $this->db->order_by('users.created_at','DESC');
            $response_data = $this->db->get()->result();
        } else {
            $this->db->where('users.id_users', $id);
            $this->db->where_not_in('users.role','superuser');
            $this->db->select('users.username,
                                users.email,
                                users.role,
                                users.id_users,
                                employees.id_employees,
                                employees_detail.fullname,
                                employees_detail.address,
                                employees_detail.phone_number,
                                employees.position,
                                employees_detail.photo,
                                employees.branch_office,
                                village.name as office_village,
                                district.name as office_district,
                                city.name as office_city,
                                province.name as office_province,
                                users.created_at,
                                users.updated_at
                                ');
            $this->db->from('users');
            $this->db->join('employees', 'employees.username = users.username', 'left');
            $this->db->join('employees_detail', 'employees_detail.id_employees = employees.id_employees', 'left');
            $this->db->join('branch_offices', 'branch_offices.id_branch_offices = employees.branch_office', 'left');
            $this->db->join('province', 'province.id_province = branch_offices.province', 'left');
            $this->db->join('city', 'city.id_city = branch_offices.city', 'left');
            $this->db->join('district', 'district.id_district = branch_offices.district', 'left');
            $this->db->join('village', 'village.id_village = branch_offices.village', 'left');
            $this->db->order_by('users.created_at','DESC');
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
        $role = array('agent','manager','courier','cs');
        if(in_array($this->post('role'),$role)){
            $data['account'] = array(
                        'username'  => $this->post('username'),
                        'password'  => md5($this->post('password')),
                        'email'     => $this->post('email'),
                        'role'      => $this->post('role')
                    );
            $insert_account = $this->db->insert('users', $data['account']);
            $data['employees'] = array(
                        'username'      => $this->post('username'),
                        'branch_office' => $this->post('branch_office'),
                        'position'      => $this->post('role')
                    );
            $insert_employees = $this->db->insert('employees', $data['employees']);
            $id_employees = $this->db->insert_id();
            $data['employees_detail'] = array(
                        'id_employees'  => $id_employees,
                        'fullname'      => $this->post('fullname'),
                        'address'       => $this->post('address'),
                        'phone_number'  => $this->post('phone_number')
                    );
            $insert_employees_detail = $this->db->insert('employees_detail', $data['employees_detail']);
            if ($insert_account && $insert_employees && $insert_employees_detail) {
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
        $role = array('agent','manager','courier');
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