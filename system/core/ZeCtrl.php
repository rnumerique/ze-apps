<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class ZeCtrl
{
    public $load = null;
    public $input = null;
    public $session = null;
    private $_modulePath = null;
    private $_controllerPath = null;

    public function __construct()
    {
        $class_info = new ReflectionClass($this);
        $this->_controllerPath = $class_info->getFileName();
        $this->_modulePath = dirname(dirname($this->_controllerPath));

        // load object : load
        $this->load();

        // load object : session
        $this->session = new ZeSession();


        // load object : input
        $this->input = new ZeInput();

        // load autload
        if (is_file($this->_modulePath . "/config/autoload.php")) {
            $autoload = array() ;
            require_once $this->_modulePath . "/config/autoload.php" ;

            if (isset($autoload['model']) && is_array($autoload['model'])) {
                foreach ($autoload['model'] as $key => $value) {
                    if (is_numeric($key)) {
                        $this->load->model($value);
                    } else {
                        $this->load->model($key, $value);
                    }
                }
            }


            if (isset($autoload['libraries']) && is_array($autoload['libraries'])) {
                foreach ($autoload['libraries'] as $key => $value) {
                    if (is_numeric($key)) {
                        $this->load->library($value);
                    } else {
                        $this->load->library($key, $value);
                    }
                }
            }

            if (isset($autoload['helper']) && is_array($autoload['helper'])) {
                foreach ($autoload['helper'] as $value) {
                    $this->load->helper($value);
                }
            }
        }
  }


    private function load()
    {
        if ($this->load == null) {
            $this->load = new ZeLoad();
            $this->load->setCtrl($this);
        }

        $context = array();
        $context['controllerPath'] = $this->_controllerPath;
        $context['modulePath'] = $this->_modulePath;
        $this->load->setContext($context);
    }
}
