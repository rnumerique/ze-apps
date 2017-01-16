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







  public function model($className, $shortName = '', $externalModule = null) {
    if (trim($shortName) == "") {
      $shortName = $className ;
    }

    // TODO : gestion des erreurs de chargement de module (chemin inconnu et class non définie)
    

    if ($externalModule) {
      // search model in modulePath
      if (gettype($externalModule, 'string')) {
        if (is_file($externalModule . '/models/' . $className . '.php')) {
          if (!in_array($externalModule . '/models/' . $className . '.php', $this->modelLoaded)) {
            $this->modelLoaded[] = $externalModule . '/models/' . $className . '.php' ;
            include $externalModule . '/models/' . $className . '.php';
          }
          $className::$load = &$this ;
          $this->_ctrl->$shortName = new $className();
          return ;
        }
    } else {
      // search in current
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
}
