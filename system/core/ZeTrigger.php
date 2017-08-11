<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ZeTrigger
{
    public $load = null;
    private $trigger = '';
    private $modules = array();
    private $_modulePath = null;
    private $_controllerPath = null;

    public function __construct()
    {
        $class_info = new ReflectionClass($this);
        $this->_controllerPath = $class_info->getFileName();
        $this->_modulePath = dirname(dirname($this->_controllerPath));

        $this->load();
    }

    public function set($trigger = null)
    {
        $this->load->model('Zeapps_triggers', 'triggers');

        $this->trigger = '';
        $this->modules = array();

        if($trigger){
            $this->trigger = $trigger;
            $this->modules = $this->triggers->all(array('label' => $trigger));
        }
    }

    public function execute($data = array()){
        $return = [];

        foreach($this->modules as $module){
            $class = $module->module . '_' . $this->trigger;
            if(file_exists(MODULEPATH . $module->module . '/triggers/' . $class . '.php')){
                require_once MODULEPATH . $module->module . '/triggers/' . $class . '.php';


                $trigger = new $class();

                $return[$module->module] = $trigger->execute($data);
            }
        }

        return $return;
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