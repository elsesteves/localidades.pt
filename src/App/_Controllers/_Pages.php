<?php

namespace Controllers;

Class Pages {
	
	public static function page($id) {
		$data = array();

		if(!\Cache\Page::getData($data)) {
			$pagesModel = new \Models\Pages();
			$page = $pagesModel->item($id);

			if (!exists($page)) {
				Error::pageNotFound();
				return false;
			}

			$data = array(
			  "info" => array(
			    "page" => $page,
			  ),
			  "contacts" => array(
		        "page" => $pagesModel->item(7),
		      ),
			);

			\Cache\Page::storeData($data);
		}		

		view('page', $data);
	}
}