<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Directives extends ZeCtrl
{
    public function zefilter()
    {
        $this->load->view('directives/zefilter');
    }

    public function zepostits()
    {
        $this->load->view('directives/zepostits');
    }

    public function search_modal()
    {
        $this->load->view('directives/search_modal');
    }
}
