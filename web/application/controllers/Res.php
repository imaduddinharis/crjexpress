<?php

class Res
{

    private $API = '';
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
}