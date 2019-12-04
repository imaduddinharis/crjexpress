<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Branch_office extends REST_Controller {
    var $BASE_URL = ''; 
    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
        $this->BASE_URL = 'https://crjexpress.id/';
    }

    // GET:Package || GET:Package/{id}
    function index_get() {
        $id = $this->get('id');
        $code = '';
        if ($id == '') {
            $this->db->select('branch_offices.*,
                                province.name as province_name,
                                city.name as city_name,
                                district.name as district_name,
                                village.name as village_name
                                ');
            $this->db->from('branch_offices');
            $this->db->join('province', 'province.id_province = branch_offices.province', 'left');
            $this->db->join('city', 'city.id_city = branch_offices.city', 'left');
            $this->db->join('district', 'district.id_district = branch_offices.district', 'left');
            $this->db->join('village', 'village.id_village = branch_offices.village', 'left');
            $boffice = $this->db->get()->result();
            $response_data = array();
            foreach($boffice as $bo){
                $boArr = array(
                    'id_branch_offices' => $bo->id_branch_offices,
                    'province'          => $bo->province,
                    'province_name'     => $bo->province_name,
                    'city'              => $bo->city,
                    'city_name'         => $bo->city_name,
                    'district'          => $bo->district,
                    'district_name'     => $bo->district_name,
                    'village'           => $bo->village,
                    'village_name'      => $bo->village_name,
                    
                );
                $this->db->where('employees.branch_office', $bo->id_branch_offices);
                $this->db->where('employees.position', 'manager');
                $this->db->select('employees_detail.fullname as pic_name,
                                employees_detail.address as pic_address,
                                employees_detail.phone_number as pic_phone,
                                employees_detail.photo as pic_photo
                                ');
                $this->db->from('employees_detail');
                $this->db->join('employees', 'employees.id_employees = employees_detail.id_employees', 'left');
                $pic = $this->db->get()->result();
                array_push($response_data,array(
                    'branch_office'    => $boArr,
                    'pic'       => $pic
                ));  
            }
            


        } else {
            $this->db->where('branch_offices.id_branch_offices', $id);
            $this->db->select('branch_offices.*,
                                province.name as province_name,
                                city.name as city_name,
                                district.name as district_name,
                                village.name as village_name,
                                employees_detail.fullname as pic_name,
                                employees_detail.address as pic_address,
                                employees_detail.phone_number as pic_phone,
                                employees_detail.photo as pic_photo
                                ');
            $this->db->from('branch_offices');
            $this->db->join('province', 'province.id_province = branch_offices.province', 'left');
            $this->db->join('city', 'city.id_city = branch_offices.city', 'left');
            $this->db->join('district', 'district.id_district = branch_offices.district', 'left');
            $this->db->join('village', 'village.id_village = branch_offices.village', 'left');
            $this->db->join('employees', 'employees.branch_office = branch_offices.id_branch_offices', 'left');
            $this->db->where('employees.position', 'manager');
            $this->db->join('employees_detail', 'employees_detail.id_employees = employees.id_employees', 'left');
            $response_data = $this->db->get()->result();
        }
        if(count($response_data)>0){
            $code = 'DSC1';
        }else{
            $code = 'DSC0';
        }
        $this->response(array('status' => $code, 'result' => $response_data, 200));
    }

    // POST:Package
    function index_post() {
        $code = '';
        
        $data = array(
                    'province'  => $this->post('province'),
                    'city'      => $this->post('city'),
                    'district'  => $this->post('district'),
                    'village'   => $this->post('village')
                );
        $insert = $this->db->insert('branch_offices', $data);
        if ($insert) {
            $code = 'PDS1';
            $this->response(array('status' => $code, 'result' => $data, 200));
        } else {
            $code = 'PDS0';
            $this->response(array('status' => $code, 502));
        }
    }

    // PUT:Package
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

    // DELETE:Package
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