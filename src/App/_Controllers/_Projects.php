<?php

namespace Controllers;

Class Projects {
	
	public static function list() {
		$data = array();

		if(!\Cache\Page::getData($data)) {

	    	$pagesModel = new \Models\Pages();
			$projectsModel = new \Models\Projects();

			$pageItemLimit = 8;
			$page = !empty($_REQUEST['page']) ? (int) $_REQUEST['page'] : 1;
			$offset = \Pagination::getOffset($pageItemLimit, $page);

			$data = array(
				"seo" => $pagesModel->item_seo(10),
				"projects" => array(
					"page" => $pagesModel->item(10),
					"items" => $projectsModel->itemsList(0, null, $pageItemLimit, $offset, false),
					"pagination" => array(
						"current" => $page,
						"last" => \Pagination::lastPage($projectsModel->itemTotalCount(0, null), $pageItemLimit),
					),
				),
				"contacts" => array(
					"page" => $pagesModel->item(7),
				),
			);

			\Cache\Page::storeData($data);
	    }

		view('projects', $data);
	}

	public static function page($id) {
		$data = array();

		if(!\Cache\Page::getData($data)) {
	    	$pagesModel = new \Models\Pages();
			$projectsModel = new \Models\Projects();

			$project = $projectsModel->item($id);

			if (!exists($project)) {
				Error::pageNotFound();
				return false;
			}

			$data = array(
				"seo" => $projectsModel->item_seo($id),
				"project" => array(
					"info" => $project,
					"images" => $projectsModel->images($id),
					"details" => $projectsModel->features($id),
				),
				"related" => $projectsModel->itemsList(0, array($id), 3, 0, true),
				"contacts" => array(
					"page" => $pagesModel->item(7),
				),
			);

			\Cache\Page::storeData($data);
	    }

	    view('project', $data);   
	}

}