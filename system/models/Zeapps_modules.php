<?php

class Zeapps_modules extends MY_Model
{


    public function __construct()
    {
        parent::__construct();

        $this->soft_deletes = TRUE;
    }
}