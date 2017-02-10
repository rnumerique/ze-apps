<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hooks extends ZeCtrl
{
    public function get_all()
    {
        $this->load->model("Zeapps_hooks", "hooks");

        $hooks = $this->hooks->all();

        echo json_encode($hooks);
    }
}