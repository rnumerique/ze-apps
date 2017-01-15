<?php

class Zeapps_notification extends MY_Model
{


    public function __construct()
    {
        parent::__construct();

        $this->soft_deletes = TRUE;
    }
}
