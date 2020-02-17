<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Price extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    // GET:Price
    function index_get() {
        $param = $this->get('param');
        $id = $this->get('id');
        if($param == ''){
            $this->response(array('status' => 'ERRRRR', 'message' => 'Invalid Parameter Price', 404));
        }else if($param == 'service'){
            $code = '';
            if ($id == '') {
                $this->db->select('
                *,
                service.service_name,
                service.description
                ');
                $this->db->from('price_rules');
                $this->db->join('service','service.id_service = price_rules.service', 'left');
                $this->db->order_by('price_rules.updated_at','DESC');
                $response_data = $this->db->get()->result();
            } else {
                $this->db->where('price_rules.id_price_rules', $id);
                $this->db->select('
                *,
                service.service_name,
                service.description
                ');
                $this->db->from('price_rules');
                $this->db->join('service','service.id_service = price_rules.service', 'left');
                $this->db->order_by('price_rules.updated_at','DESC');
                $response_data = $this->db->get()->result();
            }
            if(count($response_data)>1){
                $code = 'DSC1';
            }else{
                $code = 'DSC0';
            }
            $this->response(array('status' => $code, 'result' => $response_data, 200));
        }else if($param == 'location'){
            $code = '';
            if ($id == '') {
                $location_price = $this->db->get('location_price')->result();
                $response_data = array();
                foreach($location_price as $loc){
                    $locArr = array(
                        'id_location_price' => $loc->id_location_price,
                        'branch_office'     => $loc->branch_office,
                        'destination'       => $loc->destination,
                        'price'             => $loc->price
                    );
                    $this->db->where('city.id_city',$loc->destination);
                    $this->db->select('
                    city.name as city,
                    province.name as province
                    ');
                    $this->db->from('city');
                    $this->db->join('province','province.id_province = city.id_province', 'left');
                    $destination = $this->db->get()->result();

                    $this->db->where('id_branch_offices',$loc->branch_office);
                    $this->db->select('
                    village.name as village,
                    district.name as district,
                    city.name as city,
                    province.name as province
                    ');
                    $this->db->from('branch_offices');
                    $this->db->join('province','province.id_province = branch_offices.province', 'left');
                    $this->db->join('city','city.id_city = branch_offices.city', 'left');
                    $this->db->join('district','district.id_district = branch_offices.district', 'left');
                    $this->db->join('village','village.id_village = branch_offices.village', 'left');
                    $branch_office = $this->db->get()->result();
                    array_push($response_data,array(
                        'location_price'    => $locArr,
                        'dest_detail'       => $destination,
                        'bo_detail'         => $branch_office
                    ));                  
                }

            } else {
                $this->db->where('location_price.id_location_price', $id);
                $location_price = $this->db->get('location_price')->result();
                if($location_price){
                    $response_data = array();
                    foreach($location_price as $loc){
                        $locArr = array(
                            'id_location_price' => $loc->id_location_price,
                            'branch_office'     => $loc->branch_office,
                            'destination'       => $loc->destination,
                            'price'             => $loc->price
                        );
                        $this->db->where('city.id_city',$loc->destination);
                        $this->db->select('
                        city.name as city,
                        province.name as province
                        ');
                        $this->db->from('city');
                        $this->db->join('province','province.id_province = city.id_province', 'left');
                        $destination = $this->db->get()->result();

                        $this->db->where('id_branch_offices',$loc->branch_office);
                        $this->db->select('
                        village.name as village,
                        district.name as district,
                        city.name as city,
                        province.name as province
                        ');
                        $this->db->from('branch_offices');
                        $this->db->join('province','province.id_province = branch_offices.province', 'left');
                        $this->db->join('city','city.id_city = branch_offices.city', 'left');
                        $this->db->join('district','district.id_district = branch_offices.district', 'left');
                        $this->db->join('village','village.id_village = branch_offices.village', 'left');
                        $branch_office = $this->db->get()->result();
                        array_push($response_data,array(
                            'location_price'    => $locArr,
                            'dest_detail'       => $destination,
                            'bo_detail'         => $branch_office
                        ));                  
                    }
                }else{
                    $response_data = $location_price;
                }
            }
            if(count($response_data)>0){
                $code = 'DSC1';
            }else{
                $code = 'DSC0';
            }
            $this->response(array('status' => $code, 'result' => $response_data, 200));
        }else{
            $this->response(array('status' => 'ERRRRR', 'message' => 'Invalid Parameter Price', 404));
        }
    }

    // POST:Price
    function index_post() {
        $code = '';
        $param = $this->post('param');
        if($param == ''){
            $this->response(array('status' => 'ERRRRR', 'message' => 'Invalid Parameter Price', 404));
        }else if($param == 'location'){
            $data = array(
                'branch_office' => $this->post('branch_office'),
                'destination'   => $this->post('destination'),
                'price'         => $this->post('price')
            );
            $this->db->where('branch_office', $this->post('branch_office'));
            $this->db->where('destination', $this->post('destination'));
            $check = $this->db->get('location_price')->result();
            if(!$check){
                $insert = $this->db->insert('location_price', $data);
                if ($insert) {
                    $code = 'PDS1';
                    $this->response(array('status' => $code, 'result' => $data, 200));
                } else {
                    $code = 'PDS0';
                    $this->response(array('status' => $code, 502));
                }
            }else{
                $this->response(array('status' => 'ERRRRR', 'message' => 'Location Price Exist', 404));
            }
        }else if($param == 'service'){
            $data = array(
                    'service'   => $this->post('service'),
                    'insurance' => $this->post('insurance'),
                    'price'     => $this->post('price')
                );
            $this->db->where('service', $this->post('service'));
            $this->db->where('insurance', $this->post('insurance'));
            $check = $this->db->get('price_rules')->result();
            if(!$check){
                $insert = $this->db->insert('price_rules', $data);
                if ($insert) {
                    $code = 'PDS1';
                    $this->response(array('status' => $code, 'result' => $data, 200));
                } else {
                    $code = 'PDS0';
                    $this->response(array('status' => $code, 502));
                }
            }else{
                $this->response(array('status' => 'ERRRRR', 'message' => 'Service Price Exist', 404));
            }
        }else{
            $this->response(array('status' => 'ERRRRR', 'message' => 'Invalid Parameter Price', 404));
        }
        
    }

    // PUT:Price
    function index_put() {
        $this->response(array('status' => 'ERRRRR', 'message' => 'PUT IS NOT VALID IN THIS API', 404));
    }

    // DELETE:Price
    function index_delete() {
        $param = $this->delete('param');
        $id = $this->delete('id');
        $delete = FALSE;
        
        if($param == 'location'){
            $this->db->where('id_location_price', $id);
            $delete = $this->db->delete('location_price');
        }else if($param == 'service'){
            $this->db->where('id_price_rules', $id);
            $delete = $this->db->delete('price_rules');
        }else{
            $this->response(array('status' => 'ERRRRR', 'message' => 'INVALID PARAM', 404));
        }
        

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