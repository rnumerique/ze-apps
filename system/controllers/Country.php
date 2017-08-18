<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Country extends ZeCtrl
{
    public function modal($limit = 15, $offset = 0)
    {
        $this->load->model("Zeapps_country", "country");

        $total = $this->country->count();

        if(!$countries = $this->country->all(array(), $limit, $offset)){
            $countries = [];
        }

        echo json_encode(array("data" => $countries, "total" => $total));
    }
}
