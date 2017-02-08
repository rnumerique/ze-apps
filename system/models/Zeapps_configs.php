<?php

class Zeapps_configs extends MY_Model
{


    public function __construct()
    {
        parent::__construct();

        $this->soft_deletes = TRUE;
    }
}