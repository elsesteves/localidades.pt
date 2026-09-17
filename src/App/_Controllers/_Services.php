<?php

namespace Controllers;

Class Services {

	public static function page() {
		$data = array();

		if(!\Cache\Page::getData($data)) {
			$pagesModel = new \Models\Pages();
	    	$servicesModel = new \Models\Services();

			$data = array(
				"seo" => $pagesModel->item_seo(11),
				"services" => array(
					"page" => $pagesModel->item(11),
					"items" => $servicesModel->items(0),
				),
				"contacts" => array(
					"page" => $pagesModel->item(7),
				),
			);

			\Cache\Page::storeData($data);
		}

		view('services', $data);
	}

}