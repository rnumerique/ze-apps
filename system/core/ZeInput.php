<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ZeInput
{
    public function post($variable) {
        if (isset($_POST[$variable])) {
            return $_POST[$variable] ;
        } else {
            return '' ;
        }
    }

    public function get($variable) {
        if (isset($_GET[$variable])) {
            return $_GET[$variable] ;
        } else {
            return '' ;
        }
    }
}
