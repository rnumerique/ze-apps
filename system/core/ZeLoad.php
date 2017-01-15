<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ZeLoad
{
  private $_context = array() ;
  private $_loadedModel = array() ;
  private $_ctrl = null ;
  public $ctrl = null ;
  private $modelLoaded = array() ;

  public function setCtrl($ctrl) {
    $this->_ctrl = & $ctrl ;
    $this->ctrl = $this->_ctrl ;
  }


  public function setContext($context) {
    $this->_context = $context ;
  }





  public function view($viewTemplate, $arrData = array(), $outputView = true) {
    // search view in modulePath
    if (isset($this->_context["modulePath"]) && $this->_context["modulePath"] != '') {
      if (is_file($this->_context["modulePath"] . '/views/' . $viewTemplate . ".php")) {
        $view = new ZeView();
        return $view->getView($this->_context["modulePath"] . '/views/' . $viewTemplate . ".php", $arrData, $outputView);
      }
    }

    // search view in globalPath
    if (is_file(BASEPATH . 'views/' . $viewTemplate . ".php")) {
      $view = new ZeView();
      return $view->getView(BASEPATH . 'views/' . $viewTemplate . ".php", $arrData, $outputView);
    }
  }







  public function model($className, $shortName = '') {
    if (trim($shortName) == "") {
      $shortName = $className ;
    }

    if (!isset($this->_ctrl->$shortName)) {
      // search model in modulePath
      if (isset($this->_context["modulePath"]) && $this->_context["modulePath"] != '') {
        if (is_file($this->_context["modulePath"] . '/models/' . $className . '.php')) {
          if (!in_array($this->_context["modulePath"] . '/models/' . $className . '.php', $this->modelLoaded)) {
            $this->modelLoaded[] = $this->_context["modulePath"] . '/models/' . $className . '.php' ;
            include $this->_context["modulePath"] . '/models/' . $className . '.php';
          }
          $className::$load = &$this ;
          $this->_ctrl->$shortName = new $className();
          return ;
        }
      }

      // search view in globalPath
      if (is_file(BASEPATH . 'models/' . $className . '.php')) {
        if (!in_array(BASEPATH . 'models/' . $className . '.php', $this->modelLoaded)) {
          $this->modelLoaded[] = BASEPATH . 'models/' . $className . '.php' ;
          include BASEPATH . 'models/' . $className . '.php';
        }
        $className::$load = &$this ;
        $this->_ctrl->$shortName = new $className();
        return ;
      }
    }
  }
}
