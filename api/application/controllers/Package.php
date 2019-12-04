<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Package extends REST_Controller {
    var $BASE_URL = ''; 
    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
        $this->BASE_URL = 'https://crjexpress.id/';
    }

    // GET:Package || GET:Package/{id}
    function index_get() {
        $id = $this->get('id_packages');
        $invoice = $this->get('invoice');
        $resi = $this->get('resi');
        
        $code = '';
        if ($id == '' && $invoice == '' && $resi == '') {
            $this->db->select('packages.id_packages,
                                packages.package_type,
                                packages.packaging_type,
                                packages.package_notes,
                                packages.weight,
                                packages.insurance,
                                transactions.resi,
                                transactions.invoice,
                                transactions.sender,
                                transactions.recipient,
                                transactions.price,
                                transactions.status,
                                transactions.sender_phone,
                                transactions.sender_mail,
                                transactions.recipient_phone,
                                transactions.recipient_mail,
                                transactions.qrcode,
                                service.service_name,
                                service.description as service_description,
                                locations.branch_office,
                                locations.dest_province,
                                province.name as province_name,
                                locations.dest_city,
                                city.name as city_name,
                                locations.dest_district,
                                district.name as district_name,
                                locations.dest_village,
                                village.name as village_name,
                                locations.detail
                                ');
            $this->db->from('packages');
            $this->db->join('transactions', 'transactions.id_packages = packages.id_packages', 'left');
            $this->db->join('locations', 'locations.id_packages = packages.id_packages', 'left');
            $this->db->join('province', 'province.id_province = locations.dest_province', 'left');
            $this->db->join('city', 'city.id_city = locations.dest_city', 'left');
            $this->db->join('district', 'district.id_district = locations.dest_district', 'left');
            $this->db->join('village', 'village.id_village = locations.dest_village', 'left');
            $this->db->join('service', 'service.id_service = transactions.service', 'left');
            $this->db->order_by('packages.created_at','DESC');
            $response_data = $this->db->get()->result();
            // $response_data = $this->db->get('roles')->result();
        } else if($id != '') {
            $this->db->where('packages.id_packages', $id);
            $this->db->select('packages.id_packages,
                                packages.package_type,
                                packages.packaging_type,
                                packages.package_notes,
                                packages.weight,
                                packages.insurance,
                                transactions.resi,
                                transactions.invoice,
                                transactions.sender,
                                transactions.recipient,
                                transactions.price,
                                transactions.status,
                                transactions.sender_phone,
                                transactions.sender_mail,
                                transactions.recipient_phone,
                                transactions.recipient_mail,
                                transactions.qrcode,
                                service.service_name,
                                service.description as service_description,
                                locations.branch_office,
                                locations.dest_province,
                                province.name as province_name,
                                locations.dest_city,
                                city.name as city_name,
                                locations.dest_district,
                                district.name as district_name,
                                locations.dest_village,
                                village.name as village_name,
                                locations.detail
                                ');
            $this->db->from('packages');
            $this->db->join('transactions', 'transactions.id_packages = packages.id_packages', 'left');
            $this->db->join('locations', 'locations.id_packages = packages.id_packages', 'left');
            $this->db->join('province', 'province.id_province = locations.dest_province', 'left');
            $this->db->join('city', 'city.id_city = locations.dest_city', 'left');
            $this->db->join('district', 'district.id_district = locations.dest_district', 'left');
            $this->db->join('village', 'village.id_village = locations.dest_village', 'left');
            $this->db->join('service', 'service.id_service = transactions.service', 'left');
            $response_data = $this->db->get()->result();
        }else if($invoice != '') {
            $this->db->where('transactions.invoice', $invoice);
            $this->db->select('packages.id_packages,
                                packages.package_type,
                                packages.packaging_type,
                                packages.package_notes,
                                packages.weight,
                                packages.insurance,
                                transactions.resi,
                                transactions.invoice,
                                transactions.sender,
                                transactions.recipient,
                                transactions.price,
                                transactions.status,
                                transactions.sender_phone,
                                transactions.sender_mail,
                                transactions.recipient_phone,
                                transactions.recipient_mail,
                                transactions.qrcode,
                                service.service_name,
                                service.description as service_description,
                                locations.branch_office,
                                locations.dest_province,
                                province.name as province_name,
                                locations.dest_city,
                                city.name as city_name,
                                locations.dest_district,
                                district.name as district_name,
                                locations.dest_village,
                                village.name as village_name,
                                locations.detail
                                ');
            $this->db->from('packages');
            $this->db->join('transactions', 'transactions.id_packages = packages.id_packages', 'left');
            $this->db->join('locations', 'locations.id_packages = packages.id_packages', 'left');
            $this->db->join('province', 'province.id_province = locations.dest_province', 'left');
            $this->db->join('city', 'city.id_city = locations.dest_city', 'left');
            $this->db->join('district', 'district.id_district = locations.dest_district', 'left');
            $this->db->join('village', 'village.id_village = locations.dest_village', 'left');
            $this->db->join('service', 'service.id_service = transactions.service', 'left');
            $response_data = $this->db->get()->result();
        }else if($resi != '') {
            $this->db->where('transactions.resi', $resi);
            $this->db->select('packages.id_packages,
                                packages.package_type,
                                packages.packaging_type,
                                packages.package_notes,
                                packages.weight,
                                packages.insurance,
                                transactions.resi,
                                transactions.invoice,
                                transactions.sender,
                                transactions.recipient,
                                transactions.price,
                                transactions.status,
                                transactions.sender_phone,
                                transactions.sender_mail,
                                transactions.recipient_phone,
                                transactions.recipient_mail,
                                transactions.qrcode,
                                service.service_name,
                                service.description as service_description,
                                locations.branch_office,
                                locations.dest_province,
                                province.name as province_name,
                                locations.dest_city,
                                city.name as city_name,
                                locations.dest_district,
                                district.name as district_name,
                                locations.dest_village,
                                village.name as village_name,
                                locations.detail
                                ');
            $this->db->from('packages');
            $this->db->join('transactions', 'transactions.id_packages = packages.id_packages', 'left');
            $this->db->join('locations', 'locations.id_packages = packages.id_packages', 'left');
            $this->db->join('province', 'province.id_province = locations.dest_province', 'left');
            $this->db->join('city', 'city.id_city = locations.dest_city', 'left');
            $this->db->join('district', 'district.id_district = locations.dest_district', 'left');
            $this->db->join('village', 'village.id_village = locations.dest_village', 'left');
            $this->db->join('service', 'service.id_service = transactions.service', 'left');
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
        // $this->response(array($this->post()));
        // return false;

        $code = '';

        $post = $this->post();

        $data['package'] = array(
            'package_type'      => $post['package_type'],
            'packaging_type'    => $post['packaging_type'],
            'package_notes'     => $post['package_notes'],
            'weight'            => $post['weight'],
            'insurance'         => $post['insurance']
        );
        // $this->response($data['package']);
        // return false;
        $post_package = $this->db->insert('packages', $data['package']);
        $id_package = $this->db->insert_id();


        $this->load->library('ciqrcode'); //pemanggilan library QR CODE
 
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './assets/'; //string, the default is application/cache/
        $config['errorlog']     = './assets/'; //string, the default is application/logs/
        $config['imagedir']     = './assets/images/qrcode/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(157,11,11); // array, default is array(255,255,255)
        $config['white']        = array(70,130,180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);
 
        $image_name=md5('resi-id:'.$id_package).'.png'; //buat name dari qr code sesuai dengan nim
 
        $params['data'] = $this->BASE_URL.'tracking-package?rn='.md5('resi-id:'.$id_package); //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params);


        $this->db->where('branch_office',$post['branch_office']);
        $this->db->where('destination',$post['dest_city']);
        $location_price = $this->db->get('location_price')->result();

        $this->db->where('service',$post['service']);
        $this->db->where('insurance',$post['insurance']);
        $service_price = $this->db->get('price_rules')->result();

        $price = ($location_price[0]->price + $service_price[0]->price) * $post['weight'];

        $data['customer'] = array(
            'resi'              => md5('resi-id:'.$id_package), /** generate */
            'invoice'           => md5('invoice-id:'.$id_package), /** generate */
            'id_packages'       => $id_package,
            'sender'            => $post['sender'],
            'recipient'         => $post['recipient'],
            'service'           => $post['service'],
            'price'             => $price, /** generate */
            'status'            => '00',
            'sender_phone'      => $post['sender_phone'],
            'recipient_phone'   => $post['recipient_phone'],
            'sender_mail'       => $post['sender_mail'],
            'recipient_mail'    => $post['recipient_mail'],
            'qrcode'            => $this->BASE_URL.'assets/images/qrcode/'.$image_name
        );

        $post_customer = $this->db->insert('transactions', $data['customer']);

        $data['location'] = array(
            'id_packages'   => $id_package,
            'branch_office' => $post['branch_office'],
            'dest_province' => $post['dest_province'],
            'dest_city'     => $post['dest_city'],
            'dest_district' => $post['dest_district'],
            'dest_village'  => $post['dest_village'],
            'detail'        => $post['detail']
        );

        $post_location = $this->db->insert('locations', $data['location']);
        
        if ($post_package && $post_customer && $post_location) {
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