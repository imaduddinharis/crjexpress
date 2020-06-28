<?php

require_once(APPPATH .'controllers/Res.php');

Class Product extends CI_Controller{

    var $API ="";
    var $asset ="";

    function __construct() {
        parent::__construct();
        
        /* API Host */
        $res = new Res();
        $this->API = $res->getApi();

        /* Library */
        $this->load->library('session');
        $this->load->library('curl');
        
        /* Helper */
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('path');

        /* Asset */
        $this->asset = base_url().'assets/customer/';
        
        /* Authentication */
        // if($this->session->userdata('IS_LOGIN') == FALSE){
        //     redirect(base_url());
        // }
    }

    // menampilkan data kontak
    function index(){
        $data['title'] = 'Features | CRJExpress';
        $data['asset'] = $this->asset;
        if($this->session->userdata('IS_LOGIN_PPOB')){
            $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
        }
        
        // $data['header']=$this->load->view('templates/header',$data, true);
        $data['content']=$this->load->view('customer/product/index',$data, true);
        // $data['footer']=$this->load->view('templates/footer',$data, true);
		
        $this->load->view('customer/template/index',$data);
    }
    // menampilkan data kontak
    function prepaid_mobile(){
        $data['title'] = 'Pulsa Pra Bayar | CRJExpress';
        $data['asset'] = $this->asset;
        if($this->session->userdata('IS_LOGIN_PPOB')){
            $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
        }
        
        // $data['header']=$this->load->view('templates/header',$data, true);
        $data['content']=$this->load->view('customer/product/prepaid_mobile',$data, true);
        // $data['footer']=$this->load->view('templates/footer',$data, true);
		
        $this->load->view('customer/template/index',$data);
    }
    function prepaid_el(){
        $data['title'] = 'Token Listrik | CRJExpress';
        $data['asset'] = $this->asset;
        if($this->session->userdata('IS_LOGIN_PPOB')){
            $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
        }
        $req = json_encode(array(
            'commands'  => 'pricelist',
            'username'  => '081210113977',
            'sign'      => md5('0812101139773345e28cae81da00334pl'),
            'status'    => 'all'
        ));

        $data['option'] = json_decode($this->curl->simple_post('https://api.mobilepulsa.net/v1/legacy/index/pln', $req, array(CURLOPT_BUFFERSIZE => 10)))->data;
        
        if(isset($_POST['check'])){
            $data['page'] = 2;
            $req = json_encode(array(
                'commands'  => 'inquiry_pln',
                'username'  => '081210113977',
                'sign'      => md5('0812101139773345e28cae81da00334'.$this->input->post('phone')),
                'hp'        => $this->input->post('phone')
            ));
            $this->curl->http_header('Content-Type','application/json');
            $data['custinfo'] = json_decode($this->curl->simple_post('https://api.mobilepulsa.net/v1/legacy/index', $req, array(CURLOPT_BUFFERSIZE => 10)))->data;
            $data['phone'] = $this->input->post('phone');
            $data['nominal'] = $this->input->post('nominal');
        }else{
            $data['page'] = 1;
        }
        
        // $data['header']=$this->load->view('templates/header',$data, true);
        $data['content']=$this->load->view('customer/product/prepaid_el',$data, true);
        // $data['footer']=$this->load->view('templates/footer',$data, true);
		
        $this->load->view('customer/template/index',$data);
    }
    function voucher_games(){
        $data['title'] = 'Voucher Games | CRJExpress';
        $data['asset'] = $this->asset;
        if($this->session->userdata('IS_LOGIN_PPOB')){
            $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
        }
        $data['isSelected'] = 0;

        if(isset($_POST['select'])){
            $data['isSelected'] = 1;
            $game_code = explode('|',$this->input->post('select'));
            // $request = '{
            //     "commands"   : "check-game-id",
            //     "username"   : "081210113977",
            //     "game_code"  : "103",
            //     "hp"         : "59901495|2104",
            //     "sign"       : "6502050e2da9f46d2bbd24abfa660429"
            // }';
            $check = json_encode(array(
                'commands'  => 'check-game-id',
                'username'  => '081210113977',
                'game_code' => $game_code[1],
                'hp'        => $this->input->post('phone'),
                'sign'      => md5('0812101139773345e28cae81da00334'.$game_code[1])
            ));
            $this->curl->http_header('Content-Type','application/json');
            $data['gameid'] = json_decode($this->curl->simple_post('https://api.mobilepulsa.net/v1/player-detail', $check, array(CURLOPT_BUFFERSIZE => 10)))->data;
            $phone = str_replace("|","",$this->input->post('phone'));
            $data['phone'] = $phone;
            $req = json_encode(array(
                'commands'  => 'pricelist',
                'username'  => '081210113977',
                'sign'      => md5('0812101139773345e28cae81da00334pl'),
                'status'    => 'all'
            ));
    
            $data['option'] = json_decode($this->curl->simple_post('https://api.mobilepulsa.net/v1/legacy/index/game/'.$game_code[0], $req, array(CURLOPT_BUFFERSIZE => 10)))->data;
            // var_dump($data['gameid']);
            // return false;
        }
        $list_game = array(
            array('name' => 'Mobile Legend','code' => 'mobile_legend','game_code' => '103'),
            array('name' => 'Ragnarok M','code' => 'ragnarok_m','game_code' => '127'),
            array('name' => 'Bleach Mobile 3D','code' => 'bleach_mobile_3d','game_code' => '140'),
            array('name' => 'Speed Drifters','code' => 'speed_drifters','game_code' => '136'),
            array('name' => 'AOV','code' => 'arena_of_valor','game_code' => '139'),
            array('name' => 'Free Fire','code' => 'free_fire','game_code' => '135'),
            array('name' => 'Era of Celestials','code' => 'era_of_celestials','game_code' => '141'),
            array('name' => 'Dragon Nest M Sea','code' => 'dragon_nest_m_-_sea','game_code' => '142')
        );
        $data['games'] = $list_game;
        
        // $data['header']=$this->load->view('templates/header',$data, true);
        $data['content']=$this->load->view('customer/product/voucher_games',$data, true);
        // $data['footer']=$this->load->view('templates/footer',$data, true);
		
        $this->load->view('customer/template/index',$data);
    }
    function emoney(){
        $data['title'] = 'E-Money | CRJExpress';
        $data['asset'] = $this->asset;
        if($this->session->userdata('IS_LOGIN_PPOB')){
            $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
        }
        $data['isSelected'] = 0;

        if(isset($_POST['select'])){
            $data['isSelected'] = 1;
            $req = json_encode(array(
                'commands'  => 'pricelist',
                'username'  => '081210113977',
                'sign'      => md5('0812101139773345e28cae81da00334pl'),
                'status'    => 'all'
            ));
    
            $data['option'] = json_decode($this->curl->simple_post('https://api.mobilepulsa.net/v1/legacy/index/etoll/'.$this->input->post('select'), $req, array(CURLOPT_BUFFERSIZE => 10)))->data;
            // var_dump($data['option']);
            // return false;
        }
        $list_emoney = array(
            array('name' => 'OVO','code' => 'ovo'),
            array('name' => 'LinkAja','code' => 'linkaja'),
            array('name' => 'Tapcash BNI','code' => 'tapcash_bni'),
            array('name' => 'Dana','code' => 'dana'),
            array('name' => 'Indomaret Card','code' => 'indomaret_card_e-money'),
            array('name' => 'Mandiri E Toll','code' => 'mandiri_e-toll'),
            array('name' => 'Gopay','code' => 'gopay_e-money'),
            array('name' => 'Shopee Pay','code' => 'shopee_pay')
        );
        $data['emoney'] = $list_emoney;
        
        
        // $data['header']=$this->load->view('templates/header',$data, true);
        $data['content']=$this->load->view('customer/product/emoney',$data, true);
        // $data['footer']=$this->load->view('templates/footer',$data, true);
		
        $this->load->view('customer/template/index',$data);
    }

    function prepaid_el_topup(){
        if(!$this->session->userdata('IS_LOGIN_PPOB')){
            redirect(base_url().'login');
        }else{
            $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
        }

        if(isset($_POST['buy'])){
            $check_cust = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
            $balance = $check_cust->balance;
            $data['response'] = '<h3>ERROR, Jangan melakukan refresh dan mencoba kembali, Silahkan segera menghubungi customer service</h3>';
            $nominal = preg_replace('/[^0-9]/', '', $this->input->post('nominal'));
            
            if($balance > $nominal){
                $data_trx = array(
                    'ppob_type'         => 'topup token listrik',
                    'ppob_account'      => $this->input->post('phone'),
                    'id_ppob_customer'  => $this->session->userdata('SESS_DATA')['cust_id'],
                    'qty'               => $nominal,
                    'price'             => $nominal+1000,
                    'status'            => 'PROCESS'
                );
                $insert =  json_decode($this->curl->simple_post($this->API.'ppob_transaction', $data_trx, array(CURLOPT_BUFFERSIZE => 10)));
                $data_mp = array(
                    'commands'  => 'topup',
                    'username'  => '081210113977',
                    'ref_id'    => $insert->id_trx,
                    'hp'        => $this->input->post('phone'),
                    'pulsa_code'=> $this->input->post('nominal'),
                    'sign'      => md5('0812101139773345e28cae81da00334'.$insert->id_trx)
                );
                $post_mp = json_decode($this->curl->simple_post('https://api.mobilepulsa.net/v1/legacy/index', json_encode($data_mp), array(CURLOPT_BUFFERSIZE => 10)));
                // $post_mp = json_decode($this->curl->simple_post('https://testprepaid.mobilepulsa.net/v1/legacy/index', json_encode($data_mp), array(CURLOPT_BUFFERSIZE => 10)));
                if($post_mp->data->rc == '39'){
                    $data['response'] = '<h3>Top up Listrik sedang di proses, silahkan tunggu</h3><center><img src="'.$this->asset.'img/loading.gif" class="img-fluid" style="width:200px" id="loading1"></center>';
                    $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
                }else if($post_mp->data->rc == '14'){
                    $data_transaction = array(
                        'id_ppob_transaction'   => $insert->id_trx,
                        'status'                => 'Incorrect Destination Number'
                    );
                    // file_put_contents('a.json', $jsonData);
                    
                    $update =  $this->curl->simple_put($this->API.'ppob_transaction', $data_transaction, array(CURLOPT_BUFFERSIZE => 10));
                    
                    $data['response'] = '<h3>Incorrect Destination Number</h3>';
                    $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
                }else if($post_mp->data->rc == '16'){
                    $data_transaction = array(
                        'id_ppob_transaction'   => $insert->id_trx,
                        'status'                => 'Number Not Match With Operator'
                    );
                    // file_put_contents('a.json', $jsonData);
                    
                    $update =  $this->curl->simple_put($this->API.'ppob_transaction', $data_transaction, array(CURLOPT_BUFFERSIZE => 10));
                    
                    $data['response'] = '<h3>Number Not Match With Operator</h3>';
                    $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
                }else if($post_mp->data->rc == '106'){
                    $data_transaction = array(
                        'id_ppob_transaction'   => $insert->id_trx,
                        'status'                => 'PRODUCT IS TEMPORARILY OUT OF SERVICE'
                    );
                    // file_put_contents('a.json', $jsonData);
                    
                    $update =  $this->curl->simple_put($this->API.'ppob_transaction', $data_transaction, array(CURLOPT_BUFFERSIZE => 10));
                    
                    $data['response'] = '<h3>PRODUCT IS TEMPORARILY OUT OF SERVICE</h3>';
                    $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
                }
            }else{
                $data['response'] = '<h3>Saldo tidak mencukupi, silahkan isi saldo terlebih dahulu</h3>';
            }
        }else{
            redirect(base_url().'feature-crj-express/listrik-pra-bayar');
        }

        $data['title'] = 'Token Listrik | CRJExpress';
        $data['asset'] = $this->asset;
        // $data['response'] = 'Top up Pulsa sedang di proses, silahkan tunggu';
        // $data['header']=$this->load->view('templates/header',$data, true);
        $data['content']=$this->load->view('customer/product/top_up_pulsa',$data, true);
        // $data['footer']=$this->load->view('templates/footer',$data, true);
		
        $this->load->view('customer/template/index',$data);
    }
    function voucher_games_topup(){
        if(!$this->session->userdata('IS_LOGIN_PPOB')){
            redirect(base_url().'login');
        }else{
            $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
        }
        $nominal = explode('|',$this->input->post('nominal'));

        if(isset($_POST['buy'])){
            $check_cust = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
            $balance = $check_cust->balance;
            $data['response'] = '<h3>ERROR, Jangan melakukan refresh dan mencoba kembali, Silahkan segera menghubungi customer service</h3>';
            if($balance > $nominal[1]){
                $data_trx = array(
                    'ppob_type'         => 'topup games',
                    'ppob_account'      => $this->input->post('phone'),
                    'id_ppob_customer'  => $this->session->userdata('SESS_DATA')['cust_id'],
                    'qty'               => $nominal[1],
                    'price'             => $nominal[1],
                    'status'            => 'PROCESS'
                );
                $insert =  json_decode($this->curl->simple_post($this->API.'ppob_transaction', $data_trx, array(CURLOPT_BUFFERSIZE => 10)));
                $data_mp = array(
                    'commands'  => 'topup',
                    'username'  => '081210113977',
                    'ref_id'    => $insert->id_trx,
                    'hp'        => $this->input->post('phone'),
                    'pulsa_code'=> $nominal[0],
                    'sign'      => md5('0812101139773345e28cae81da00334'.$insert->id_trx)
                );
                $post_mp = json_decode($this->curl->simple_post('https://api.mobilepulsa.net/v1/legacy/index', json_encode($data_mp), array(CURLOPT_BUFFERSIZE => 10)));
                // $post_mp = json_decode($this->curl->simple_post('https://testprepaid.mobilepulsa.net/v1/legacy/index', json_encode($data_mp), array(CURLOPT_BUFFERSIZE => 10)));
                // var_dump($post_mp);
                // return false;
                if($post_mp->data->rc == '39'){
                    $data['response'] = '<h3>Top up Voucher Game sedang di proses, silahkan tunggu</h3><center><img src="'.$this->asset.'img/loading.gif" class="img-fluid" style="width:200px" id="loading1"></center>';
                    $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
                }else if($post_mp->data->rc == '14'){
                    $data_transaction = array(
                        'id_ppob_transaction'   => $insert->id_trx,
                        'status'                => 'Incorrect Destination Number'
                    );
                    // file_put_contents('a.json', $jsonData);
                    
                    $update =  $this->curl->simple_put($this->API.'ppob_transaction', $data_transaction, array(CURLOPT_BUFFERSIZE => 10));
                    
                    $data['response'] = '<h3>Incorrect Destination Number</h3>';
                    $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
                }else if($post_mp->data->rc == '16'){
                    $data_transaction = array(
                        'id_ppob_transaction'   => $insert->id_trx,
                        'status'                => 'Number Not Match With Operator'
                    );
                    // file_put_contents('a.json', $jsonData);
                    
                    $update =  $this->curl->simple_put($this->API.'ppob_transaction', $data_transaction, array(CURLOPT_BUFFERSIZE => 10));
                    
                    $data['response'] = '<h3>Number Not Match With Operator</h3>';
                    $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
                }else if($post_mp->data->rc == '106'){
                    $data_transaction = array(
                        'id_ppob_transaction'   => $insert->id_trx,
                        'status'                => 'PRODUCT IS TEMPORARILY OUT OF SERVICE'
                    );
                    // file_put_contents('a.json', $jsonData);
                    
                    $update =  $this->curl->simple_put($this->API.'ppob_transaction', $data_transaction, array(CURLOPT_BUFFERSIZE => 10));
                    
                    $data['response'] = '<h3>PRODUCT IS TEMPORARILY OUT OF SERVICE</h3>';
                    $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
                }
            }else{
                $data['response'] = '<h3>Saldo tidak mencukupi, silahkan isi saldo terlebih dahulu</h3>';
            }
        }else{
            redirect(base_url().'feature-crj-express/voucher-games');
        }

        $data['title'] = 'Voucher Games | CRJExpress';
        $data['asset'] = $this->asset;
        // $data['response'] = 'Top up Pulsa sedang di proses, silahkan tunggu';
        // $data['header']=$this->load->view('templates/header',$data, true);
        $data['content']=$this->load->view('customer/product/top_up_pulsa',$data, true);
        // $data['footer']=$this->load->view('templates/footer',$data, true);
		
        $this->load->view('customer/template/index',$data);
    }
    function emoney_topup(){
        if(!$this->session->userdata('IS_LOGIN_PPOB')){
            redirect(base_url().'login');
        }else{
            $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
        }
        $nominal = explode('|',$this->input->post('nominal'));

        if(isset($_POST['buy'])){
            $check_cust = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
            $balance = $check_cust->balance;
            $data['response'] = '<h3>ERROR, Jangan melakukan refresh dan mencoba kembali, Silahkan segera menghubungi customer service</h3>';
            if($balance > $nominal[1]){
                $data_trx = array(
                    'ppob_type'         => 'topup emoney',
                    'ppob_account'      => $this->input->post('phone'),
                    'id_ppob_customer'  => $this->session->userdata('SESS_DATA')['cust_id'],
                    'qty'               => $nominal[1],
                    'price'             => $nominal[1],
                    'status'            => 'PROCESS'
                );
                $insert =  json_decode($this->curl->simple_post($this->API.'ppob_transaction', $data_trx, array(CURLOPT_BUFFERSIZE => 10)));
                $data_mp = array(
                    'commands'  => 'topup',
                    'username'  => '081210113977',
                    'ref_id'    => $insert->id_trx,
                    'hp'        => $this->input->post('phone'),
                    'pulsa_code'=> $nominal[0],
                    'sign'      => md5('0812101139773345e28cae81da00334'.$insert->id_trx)
                );
                $post_mp = json_decode($this->curl->simple_post('https://api.mobilepulsa.net/v1/legacy/index', json_encode($data_mp), array(CURLOPT_BUFFERSIZE => 10)));
                // $post_mp = json_decode($this->curl->simple_post('https://testprepaid.mobilepulsa.net/v1/legacy/index', json_encode($data_mp), array(CURLOPT_BUFFERSIZE => 10)));
                if($post_mp->data->rc == '39'){
                    $data['response'] = '<h3>Top up E Money sedang di proses, silahkan tunggu</h3><center><img src="'.$this->asset.'img/loading.gif" class="img-fluid" style="width:200px" id="loading1"></center>';
                    $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
                }else if($post_mp->data->rc == '14'){
                    $data_transaction = array(
                        'id_ppob_transaction'   => $insert->id_trx,
                        'status'                => 'Incorrect Destination Number'
                    );
                    // file_put_contents('a.json', $jsonData);
                    
                    $update =  $this->curl->simple_put($this->API.'ppob_transaction', $data_transaction, array(CURLOPT_BUFFERSIZE => 10));
                    
                    $data['response'] = '<h3>Incorrect Destination Number</h3>';
                    $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
                }else if($post_mp->data->rc == '16'){
                    $data_transaction = array(
                        'id_ppob_transaction'   => $insert->id_trx,
                        'status'                => 'Number Not Match With Operator'
                    );
                    // file_put_contents('a.json', $jsonData);
                    
                    $update =  $this->curl->simple_put($this->API.'ppob_transaction', $data_transaction, array(CURLOPT_BUFFERSIZE => 10));
                    
                    $data['response'] = '<h3>Number Not Match With Operator</h3>';
                    $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
                }else if($post_mp->data->rc == '106'){
                    $data_transaction = array(
                        'id_ppob_transaction'   => $insert->id_trx,
                        'status'                => 'PRODUCT IS TEMPORARILY OUT OF SERVICE'
                    );
                    // file_put_contents('a.json', $jsonData);
                    
                    $update =  $this->curl->simple_put($this->API.'ppob_transaction', $data_transaction, array(CURLOPT_BUFFERSIZE => 10));
                    
                    $data['response'] = '<h3>PRODUCT IS TEMPORARILY OUT OF SERVICE</h3>';
                    $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
                }
            }else{
                $data['response'] = '<h3>Saldo tidak mencukupi, silahkan isi saldo terlebih dahulu</h3>';
            }
        }else{
            redirect(base_url().'feature-crj-express/e-money');
        }

        $data['title'] = 'Voucher Games | CRJExpress';
        $data['asset'] = $this->asset;
        // $data['response'] = 'Top up Pulsa sedang di proses, silahkan tunggu';
        // $data['header']=$this->load->view('templates/header',$data, true);
        $data['content']=$this->load->view('customer/product/top_up_pulsa',$data, true);
        // $data['footer']=$this->load->view('templates/footer',$data, true);
		
        $this->load->view('customer/template/index',$data);
    }
    function postpaid_el(){
        $data['title'] = 'Tagihan Listrik | CRJExpress';
        $data['asset'] = $this->asset;
        if($this->session->userdata('IS_LOGIN_PPOB')){
            $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
        }
        $data['check'] = 0;

        if(isset($_POST['check'])){
            $check_cust = json_decode($this->curl->simple_get($this->API.'ppob_transaction?action=check'))->result[0];
            $ref_id = $check_cust->id_ppob_transaction + 100;
            $data['response'] = '<h3>ERROR, Jangan melakukan refresh dan mencoba kembali, Silahkan segera menghubungi customer service</h3>';
            $code = 'PLNPOSTPAID';
            $data_mp = array(
                'commands'  => 'inq-pasca',
                'username'  => '081210113977',
                'code'      => $code,
                'hp'        => $this->input->post('phone'),
                'ref_id'    => $ref_id,
                'sign'      => md5('0812101139773345e28cae81da00334'.$ref_id)
            );
            // var_dump($data_mp);
            // return false;
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://mobilepulsa.net/api/v1/bill/check",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>json_encode($data_mp),
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            // echo $response;
            
            // $post_mp = json_decode($this->curl->simple_post('https://mobilepulsa.net/api/v1/bill/check', json_encode($data_mp), array(CURLOPT_BUFFERSIZE => 10)));
            
            // $post_mp = $this->curl->simple_post('https://testpostpaid.mobilepulsa.net/api/v1/bill/check', $jsondata, array(CURLOPT_BUFFERSIZE => 10));
            // var_dump($response);
            // return false;
            $response = json_decode($response);
            if($response->data->response_code == '00'){
                $data_trx = array(
                    'ppob_type'         => 'postpaid pln',
                    'ppob_account'      => $this->input->post('phone'),
                    'id_ppob_customer'  => $this->session->userdata('SESS_DATA')['cust_id'],
                    'qty'               => $response->data->nominal,
                    'price'             => $response->data->nominal + $response->data->admin,
                    'status'            => 'CHECK'
                );
                $insert =  json_decode($this->curl->simple_post($this->API.'ppob_transaction', $data_trx, array(CURLOPT_BUFFERSIZE => 10)));
                // var_dump($data_trx);
                // return false;
                $data['trx'] = $response;
                $data['check'] = 1;
                $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
            }else if($response->data->response_code == '01'){
                $data_trx = array(
                    'ppob_type'         => 'postpaid pln',
                    'ppob_account'      => $this->input->post('phone'),
                    'id_ppob_customer'  => $this->session->userdata('SESS_DATA')['cust_id'],
                    'qty'               => '0',
                    'price'             => '0',
                    'status'            => 'TAGIHAN LUNAS'
                );
                $insert =  json_decode($this->curl->simple_post($this->API.'ppob_transaction', $data_trx, array(CURLOPT_BUFFERSIZE => 10)));
                $data['check'] = 2;
                $data['message'] = 'TAGIHAN TELAH LUNAS';
                $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
            }else{
                $data_trx = array(
                    'ppob_type'         => 'postpaid pln',
                    'ppob_account'      => $this->input->post('phone'),
                    'id_ppob_customer'  => $this->session->userdata('SESS_DATA')['cust_id'],
                    'qty'               => '0',
                    'price'             => '0',
                    'status'            => 'NOMOR PELANGGAN TIDAK DITEMUKAN'
                );
                $insert =  json_decode($this->curl->simple_post($this->API.'ppob_transaction', $data_trx, array(CURLOPT_BUFFERSIZE => 10)));
                $data['check'] = 2;
                $data['message'] = 'NOMOR PELANGGAN TIDAK DITEMUKAN';
                $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
            }
        }
        // var_dump($data['check']);
        // return false;
        // $data['header']=$this->load->view('templates/header',$data, true);
        $data['content']=$this->load->view('customer/product/postpaid_el',$data, true);
        // $data['footer']=$this->load->view('templates/footer',$data, true);
		
        $this->load->view('customer/template/index',$data);
    }
    function tagihan_bpjs(){
        $data['title'] = 'Tagihan BPJS | CRJExpress';
        $data['asset'] = $this->asset;
        if($this->session->userdata('IS_LOGIN_PPOB')){
            $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
        }
        $data['check'] = 0;
        if(isset($_POST['check'])){
            $check_cust = json_decode($this->curl->simple_get($this->API.'ppob_transaction?action=check'))->result[0];
            $ref_id = $check_cust->id_ppob_transaction + 100;
            $data['response'] = '<h3>ERROR, Jangan melakukan refresh dan mencoba kembali, Silahkan segera menghubungi customer service</h3>';
            $code = 'BPJS';
            $data_mp = array(
                'commands'  => 'inq-pasca',
                'username'  => '081210113977',
                'code'      => $code,
                'hp'        => $this->input->post('phone'),
                'ref_id'    => $ref_id,
                'sign'      => md5('0812101139773345e28cae81da00334'.$ref_id),
                'month'     => $this->input->post('month')
            );
            // var_dump($data_mp);
            // return false;
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://mobilepulsa.net/api/v1/bill/check",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>json_encode($data_mp),
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            // echo $response;
            
            // $post_mp = json_decode($this->curl->simple_post('https://mobilepulsa.net/api/v1/bill/check', json_encode($data_mp), array(CURLOPT_BUFFERSIZE => 10)));
            
            // $post_mp = $this->curl->simple_post('https://testpostpaid.mobilepulsa.net/api/v1/bill/check', $jsondata, array(CURLOPT_BUFFERSIZE => 10));
            // var_dump($response);
            // return false;
            $response = json_decode($response);
            if($response->data->response_code == '00'){
                $data_trx = array(
                    'ppob_type'         => 'postpaid bpjs',
                    'ppob_account'      => $this->input->post('phone'),
                    'id_ppob_customer'  => $this->session->userdata('SESS_DATA')['cust_id'],
                    'qty'               => $response->data->nominal,
                    'price'             => $response->data->nominal + $response->data->admin,
                    'status'            => 'CHECK'
                );
                $insert =  json_decode($this->curl->simple_post($this->API.'ppob_transaction', $data_trx, array(CURLOPT_BUFFERSIZE => 10)));
                // var_dump($data_trx);
                // return false;
                $data['trx'] = $response;
                $data['check'] = 1;
                $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
            }else if($response->data->response_code == '01'){
                $data_trx = array(
                    'ppob_type'         => 'postpaid bpjs',
                    'ppob_account'      => $this->input->post('phone'),
                    'id_ppob_customer'  => $this->session->userdata('SESS_DATA')['cust_id'],
                    'qty'               => '0',
                    'price'             => '0',
                    'status'            => 'TAGIHAN LUNAS'
                );
                $insert =  json_decode($this->curl->simple_post($this->API.'ppob_transaction', $data_trx, array(CURLOPT_BUFFERSIZE => 10)));
                $data['check'] = 2;
                $data['message'] = 'TAGIHAN TELAH LUNAS';
                $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
            }else{
                $data_trx = array(
                    'ppob_type'         => 'postpaid bpjs',
                    'ppob_account'      => $this->input->post('phone'),
                    'id_ppob_customer'  => $this->session->userdata('SESS_DATA')['cust_id'],
                    'qty'               => '0',
                    'price'             => '0',
                    'status'            => 'NOMOR PELANGGAN TIDAK DITEMUKAN'
                );
                $insert =  json_decode($this->curl->simple_post($this->API.'ppob_transaction', $data_trx, array(CURLOPT_BUFFERSIZE => 10)));
                $data['check'] = 2;
                $data['message'] = 'NOMOR PELANGGAN TIDAK DITEMUKAN';
                $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
            }
        }
        // var_dump($data['check']);
        // return false;
        // $data['header']=$this->load->view('templates/header',$data, true);
        $data['content']=$this->load->view('customer/product/tagihan_bpjs',$data, true);
        // $data['footer']=$this->load->view('templates/footer',$data, true);
		
        $this->load->view('customer/template/index',$data);
    }
    function tagihan_gas(){
        $data['title'] = 'Tagihan Gas | CRJExpress';
        $data['asset'] = $this->asset;
        if($this->session->userdata('IS_LOGIN_PPOB')){
            $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
        }
        $data['check'] = 0;
        if(isset($_POST['check'])){
            $check_cust = json_decode($this->curl->simple_get($this->API.'ppob_transaction?action=check'))->result[0];
            $ref_id = $check_cust->id_ppob_transaction + 100;
            $data['response'] = '<h3>ERROR, Jangan melakukan refresh dan mencoba kembali, Silahkan segera menghubungi customer service</h3>';
            $code = 'PGAS';
            $data_mp = array(
                'commands'  => 'inq-pasca',
                'username'  => '081210113977',
                'code'      => $code,
                'hp'        => $this->input->post('phone'),
                'ref_id'    => $ref_id,
                'sign'      => md5('0812101139773345e28cae81da00334'.$ref_id)
            );
            // var_dump($data_mp);
            // return false;
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://mobilepulsa.net/api/v1/bill/check",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>json_encode($data_mp),
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            // echo $response;
            
            // $post_mp = json_decode($this->curl->simple_post('https://mobilepulsa.net/api/v1/bill/check', json_encode($data_mp), array(CURLOPT_BUFFERSIZE => 10)));
            
            // $post_mp = $this->curl->simple_post('https://testpostpaid.mobilepulsa.net/api/v1/bill/check', $jsondata, array(CURLOPT_BUFFERSIZE => 10));
            // var_dump($response);
            // return false;
            $response = json_decode($response);
            if($response->data->response_code == '00'){
                $data_trx = array(
                    'ppob_type'         => 'postpaid gas',
                    'ppob_account'      => $this->input->post('phone'),
                    'id_ppob_customer'  => $this->session->userdata('SESS_DATA')['cust_id'],
                    'qty'               => $response->data->nominal,
                    'price'             => $response->data->nominal + $response->data->admin,
                    'status'            => 'CHECK'
                );
                $insert =  json_decode($this->curl->simple_post($this->API.'ppob_transaction', $data_trx, array(CURLOPT_BUFFERSIZE => 10)));
                // var_dump($data_trx);
                // return false;
                $data['trx'] = $response;
                $data['check'] = 1;
                $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
            }else if($response->data->response_code == '01'){
                $data_trx = array(
                    'ppob_type'         => 'postpaid gas',
                    'ppob_account'      => $this->input->post('phone'),
                    'id_ppob_customer'  => $this->session->userdata('SESS_DATA')['cust_id'],
                    'qty'               => '0',
                    'price'             => '0',
                    'status'            => 'TAGIHAN LUNAS'
                );
                $insert =  json_decode($this->curl->simple_post($this->API.'ppob_transaction', $data_trx, array(CURLOPT_BUFFERSIZE => 10)));
                $data['check'] = 2;
                $data['message'] = 'TAGIHAN TELAH LUNAS';
                $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
            }else{
                $data_trx = array(
                    'ppob_type'         => 'postpaid gas',
                    'ppob_account'      => $this->input->post('phone'),
                    'id_ppob_customer'  => $this->session->userdata('SESS_DATA')['cust_id'],
                    'qty'               => '0',
                    'price'             => '0',
                    'status'            => 'NOMOR PELANGGAN TIDAK DITEMUKAN'
                );
                $insert =  json_decode($this->curl->simple_post($this->API.'ppob_transaction', $data_trx, array(CURLOPT_BUFFERSIZE => 10)));
                $data['check'] = 2;
                $data['message'] = 'NOMOR PELANGGAN TIDAK DITEMUKAN';
                $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
            }
        }
        // $data['header']=$this->load->view('templates/header',$data, true);
        $data['content']=$this->load->view('customer/product/tagihan_gas',$data, true);
        // $data['footer']=$this->load->view('templates/footer',$data, true);
		
        $this->load->view('customer/template/index',$data);
    }
    function tagihan_pdam(){
        $data['title'] = 'Tagihan PDAM | CRJExpress';
        $data['asset'] = $this->asset;
        if($this->session->userdata('IS_LOGIN_PPOB')){
            $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
        }
        $data['check'] = 0;
        $req = array(
            'commands'  => 'pricelist-pasca',
            'username'  => '081210113977',
            'sign'      => md5('0812101139773345e28cae81da00334pl'),
            'status'    => 'all'
        );
        $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://mobilepulsa.net/api/v1/bill/check/pdam",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>json_encode($req),
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
        $data['option'] = json_decode($response)->data->pasca;
        // var_dump($data['option']);
        // return false;
        
        if(isset($_POST['check'])){
            $check_cust = json_decode($this->curl->simple_get($this->API.'ppob_transaction?action=check'))->result[0];
            $ref_id = $check_cust->id_ppob_transaction + 100;
            $data['response'] = '<h3>ERROR, Jangan melakukan refresh dan mencoba kembali, Silahkan segera menghubungi customer service</h3>';
            $code = $this->input->post('code');
            $data['code'] = $code;
            $data_mp = array(
                'commands'  => 'inq-pasca',
                'username'  => '081210113977',
                'code'      => $code,
                'hp'        => $this->input->post('phone'),
                'ref_id'    => $ref_id,
                'sign'      => md5('0812101139773345e28cae81da00334'.$ref_id)
            );
            // var_dump($data_mp);
            // return false;
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://mobilepulsa.net/api/v1/bill/check",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>json_encode($data_mp),
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            // echo $response;
            
            // $post_mp = json_decode($this->curl->simple_post('https://mobilepulsa.net/api/v1/bill/check', json_encode($data_mp), array(CURLOPT_BUFFERSIZE => 10)));
            
            // $post_mp = $this->curl->simple_post('https://testpostpaid.mobilepulsa.net/api/v1/bill/check', $jsondata, array(CURLOPT_BUFFERSIZE => 10));
            $response = json_decode($response);
            // var_dump($response);
            // return false;
            if($response->data->response_code == '00'){
                $data_trx = array(
                    'ppob_type'         => 'postpaid pdam',
                    'ppob_account'      => $this->input->post('phone'),
                    'id_ppob_customer'  => $this->session->userdata('SESS_DATA')['cust_id'],
                    'qty'               => $response->data->nominal,
                    'price'             => $response->data->nominal + $response->data->admin,
                    'status'            => 'CHECK'
                );
                $insert =  json_decode($this->curl->simple_post($this->API.'ppob_transaction', $data_trx, array(CURLOPT_BUFFERSIZE => 10)));
                // var_dump($response);
                // return false;
                $data['trx'] = $response;
                $data['check'] = 1;
                $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
            }else if($response->data->response_code == '01'){
                $data_trx = array(
                    'ppob_type'         => 'postpaid pdam',
                    'ppob_account'      => $this->input->post('phone'),
                    'id_ppob_customer'  => $this->session->userdata('SESS_DATA')['cust_id'],
                    'qty'               => '0',
                    'price'             => '0',
                    'status'            => 'TAGIHAN LUNAS'
                );
                $insert =  json_decode($this->curl->simple_post($this->API.'ppob_transaction', $data_trx, array(CURLOPT_BUFFERSIZE => 10)));
                $data['check'] = 2;
                $data['message'] = 'TAGIHAN TELAH LUNAS';
                $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
            }else{
                $data_trx = array(
                    'ppob_type'         => 'postpaid pdam',
                    'ppob_account'      => $this->input->post('phone'),
                    'id_ppob_customer'  => $this->session->userdata('SESS_DATA')['cust_id'],
                    'qty'               => '0',
                    'price'             => '0',
                    'status'            => 'NOMOR PELANGGAN TIDAK DITEMUKAN'
                );
                $insert =  json_decode($this->curl->simple_post($this->API.'ppob_transaction', $data_trx, array(CURLOPT_BUFFERSIZE => 10)));
                $data['check'] = 2;
                $data['message'] = 'NOMOR PELANGGAN TIDAK DITEMUKAN';
                $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
            }
        }
        
        // $data['header']=$this->load->view('templates/header',$data, true);
        $data['content']=$this->load->view('customer/product/tagihan_pdam',$data, true);
        // $data['footer']=$this->load->view('templates/footer',$data, true);
		
        $this->load->view('customer/template/index',$data);
    }

    function tagihan_finance(){
        $data['title'] = 'Tagihan Finance | CRJExpress';
        $data['asset'] = $this->asset;
        if($this->session->userdata('IS_LOGIN_PPOB')){
            $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
        }
        $data['check'] = 0;
        $req = array(
            'commands'  => 'pricelist-pasca',
            'username'  => '081210113977',
            'sign'      => md5('0812101139773345e28cae81da00334pl'),
            'status'    => 'all'
        );
        $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://mobilepulsa.net/api/v1/bill/check/finance",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>json_encode($req),
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
        $data['option'] = json_decode($response)->data->pasca;
        // var_dump($data['option']);
        // return false;
        
        if(isset($_POST['check'])){
            $check_cust = json_decode($this->curl->simple_get($this->API.'ppob_transaction?action=check'))->result[0];
            $ref_id = $check_cust->id_ppob_transaction + 100;
            $data['response'] = '<h3>ERROR, Jangan melakukan refresh dan mencoba kembali, Silahkan segera menghubungi customer service</h3>';
            $code = $this->input->post('code');
            $data['code'] = $code;
            $data_mp = array(
                'commands'  => 'inq-pasca',
                'username'  => '081210113977',
                'code'      => $code,
                'hp'        => $this->input->post('phone'),
                'ref_id'    => $ref_id,
                'sign'      => md5('0812101139773345e28cae81da00334'.$ref_id)
            );
            // $refid = 'AAD';
            // $data_mp = array(
            //     'commands'  => 'inq-pasca',
            //     'username'  => '081210113977',
            //     'code'      => 'FNMEGA',
            //     'hp'        => '6391601203',
            //     'ref_id'    => $refid,
            //     'sign'      => md5('0812101139778965dc5e142d7051'.$refid)
            // );
            // var_dump($data_mp);
            // return false;
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://mobilepulsa.net/api/v1/bill/check",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>json_encode($data_mp),
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            // echo $response;
            
            // $post_mp = json_decode($this->curl->simple_post('https://mobilepulsa.net/api/v1/bill/check', json_encode($data_mp), array(CURLOPT_BUFFERSIZE => 10)));
            
            // $post_mp = $this->curl->simple_post('https://testpostpaid.mobilepulsa.net/api/v1/bill/check', $jsondata, array(CURLOPT_BUFFERSIZE => 10));
            // var_dump($response);
            // return false;
            $response = json_decode($response);
            if($response->data->response_code == '00'){
                $data_trx = array(
                    'ppob_type'         => 'postpaid finance',
                    'ppob_account'      => $this->input->post('phone'),
                    'id_ppob_customer'  => $this->session->userdata('SESS_DATA')['cust_id'],
                    'qty'               => $response->data->nominal,
                    'price'             => $response->data->nominal + $response->data->admin,
                    'status'            => 'CHECK'
                );
                $insert =  json_decode($this->curl->simple_post($this->API.'ppob_transaction', $data_trx, array(CURLOPT_BUFFERSIZE => 10)));
                // var_dump($data_trx);
                // return false;
                $data['trx'] = $response;
                $data['check'] = 1;
                $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
            }else if($response->data->response_code == '01'){
                $data_trx = array(
                    'ppob_type'         => 'postpaid finance',
                    'ppob_account'      => $this->input->post('phone'),
                    'id_ppob_customer'  => $this->session->userdata('SESS_DATA')['cust_id'],
                    'qty'               => '0',
                    'price'             => '0',
                    'status'            => 'TAGIHAN LUNAS'
                );
                $insert =  json_decode($this->curl->simple_post($this->API.'ppob_transaction', $data_trx, array(CURLOPT_BUFFERSIZE => 10)));
                $data['check'] = 2;
                $data['message'] = 'TAGIHAN TELAH LUNAS';
                $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
            }else{
                $data_trx = array(
                    'ppob_type'         => 'postpaid finance',
                    'ppob_account'      => $this->input->post('phone'),
                    'id_ppob_customer'  => $this->session->userdata('SESS_DATA')['cust_id'],
                    'qty'               => '0',
                    'price'             => '0',
                    'status'            => 'NOMOR PELANGGAN TIDAK DITEMUKAN'
                );
                $insert =  json_decode($this->curl->simple_post($this->API.'ppob_transaction', $data_trx, array(CURLOPT_BUFFERSIZE => 10)));
                $data['check'] = 2;
                $data['message'] = 'NOMOR PELANGGAN TIDAK DITEMUKAN';
                $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
            }
        }
        
        // $data['header']=$this->load->view('templates/header',$data, true);
        $data['content']=$this->load->view('customer/product/tagihan_finance',$data, true);
        // $data['footer']=$this->load->view('templates/footer',$data, true);
		
        $this->load->view('customer/template/index',$data);
    }
    function tagihan_telkom(){
        $data['title'] = 'Tagihan Telkom | CRJExpress';
        $data['asset'] = $this->asset;
        if($this->session->userdata('IS_LOGIN_PPOB')){
            $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
        }
        $data['check'] = 0;
        if(isset($_POST['check'])){
            $check_cust = json_decode($this->curl->simple_get($this->API.'ppob_transaction?action=check'))->result[0];
            $ref_id = $check_cust->id_ppob_transaction + 100;
            $data['response'] = '<h3>ERROR, Jangan melakukan refresh dan mencoba kembali, Silahkan segera menghubungi customer service</h3>';
            $code = 'TELKOMPSTN';
            $data_mp = array(
                'commands'  => 'inq-pasca',
                'username'  => '081210113977',
                'code'      => $code,
                'hp'        => $this->input->post('phone'),
                'ref_id'    => $ref_id,
                'sign'      => md5('0812101139773345e28cae81da00334'.$ref_id)
            );
            // var_dump($data_mp);
            // return false;
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://mobilepulsa.net/api/v1/bill/check",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>json_encode($data_mp),
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            // echo $response;
            
            // $post_mp = json_decode($this->curl->simple_post('https://mobilepulsa.net/api/v1/bill/check', json_encode($data_mp), array(CURLOPT_BUFFERSIZE => 10)));
            
            // $post_mp = $this->curl->simple_post('https://testpostpaid.mobilepulsa.net/api/v1/bill/check', $jsondata, array(CURLOPT_BUFFERSIZE => 10));
            // var_dump($response);
            // return false;
            $response = json_decode($response);
            if($response->data->response_code == '00'){
                $data_trx = array(
                    'ppob_type'         => 'postpaid telkom',
                    'ppob_account'      => $this->input->post('phone'),
                    'id_ppob_customer'  => $this->session->userdata('SESS_DATA')['cust_id'],
                    'qty'               => $response->data->nominal,
                    'price'             => $response->data->nominal + $response->data->admin,
                    'status'            => 'CHECK'
                );
                $insert =  json_decode($this->curl->simple_post($this->API.'ppob_transaction', $data_trx, array(CURLOPT_BUFFERSIZE => 10)));
                // var_dump($data_trx);
                // return false;
                $data['trx'] = $response;
                $data['check'] = 1;
                $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
            }else if($response->data->response_code == '01'){
                $data_trx = array(
                    'ppob_type'         => 'postpaid telkom',
                    'ppob_account'      => $this->input->post('phone'),
                    'id_ppob_customer'  => $this->session->userdata('SESS_DATA')['cust_id'],
                    'qty'               => '0',
                    'price'             => '0',
                    'status'            => 'TAGIHAN LUNAS'
                );
                $insert =  json_decode($this->curl->simple_post($this->API.'ppob_transaction', $data_trx, array(CURLOPT_BUFFERSIZE => 10)));
                $data['check'] = 2;
                $data['message'] = 'TAGIHAN TELAH LUNAS';
                $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
            }else{
                $data_trx = array(
                    'ppob_type'         => 'postpaid telkom',
                    'ppob_account'      => $this->input->post('phone'),
                    'id_ppob_customer'  => $this->session->userdata('SESS_DATA')['cust_id'],
                    'qty'               => '0',
                    'price'             => '0',
                    'status'            => 'NOMOR PELANGGAN TIDAK DITEMUKAN'
                );
                $insert =  json_decode($this->curl->simple_post($this->API.'ppob_transaction', $data_trx, array(CURLOPT_BUFFERSIZE => 10)));
                $data['check'] = 2;
                $data['message'] = 'NOMOR PELANGGAN TIDAK DITEMUKAN';
                $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
            }
        }
        // var_dump($data['check']);
        // return false;
        // $data['header']=$this->load->view('templates/header',$data, true);
        $data['content']=$this->load->view('customer/product/tagihan_telkom',$data, true);
        // $data['footer']=$this->load->view('templates/footer',$data, true);
		
        $this->load->view('customer/template/index',$data);
    }
    function postpaid_mobile(){
        if(!$this->session->userdata('IS_LOGIN_PPOB')){
            redirect(base_url().'login');
        }else{
            $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
        }
        $data['title'] = 'Pulsa Pasca Bayar | CRJExpress';
        $data['asset'] = $this->asset;
        if($this->session->userdata('IS_LOGIN_PPOB')){
            $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
        }
        $data['check'] = 0;
        $data['pay']    = 0;

        if(isset($_POST['check'])){
            $check_cust = json_decode($this->curl->simple_get($this->API.'ppob_transaction?action=check'))->result[0];
            $ref_id = $check_cust->id_ppob_transaction + 100;
            $data['response'] = '<h3>ERROR, Jangan melakukan refresh dan mencoba kembali, Silahkan segera menghubungi customer service</h3>';
            $indosat = array('0814','0815','0816','0855','0856','0857','0858');
            $xl = array('0817','0818','0819','0859','0878','0877');
            $axis = array('0838','0837','0831','0832');
            $telkomsel = array('0812','0813','0852','0853','0821','0823','0822','0851');
            $smartfren = array('0881','0882','0883','0884', '0885','0886','0887','0888');
            $three = array('0896','0897','0898','0899','0895');
            $phone = substr($this->input->post('phone'), 0, 4);
            $code = '';
            if(in_array($phone,$indosat)){
                $code = 'HPMTRIX';
            }else if(in_array($phone,$smartfren)){
                $code = 'HPSMART';
            }else if(in_array($phone,$three)){
                $code = 'HPTHREE';
            }else if(in_array($phone,$telkomsel)){
                $code = 'HPTSEL';
            }else if(in_array($phone,$xl)){
                $code = 'HPXL';
            }
            $data_mp = array(
                'commands'  => 'inq-pasca',
                'username'  => '081210113977',
                'code'      => $code,
                'hp'        => $this->input->post('phone'),
                'ref_id'    => $ref_id,
                'sign'      => md5('0812101139773345e28cae81da00334'.$ref_id)
            );
            // var_dump($data_mp);
            // return false;
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://mobilepulsa.net/api/v1/bill/check",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>json_encode($data_mp),
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            // echo $response;
            
            // $post_mp = json_decode($this->curl->simple_post('https://mobilepulsa.net/api/v1/bill/check', json_encode($data_mp), array(CURLOPT_BUFFERSIZE => 10)));
            
            // $post_mp = $this->curl->simple_post('https://testpostpaid.mobilepulsa.net/api/v1/bill/check', $jsondata, array(CURLOPT_BUFFERSIZE => 10));
            // var_dump($response);
            // return false;
            $response = json_decode($response);
            if($response->data->response_code == '00'){
                $data_trx = array(
                    'ppob_type'         => 'postpaid mobile',
                    'ppob_account'      => $this->input->post('phone'),
                    'id_ppob_customer'  => $this->session->userdata('SESS_DATA')['cust_id'],
                    'qty'               => $response->data->nominal,
                    'price'             => $response->data->nominal + $response->data->admin,
                    'status'            => 'CHECK'
                );
                $insert =  json_decode($this->curl->simple_post($this->API.'ppob_transaction', $data_trx, array(CURLOPT_BUFFERSIZE => 10)));
                // var_dump($data_trx);
                // return false;
                $data['trx'] = $response;
                $data['check'] = 1;
                $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
            }else if($response->data->response_code == '01'){
                $data_trx = array(
                    'ppob_type'         => 'postpaid mobile',
                    'ppob_account'      => $this->input->post('phone'),
                    'id_ppob_customer'  => $this->session->userdata('SESS_DATA')['cust_id'],
                    'qty'               => '0',
                    'price'             => '0',
                    'status'            => 'TAGIHAN LUNAS'
                );
                $insert =  json_decode($this->curl->simple_post($this->API.'ppob_transaction', $data_trx, array(CURLOPT_BUFFERSIZE => 10)));
                $data['check'] = 2;
                $data['message'] = 'TAGIHAN TELAH LUNAS';
                $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
            }else{
                $data_trx = array(
                    'ppob_type'         => 'postpaid mobile',
                    'ppob_account'      => $this->input->post('phone'),
                    'id_ppob_customer'  => $this->session->userdata('SESS_DATA')['cust_id'],
                    'qty'               => '0',
                    'price'             => '0',
                    'status'            => 'NOMOR PELANGGAN TIDAK DITEMUKAN'
                );
                $insert =  json_decode($this->curl->simple_post($this->API.'ppob_transaction', $data_trx, array(CURLOPT_BUFFERSIZE => 10)));
                $data['check'] = 2;
                $data['message'] = 'NOMOR PELANGGAN TIDAK DITEMUKAN';
                $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
            }
        }
        $data['content']=$this->load->view('customer/product/postpaid_mobile',$data, true);
        
        $this->load->view('customer/template/index',$data);
    }
    function top_up_pulsa(){
        if(!$this->session->userdata('IS_LOGIN_PPOB')){
            redirect(base_url().'login');
        }else{
            $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
        }

        if(isset($_POST['buy'])){
            $check_cust = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
            $balance = $check_cust->balance;
            $data['response'] = '<h3>ERROR, Jangan melakukan refresh dan mencoba kembali, Silahkan segera menghubungi customer service</h3>';
            if($balance > $this->input->post('nominal')){
                $data_trx = array(
                    'ppob_type'         => 'topup pulsa',
                    'ppob_account'      => $this->input->post('phone'),
                    'id_ppob_customer'  => $this->session->userdata('SESS_DATA')['cust_id'],
                    'qty'               => $this->input->post('nominal'),
                    'price'             => $this->input->post('nominal')+1000,
                    'status'            => 'PROCESS'
                );
                $insert =  json_decode($this->curl->simple_post($this->API.'ppob_transaction', $data_trx, array(CURLOPT_BUFFERSIZE => 10)));
                $data_mp = array(
                    'commands'  => 'topup',
                    'username'  => '081210113977',
                    'ref_id'    => $insert->id_trx,
                    'hp'        => $this->input->post('phone'),
                    'pulsa_code'=> 'pulsa'.$this->input->post('nominal'),
                    'sign'      => md5('0812101139773345e28cae81da00334'.$insert->id_trx)
                );
                $post_mp = json_decode($this->curl->simple_post('https://api.mobilepulsa.net/v1/legacy/index', json_encode($data_mp), array(CURLOPT_BUFFERSIZE => 10)));
                // $data_mp = array(
                //     'commands'  => 'topup',
                //     'username'  => '081210113977',
                //     'ref_id'    => 'order001',
                //     'hp'        => '082231963778',
                //     'pulsa_code'=> 'pulsa5000',
                //     'sign'      => 'b9302756bc529516de1acd775e7eaa69'
                // );
                // $post_mp = json_decode($this->curl->simple_post('https://testprepaid.mobilepulsa.net/v1/legacy/index', json_encode($data_mp), array(CURLOPT_BUFFERSIZE => 10)));
                // var_dump($post_mp);
                // return false;
                if($post_mp->data->rc == '39'){
                    $data['response'] = '<h3>Top up Pulsa sedang di proses, silahkan tunggu</h3><center><img src="'.$this->asset.'img/loading.gif" class="img-fluid" style="width:200px" id="loading1"></center>';
                    $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
                }else if($post_mp->data->rc == '14'){
                    $data_transaction = array(
                        'id_ppob_transaction'   => $insert->id_trx,
                        'status'                => 'Incorrect Destination Number'
                    );
                    // file_put_contents('a.json', $jsonData);
                    
                    $update =  $this->curl->simple_put($this->API.'ppob_transaction', $data_transaction, array(CURLOPT_BUFFERSIZE => 10));
                    
                    $data['response'] = '<h3>Incorrect Destination Number</h3>';
                    $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
                }else if($post_mp->data->rc == '16'){
                    $data_transaction = array(
                        'id_ppob_transaction'   => $insert->id_trx,
                        'status'                => 'Number Not Match With Operator'
                    );
                    // file_put_contents('a.json', $jsonData);
                    
                    $update =  $this->curl->simple_put($this->API.'ppob_transaction', $data_transaction, array(CURLOPT_BUFFERSIZE => 10));
                    
                    $data['response'] = '<h3>Number Not Match With Operator</h3>';
                    $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
                }else if($post_mp->data->rc == '106'){
                    $data_transaction = array(
                        'id_ppob_transaction'   => $insert->id_trx,
                        'status'                => 'PRODUCT IS TEMPORARILY OUT OF SERVICE'
                    );
                    // file_put_contents('a.json', $jsonData);
                    
                    $update =  $this->curl->simple_put($this->API.'ppob_transaction', $data_transaction, array(CURLOPT_BUFFERSIZE => 10));
                    
                    $data['response'] = '<h3>PRODUCT IS TEMPORARILY OUT OF SERVICE</h3>';
                    $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
                }
            }else{
                $data['response'] = '<h3>Saldo tidak mencukupi, silahkan isi saldo terlebih dahulu</h3>';
            }
        }else{
            redirect(base_url().'feature-crj-express/pulsa-pra-bayar');
        }

        $data['title'] = 'Pulsa Pra Bayar | CRJExpress';
        $data['asset'] = $this->asset;
        // $data['response'] = 'Top up Pulsa sedang di proses, silahkan tunggu';
        // $data['header']=$this->load->view('templates/header',$data, true);
        $data['content']=$this->load->view('customer/product/top_up_pulsa',$data, true);
        // $data['footer']=$this->load->view('templates/footer',$data, true);
		
        $this->load->view('customer/template/index',$data);
    }
    function postpaid_el_pay(){
        if(!$this->session->userdata('IS_LOGIN_PPOB')){
            redirect(base_url().'login');
        }else{
            $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
        }

        if(isset($_POST['pay'])){
            $check_cust = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
            $balance = $check_cust->balance;
            $data['response'] = '<h3>ERROR, Jangan melakukan refresh dan mencoba kembali, Silahkan segera menghubungi customer service</h3>';
            if($balance > $this->input->post('nominal')){
                
                $data_mp = array(
                    'commands'  => 'pay-pasca',
                    'username'  => '081210113977',
                    'tr_id'    => $this->input->post('trx_id'),
                    'sign'      => md5('0812101139773345e28cae81da00334'.$this->input->post('trx_id'))
                );
                
                $curl = curl_init();
    
                curl_setopt_array($curl, array(
                CURLOPT_URL => "https://mobilepulsa.net/api/v1/bill/check",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS =>json_encode($data_mp),
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json"
                ),
                ));
    
                $response = curl_exec($curl);
    
                curl_close($curl);
                $post_mp = json_decode($response);
                // $post_mp = json_decode($this->curl->simple_post('https://testprepaid.mobilepulsa.net/v1/legacy/index', json_encode($data_mp), array(CURLOPT_BUFFERSIZE => 10)));
                if($post_mp->data->message != ''){
                    $data['response'] = '<h3>Pembayaran sedang di proses, silahkan tunggu</h3><center><img src="'.$this->asset.'img/loading.gif" class="img-fluid" style="width:200px" id="loading1"></center>';
                    $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
                }
            }else{
                $data['response'] = '<h3>Saldo tidak mencukupi, silahkan isi saldo terlebih dahulu</h3>';
            }
        }else{
            redirect(base_url().'feature-crj-express/pulsa-pasca-bayar');
        }

        $data['title'] = 'Tagihan Listrik | CRJExpress';
        $data['asset'] = $this->asset;
        // $data['response'] = 'Top up Pulsa sedang di proses, silahkan tunggu';
        // $data['header']=$this->load->view('templates/header',$data, true);
        $data['content']=$this->load->view('customer/product/pay_postpaid_mobile',$data, true);
        // $data['footer']=$this->load->view('templates/footer',$data, true);
		
        $this->load->view('customer/template/index',$data);
    }
    function tagihan_bpjs_pay(){
        if(!$this->session->userdata('IS_LOGIN_PPOB')){
            redirect(base_url().'login');
        }else{
            $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
        }

        if(isset($_POST['pay'])){
            $check_cust = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
            $balance = $check_cust->balance;
            $data['response'] = '<h3>ERROR, Jangan melakukan refresh dan mencoba kembali, Silahkan segera menghubungi customer service</h3>';
            if($balance > $this->input->post('nominal')){
                
                $data_mp = array(
                    'commands'  => 'pay-pasca',
                    'username'  => '081210113977',
                    'tr_id'    => $this->input->post('trx_id'),
                    'sign'      => md5('0812101139773345e28cae81da00334'.$this->input->post('trx_id'))
                );
                
                $curl = curl_init();
    
                curl_setopt_array($curl, array(
                CURLOPT_URL => "https://mobilepulsa.net/api/v1/bill/check",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS =>json_encode($data_mp),
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json"
                ),
                ));
    
                $response = curl_exec($curl);
    
                curl_close($curl);
                $post_mp = json_decode($response);
                // $post_mp = json_decode($this->curl->simple_post('https://testprepaid.mobilepulsa.net/v1/legacy/index', json_encode($data_mp), array(CURLOPT_BUFFERSIZE => 10)));
                if($post_mp->data->message != ''){
                    $data['response'] = '<h3>Pembayaran sedang di proses, silahkan tunggu</h3><center><img src="'.$this->asset.'img/loading.gif" class="img-fluid" style="width:200px" id="loading1"></center>';
                    $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
                }
            }else{
                $data['response'] = '<h3>Saldo tidak mencukupi, silahkan isi saldo terlebih dahulu</h3>';
            }
        }else{
            redirect(base_url().'feature-crj-express/pulsa-pasca-bayar');
        }

        $data['title'] = 'Tagihan BPJS | CRJExpress';
        $data['asset'] = $this->asset;
        // $data['response'] = 'Top up Pulsa sedang di proses, silahkan tunggu';
        // $data['header']=$this->load->view('templates/header',$data, true);
        $data['content']=$this->load->view('customer/product/pay_postpaid_mobile',$data, true);
        // $data['footer']=$this->load->view('templates/footer',$data, true);
		
        $this->load->view('customer/template/index',$data);
    }
    function tagihan_gas_pay(){
        if(!$this->session->userdata('IS_LOGIN_PPOB')){
            redirect(base_url().'login');
        }else{
            $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
        }

        if(isset($_POST['pay'])){
            $check_cust = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
            $balance = $check_cust->balance;
            $data['response'] = '<h3>ERROR, Jangan melakukan refresh dan mencoba kembali, Silahkan segera menghubungi customer service</h3>';
            if($balance > $this->input->post('nominal')){
                
                $data_mp = array(
                    'commands'  => 'pay-pasca',
                    'username'  => '081210113977',
                    'tr_id'    => $this->input->post('trx_id'),
                    'sign'      => md5('0812101139773345e28cae81da00334'.$this->input->post('trx_id'))
                );
                
                $curl = curl_init();
    
                curl_setopt_array($curl, array(
                CURLOPT_URL => "https://mobilepulsa.net/api/v1/bill/check",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS =>json_encode($data_mp),
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json"
                ),
                ));
    
                $response = curl_exec($curl);
    
                curl_close($curl);
                $post_mp = json_decode($response);
                // $post_mp = json_decode($this->curl->simple_post('https://testprepaid.mobilepulsa.net/v1/legacy/index', json_encode($data_mp), array(CURLOPT_BUFFERSIZE => 10)));
                if($post_mp->data->message != ''){
                    $data['response'] = '<h3>Pembayaran sedang di proses, silahkan tunggu</h3><center><img src="'.$this->asset.'img/loading.gif" class="img-fluid" style="width:200px" id="loading1"></center>';
                    $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
                }
            }else{
                $data['response'] = '<h3>Saldo tidak mencukupi, silahkan isi saldo terlebih dahulu</h3>';
            }
        }else{
            redirect(base_url().'feature-crj-express/pulsa-pasca-bayar');
        }

        $data['title'] = 'Tagihan Gas | CRJExpress';
        $data['asset'] = $this->asset;
        // $data['response'] = 'Top up Pulsa sedang di proses, silahkan tunggu';
        // $data['header']=$this->load->view('templates/header',$data, true);
        $data['content']=$this->load->view('customer/product/pay_postpaid_mobile',$data, true);
        // $data['footer']=$this->load->view('templates/footer',$data, true);
		
        $this->load->view('customer/template/index',$data);
    }
    function tagihan_pdam_pay(){
        if(!$this->session->userdata('IS_LOGIN_PPOB')){
            redirect(base_url().'login');
        }else{
            $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
        }

        if(isset($_POST['pay'])){
            $check_cust = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
            $balance = $check_cust->balance;
            $data['response'] = '<h3>ERROR, Jangan melakukan refresh dan mencoba kembali, Silahkan segera menghubungi customer service</h3>';
            if($balance > $this->input->post('nominal')){
                
                $data_mp = array(
                    'commands'  => 'pay-pasca',
                    'username'  => '081210113977',
                    'tr_id'    => $this->input->post('trx_id'),
                    'sign'      => md5('0812101139773345e28cae81da00334'.$this->input->post('trx_id'))
                );
                
                $curl = curl_init();
    
                curl_setopt_array($curl, array(
                CURLOPT_URL => "https://mobilepulsa.net/api/v1/bill/check",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS =>json_encode($data_mp),
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json"
                ),
                ));
    
                $response = curl_exec($curl);
    
                curl_close($curl);
                $post_mp = json_decode($response);
                // $post_mp = json_decode($this->curl->simple_post('https://testprepaid.mobilepulsa.net/v1/legacy/index', json_encode($data_mp), array(CURLOPT_BUFFERSIZE => 10)));
                if($post_mp->data->message != ''){
                    $data['response'] = '<h3>Pembayaran sedang di proses, silahkan tunggu</h3><center><img src="'.$this->asset.'img/loading.gif" class="img-fluid" style="width:200px" id="loading1"></center>';
                    $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
                }
            }else{
                $data['response'] = '<h3>Saldo tidak mencukupi, silahkan isi saldo terlebih dahulu</h3>';
            }
        }else{
            redirect(base_url().'feature-crj-express/pulsa-pasca-bayar');
        }

        $data['title'] = 'Tagihan PDAM | CRJExpress';
        $data['asset'] = $this->asset;
        // $data['response'] = 'Top up Pulsa sedang di proses, silahkan tunggu';
        // $data['header']=$this->load->view('templates/header',$data, true);
        $data['content']=$this->load->view('customer/product/pay_postpaid_mobile',$data, true);
        // $data['footer']=$this->load->view('templates/footer',$data, true);
		
        $this->load->view('customer/template/index',$data);
    }
    function tagihan_finance_pay(){
        if(!$this->session->userdata('IS_LOGIN_PPOB')){
            redirect(base_url().'login');
        }else{
            $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
        }

        if(isset($_POST['pay'])){
            $check_cust = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
            $balance = $check_cust->balance;
            $data['response'] = '<h3>ERROR, Jangan melakukan refresh dan mencoba kembali, Silahkan segera menghubungi customer service</h3>';
            if($balance > $this->input->post('nominal')){
                
                $data_mp = array(
                    'commands'  => 'pay-pasca',
                    'username'  => '081210113977',
                    'tr_id'     => $this->input->post('trx_id'),
                    'sign'      => md5('0812101139773345e28cae81da00334'.$this->input->post('trx_id'))
                );
                
                $curl = curl_init();
    
                curl_setopt_array($curl, array(
                CURLOPT_URL => "https://mobilepulsa.net/api/v1/bill/check",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS =>json_encode($data_mp),
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json"
                ),
                ));
    
                $response = curl_exec($curl);
    
                curl_close($curl);
                $post_mp = json_decode($response);
                // $post_mp = json_decode($this->curl->simple_post('https://testprepaid.mobilepulsa.net/v1/legacy/index', json_encode($data_mp), array(CURLOPT_BUFFERSIZE => 10)));
                if($post_mp->data->message != ''){
                    $data['response'] = '<h3>Pembayaran sedang di proses, silahkan tunggu</h3><center><img src="'.$this->asset.'img/loading.gif" class="img-fluid" style="width:200px" id="loading1"></center>';
                    $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
                }
            }else{
                $data['response'] = '<h3>Saldo tidak mencukupi, silahkan isi saldo terlebih dahulu</h3>';
            }
        }else{
            redirect(base_url().'feature-crj-express/pulsa-pasca-bayar');
        }

        $data['title'] = 'Tagihan Finance | CRJExpress';
        $data['asset'] = $this->asset;
        // $data['response'] = 'Top up Pulsa sedang di proses, silahkan tunggu';
        // $data['header']=$this->load->view('templates/header',$data, true);
        $data['content']=$this->load->view('customer/product/pay_postpaid_mobile',$data, true);
        // $data['footer']=$this->load->view('templates/footer',$data, true);
		
        $this->load->view('customer/template/index',$data);
    }
    function tagihan_telkom_pay(){
        if(!$this->session->userdata('IS_LOGIN_PPOB')){
            redirect(base_url().'login');
        }else{
            $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
        }

        if(isset($_POST['pay'])){
            $check_cust = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
            $balance = $check_cust->balance;
            $data['response'] = '<h3>ERROR, Jangan melakukan refresh dan mencoba kembali, Silahkan segera menghubungi customer service</h3>';
            if($balance > $this->input->post('nominal')){
                
                $data_mp = array(
                    'commands'  => 'pay-pasca',
                    'username'  => '081210113977',
                    'tr_id'    => $this->input->post('trx_id'),
                    'sign'      => md5('0812101139773345e28cae81da00334'.$this->input->post('trx_id'))
                );
                
                $curl = curl_init();
    
                curl_setopt_array($curl, array(
                CURLOPT_URL => "https://mobilepulsa.net/api/v1/bill/check",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS =>json_encode($data_mp),
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json"
                ),
                ));
    
                $response = curl_exec($curl);
    
                curl_close($curl);
                $post_mp = json_decode($response);
                // $post_mp = json_decode($this->curl->simple_post('https://testprepaid.mobilepulsa.net/v1/legacy/index', json_encode($data_mp), array(CURLOPT_BUFFERSIZE => 10)));
                if($post_mp->data->message != ''){
                    $data['response'] = '<h3>Pembayaran sedang di proses, silahkan tunggu</h3><center><img src="'.$this->asset.'img/loading.gif" class="img-fluid" style="width:200px" id="loading1"></center>';
                    $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
                }
            }else{
                $data['response'] = '<h3>Saldo tidak mencukupi, silahkan isi saldo terlebih dahulu</h3>';
            }
        }else{
            redirect(base_url().'feature-crj-express/pulsa-pasca-bayar');
        }

        $data['title'] = 'Tagihan Telkom PSTN | CRJExpress';
        $data['asset'] = $this->asset;
        // $data['response'] = 'Top up Pulsa sedang di proses, silahkan tunggu';
        // $data['header']=$this->load->view('templates/header',$data, true);
        $data['content']=$this->load->view('customer/product/pay_postpaid_mobile',$data, true);
        // $data['footer']=$this->load->view('templates/footer',$data, true);
		
        $this->load->view('customer/template/index',$data);
    }
    
    function pay_postpaid_mobile(){
        if(!$this->session->userdata('IS_LOGIN_PPOB')){
            redirect(base_url().'login');
        }else{
            $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
        }

        if(isset($_POST['pay'])){
            $check_cust = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
            $balance = $check_cust->balance;
            $data['response'] = '<h3>ERROR, Jangan melakukan refresh dan mencoba kembali, Silahkan segera menghubungi customer service</h3>';
            if($balance > $this->input->post('nominal')){
                
                $data_mp = array(
                    'commands'  => 'pay-pasca',
                    'username'  => '081210113977',
                    'tr_id'    => $this->input->post('trx_id'),
                    'sign'      => md5('0812101139773345e28cae81da00334'.$this->input->post('trx_id'))
                );
                
                $curl = curl_init();
    
                curl_setopt_array($curl, array(
                CURLOPT_URL => "https://mobilepulsa.net/api/v1/bill/check",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS =>json_encode($data_mp),
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json"
                ),
                ));
    
                $response = curl_exec($curl);
    
                curl_close($curl);
                $post_mp = json_decode($response);
                // $post_mp = json_decode($this->curl->simple_post('https://testprepaid.mobilepulsa.net/v1/legacy/index', json_encode($data_mp), array(CURLOPT_BUFFERSIZE => 10)));
                if($post_mp->data->message != ''){
                    $data['response'] = '<h3>Pembayaran sedang di proses, silahkan tunggu</h3><center><img src="'.$this->asset.'img/loading.gif" class="img-fluid" style="width:200px" id="loading1"></center>';
                    $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
                }
            }else{
                $data['response'] = '<h3>Saldo tidak mencukupi, silahkan isi saldo terlebih dahulu</h3>';
            }
        }else{
            redirect(base_url().'feature-crj-express/pulsa-pasca-bayar');
        }

        $data['title'] = 'Pulsa Pasca Bayar | CRJExpress';
        $data['asset'] = $this->asset;
        // $data['response'] = 'Top up Pulsa sedang di proses, silahkan tunggu';
        // $data['header']=$this->load->view('templates/header',$data, true);
        $data['content']=$this->load->view('customer/product/pay_postpaid_mobile',$data, true);
        // $data['footer']=$this->load->view('templates/footer',$data, true);
		
        $this->load->view('customer/template/index',$data);
    }
    function notify(){
        $data = $_POST['data'];
        $json = file_get_contents('php://input');
        $tempArray = json_decode($json);
        array_push($tempArray, $data);
        $jsonData = json_encode($tempArray);
        file_put_contents('a.json', $jsonData);
        // $a = array(
        //     'ref_id'=>'10',
        //     'message'=>'SUCCESS'
        // );
        // $json = array();
        // array_push($json, array('data'=>$a));
        // $json = json_encode($json);
        // $datas = json_decode($jsonData);
        $json = file_get_contents('a.json');
        $tempArray = json_decode($json, true);
        
        $data_transaction = array(
            'id_ppob_transaction'   => $tempArray['data']['ref_id'],
            'status'                => $tempArray['data']['message'],
            'rc'                    => $tempArray['data']['rc']
        );
        // file_put_contents('a.json', $jsonData);
        
        $update =  $this->curl->simple_put($this->API.'ppob_transaction', $data_transaction, array(CURLOPT_BUFFERSIZE => 10));
        
    }
    function success(){
        $data['title'] = 'Transaction Success | CRJExpress';
        $data['asset'] = $this->asset;
        $data['cust'] = json_decode($this->curl->simple_get($this->API.'ppob_customer?id='.$this->session->userdata('SESS_DATA')['cust_id']))->result[0];
        $data['content']=$this->load->view('customer/product/topup_pulsa_success',$data, true);
        
        // $data['footer']=$this->load->view('templates/footer',$data, true);
		
        $this->load->view('customer/template/index',$data);
    }

}