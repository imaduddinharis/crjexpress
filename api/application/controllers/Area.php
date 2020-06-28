<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Area extends REST_Controller {
    var $BASE_URL = ''; 
    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
        $this->BASE_URL = 'https://crjexpress.id/';
    }

    // GET:Area || GET:Area/{id}
    function index_get() {
        $id = $this->get('id');
        $code = '';
        if ($id == '') {
            $this->db->select('office_area.*,
                                branch_offices.*,
                                province.name as province_name,
                                city.name as city_name,
                                district.name as district_name,
                                village.name as village_name
                                ');
            $this->db->from('office_area');
            $this->db->join('branch_offices', 'office_area.office_id = branch_offices.id_branch_offices', 'left');
            $this->db->join('province', 'province.id_province = branch_offices.province', 'left');
            $this->db->join('city', 'city.id_city = branch_offices.city', 'left');
            $this->db->join('district', 'district.id_district = branch_offices.district', 'left');
            $this->db->join('village', 'village.id_village = branch_offices.village', 'left');
            $boffice = $this->db->get()->result();
            $response_data = array();
            foreach($boffice as $bo){
                $boArr = array(
                    'id_office_area'    => $bo->id_office_area,
                    'area_name'         => $bo->area_name,
                    'area_description'  => $bo->area_description,
                    'office_id'         => $bo->office_id,
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
                
                $this->db->where('office_area_detail.id_office_area', $bo->id_office_area);
                $this->db->select('office_area_detail.*,
                                province.name as province_name,
                                city.name as city_name,
                                district.name as district_name,
                                village.name as village_name
                                ');
                $this->db->from('office_area_detail');
                $this->db->join('branch_offices', 'branch_offices.id_branch_offices = office_area_detail.branch_office', 'left');
                $this->db->join('province', 'province.id_province = branch_offices.province', 'left');
                $this->db->join('city', 'city.id_city = branch_offices.city', 'left');
                $this->db->join('district', 'district.id_district = branch_offices.district', 'left');
                $this->db->join('village', 'village.id_village = branch_offices.village', 'left');
                $branch_office = $this->db->get()->result();
                
                array_push($response_data,array(
                    'office_area'    => $boArr,
                    'manager_area'   => $pic,
                    'branch_office'   => $branch_office
                ));  
            }
            


        } else {
            $this->db->where('office_area.office_id', $id);
            $this->db->select('office_area.*,
                                branch_offices.*,
                                province.name as province_name,
                                city.name as city_name,
                                district.name as district_name,
                                village.name as village_name
                                ');
            $this->db->from('office_area');
            $this->db->join('branch_offices', 'office_area.office_id = branch_offices.id_branch_offices', 'left');
            $this->db->join('province', 'province.id_province = branch_offices.province', 'left');
            $this->db->join('city', 'city.id_city = branch_offices.city', 'left');
            $this->db->join('district', 'district.id_district = branch_offices.district', 'left');
            $this->db->join('village', 'village.id_village = branch_offices.village', 'left');
            $boffice = $this->db->get()->result();
            $response_data = array();
            foreach($boffice as $bo){
                $boArr = array(
                    'id_office_area'    => $bo->id_office_area,
                    'area_name'         => $bo->area_name,
                    'area_description'  => $bo->area_description,
                    'office_id'         => $bo->office_id,
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
                
                $this->db->where('office_area_detail.id_office_area', $bo->id_office_area);
                $this->db->select('office_area_detail.*,
                                province.name as province_name,
                                city.name as city_name,
                                district.name as district_name,
                                village.name as village_name
                                ');
                $this->db->from('office_area_detail');
                $this->db->join('branch_offices', 'branch_offices.id_branch_offices = office_area_detail.branch_office', 'left');
                $this->db->join('province', 'province.id_province = branch_offices.province', 'left');
                $this->db->join('city', 'city.id_city = branch_offices.city', 'left');
                $this->db->join('district', 'district.id_district = branch_offices.district', 'left');
                $this->db->join('village', 'village.id_village = branch_offices.village', 'left');
                $branch_office = $this->db->get()->result();
                
                array_push($response_data,array(
                    'office_area'    => $boArr,
                    'manager_area'   => $pic,
                    'branch_office'   => $branch_office
                ));  
            }
            
        }
        if(count($response_data)>0){
            $code = 'DSC1';
        }else{
            $code = 'DSC0';
        }
        $this->response(array('status' => $code, 'result' => $response_data, 200));
    }

    // POST:Area
    function index_post() {
        $code = '';
        /* type1 = create new area */
        /* type2 = add branch office to area */
        if($this->post('type') == 1){
            $data = array(
                    'area_name'             => $this->post('area_name'),
                    'area_description'      => $this->post('area_description'),
                    'office_id'             => $this->post('office_id')
                );
            $insert = $this->db->insert('office_area', $data);
            if ($insert) {
                $code = 'PDS1';
                $this->response(array('status' => $code, 'result' => $data, 200));
            } else {
                $code = 'PDS0';
                $this->response(array('status' => $code, 502));
            }
        }else if($this->post('type') == 2){
            $data = array(
                    'id_office_area'    => $this->post('id_office_area'),
                    'branch_office'     => $this->post('branch_office')
                );
            $insert = $this->db->insert('office_area_detail', $data);
            if ($insert) {
                $code = 'PDS1';
                $this->response(array('status' => $code, 'result' => $data, 200));
            } else {
                $code = 'PDS0';
                $this->response(array('status' => $code, 502));
            }
        }else{
            $code = 'PDS0';
            $this->response(array('status' => $code,'message' => 'CHECK YOUR INPUT TYPE', 502));
        }
        
    }

    // PUT:Area
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

    // DELETE:Area
    function index_delete() {
        $id = $this->delete('id');
        
        $this->db->where('id_office_area', $id);
        $delete = $this->db->delete('office_area');
        
        $this->db->where('id_office_area', $id);
        $deletes = $this->db->delete('office_area_detail');
        
        
        if ($delete && $deletes && $id != NULL) {
            $code = 'DDS1';
            $this->response(array('status' => $code), 201);
        } else {
            $code = 'DDS0';
            $this->response(array('status' => $code, 502));
        }
    }

}
?>