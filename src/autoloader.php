<?php

if(!function_exists("autoLoader")) {

  function autoLoader($className) {
    $className = str_replace('\\', '/', $className);

    $sources = array(
      __DIR__."/App/".$className.".php",
      __DIR__."/Core/".$className.".php",
    );

    foreach($sources as $source) {
      if (file_exists($source)) {
        require_once $source;
      }
    }
  }

}

spl_autoload_register('autoLoader');
