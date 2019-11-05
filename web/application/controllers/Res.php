<?php

class Res
{

    private $API = '';
    private $SERVER = 'DEVELOPMENT';

    public function getApi()
    {
        if($this->SERVER == 'DEVELOPMENT'):
            $this->API = 'http://localhost/project/development/ekspedisimore/api/';
        elseif($this->SERVER == 'PRODUCTION'):
            $this->API = 'http://localhost/project/development/ekspedisimore/api/';
        else:
            $this->API = 'http://localhost/project/development/ekspedisimore/api/';
        endif;

        return $this->API;
    }
}