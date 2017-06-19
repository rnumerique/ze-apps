<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class ZeHook
{
    public $load = null;
    public $input = null;
    public $session = null;
    private $_modulePath = null;
    private $_controllerPath = null;

    public function __construct()
    {
        $classInfo = new ReflectionClass($this);
        $this->_controllerPath = $classInfo->getFileName();
        $this->_modulePath = dirname(dirname($this->_controllerPath));

        // load object : load
        $this->load();

        // load object : session
        $this->session = new ZeSession();


        // load object : input
        $this->input = new ZeInput();
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