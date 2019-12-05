<?php

class Res
{

    private $API = '';
    private $APIKey = '';
    private $SERVER = 'HOSTING';

    public function getApi()
    {
        if($this->SERVER == 'LOCAL'):
            $this->API = 'http://localhost:9000/';
        elseif($this->SERVER == 'HOSTING'):
            $this->API = 'https://api.crjexpress.id/';
        else:
            $this->API = 'http://localhost:9000/';
        endif;

        return $this->API;
    }

    public function getApiKey()
    {
        $this->APIKey = 'c4ca4238a0b923820dcc509a6f75849b';
        return $this->APIKey;
    }
}