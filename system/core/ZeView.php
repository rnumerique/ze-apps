<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class ZeView
{

  function getView($viewTemplate, $arrData = array(), $outputView = true)
  {
    // send data to template file
    foreach ($arrData as $key => $value) {
      $$key = $value ;
    }

    if (is_file($viewTemplate)) {

      ob_start();
      include($viewTemplate);


      // Return the file data if requested
  		if ($outputView !== true)
  		{
  			$buffer = ob_get_contents();
  			@ob_end_clean();
  			return $buffer;
  		}

      ob_end_flush();
    }
  }
}
