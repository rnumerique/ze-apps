<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ZeSession
{
    public function __construct() {
        session_start();
    }

    public function get($variable, $defaultValue = null) {
        if (isset($_SESSION[$variable])) {
            return $_SESSION[$variable] ;
        } else {
            return $defaultValue ;
        }
    }

    public function set($variable, $value) {
        $_SESSION[$variable] = $value ;
    }

    public function clear($variable = null) {
        if ($variable) {
            unset($_SESSION[$variable]);
        } else {
            session_unset() ;
        }
    }
}
