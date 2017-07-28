<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Directives extends ZeCtrl
{
    public function zefilter()
    {
        $this->load->view('directives/zefilter');
    }
}
