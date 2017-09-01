<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Country extends ZeCtrl
{
    public function get_all()
    {
        $this->load->model("Zeapps_country", "country");

        if(!$countries = $this->country->all()){
            $countries = [];
        }

        echo json_encode(array(
            "countries" => $countries
        ));
    }
    public function modal($limit = 15, $offset = 0)
    {
        $this->load->model("Zeapps_country", "country");

        $filters = array() ;

        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') === 0 && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== FALSE) {
            // POST is actually in json format, do an internal translation
            $filters = json_decode(file_get_contents('php://input'), true);
        }

        $total = $this->country->count($filters);

        if(!$countries = $this->country->all($filters, $limit, $offset)){
            $countries = [];
        }

        echo json_encode(array(
            "data" => $countries,
            "total" => $total
        ));
    }
}
