<?php

namespace Controllers;

Class Error {
  
  public static function pageNotFound() {
    $pagesModel = new \Models\Pages();
    view('404', array(
      "error" => array(
        "page" => $pagesModel->item(12),
      ),      
    ), false, 404);
  }

  public static function apiMethodNotFound() {
  	json_return(array(
  		"status" => array(
  			"code" => 404,
  			"description" => 'Method Not Found',
  		),
  	), 404);
  }
  
}