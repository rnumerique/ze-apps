<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ZeRouteur {
  public $routes = array();
  public $module = "zeapps" ;
  public $controller = "auth" ;
  public $function = "index" ;
  public $params = array() ;

  public function __construct($routing = NULL)
	{
    $uri = isset($_SERVER['REQUEST_URI']) ? urldecode($_SERVER['REQUEST_URI']) : '' ;
    $uriArray = explode("/", $uri) ;

    if (isset($uriArray[1]) && trim($uriArray[1]) != '') $this->module = $uriArray[1] ;
    if (isset($uriArray[2]) && trim($uriArray[2]) != '') $this->controller = $uriArray[2] ;
    if (isset($uriArray[3]) && trim($uriArray[3]) != '') $this->function = $uriArray[3] ;

    if (isset($uriArray[4])) {
      for ($i = 4 ; $i < count($uriArray) ; $i++) {
        $this->params[] = $uriArray[$i] ;
      }
    }
  }
}

?>
