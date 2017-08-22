<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class State extends ZeCtrl
{
    public function modal($limit = 15, $offset = 0)
    {
        $this->load->model("Zeapps_state", "state");

        $filters = array() ;

        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') === 0 && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== FALSE) {
            // POST is actually in json format, do an internal translation
            $filters = json_decode(file_get_contents('php://input'), true);
        }

        $total = $this->state->count($filters);

        if(!$states = $this->state->limit($limit, $offset)->all($filters)){
            $states = [];
        }

        echo json_encode(array("data" => $states, "total" => $total));
    }
}
