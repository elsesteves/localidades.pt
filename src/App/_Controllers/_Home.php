<?php

namespace Controllers;

Class Home {
  
  public static function home() {
    $data = array();

    if(!\Cache\Page::getData($data)) {
      $sliderModel = new \Models\Slider();
      $pagesModel = new \Models\Pages();
      $projectsModel = new \Models\Projects();
      $servicesModel = new \Models\Services();
      $blogModel = new \Models\Blog();

      $data = array( 
        "slider"  => $sliderModel->item(0),      
        "about_us" => array(
          "page" => $pagesModel->item(9),
        ),
        "projects" => array(
          "page" => $pagesModel->item(10),
          "items" => $projectsModel->itemsList(0, null, 6),
        ),
        "services" => array(
          "page" => $pagesModel->item(11),
          "items" => $servicesModel->items(0, array(
            //"limit" => 3, 
          )),
        ),
        "blog" => array(
          "items" => $blogModel->list(null, array(
            "limit" => 6,
          )),
        ),
        "contacts" => array(
          "page" => $pagesModel->item(7),
        ),
      );

      \Cache\Page::storeData($data);
    }   

    view('homepage', $data); 
  }

}