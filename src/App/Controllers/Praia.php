<?php

namespace Controllers;

Class Praia {

	public static function itemInfoPage($id_item) {
		$praiaModel = new \Models\Praia();

		$praia = $praiaModel->itemPageInfo($id_item);

		$gps = $praia['item']['gps'];

		$map = array(
			"gps" => $gps,
			"points" => $praiaModel->convertIntoMapPoints(array($praia['item'])),
		);

		$data = array(
			"item" => $praia['item'],
			"breadcrumbs" => $praia['breadcrumbs'],
			"sidebar" => $praia['sidebar'],
			"map" => $map,
		);

		view('praia/praia', $data);
	}


	public static function mainPage() {
		$praiaModel = new \Models\Praia();
		$distritoModel = new \Models\Distrito();

		$search = array("limit" => 12, "order" => 'rand');

		$data = array(
			"breadcrumbs" => $praiaModel->breadcrumbs(),
			"distritos" => $distritoModel->itemsBasicInfo(),
			"items" => $praiaModel->getItemsList($search),
		);

		view('praia/main', $data);
	}

	public static function searchResultsPage() {
		$form = new \Form();

		$isValid = $form->validate('beaches_search', array(
			"id_distrito" => array(
				'alias' => \Lang\Dictionary::get('district'),
				"rules" => ['int'],
			),
			"id_concelho" => array(
				'alias' => \Lang\Dictionary::get('municipality'),
				"rules" => ['int'],
			),
			"id_freguesia" => array(
				'alias' => \Lang\Dictionary::get('parish'),
				"rules" => ['int'],
			),
		));

		$praiaModel = new \Models\Praia();
		$distritoModel = new \Models\Distrito();

		$data = array(
			"breadcrumbs" => $praiaModel->breadcrumbs(),
			"distritos" => $distritoModel->itemsBasicInfo(),
		);

		if ($isValid) {
			$search = array();
			if (exists($_REQUEST['id_distrito'])) {
				$search['id_distrito'] = $_REQUEST['id_distrito'];
			}
			if (exists($_REQUEST['id_concelho'])) {
				$search['id_concelho'] = $_REQUEST['id_concelho'];
			}
			if (exists($_REQUEST['id_freguesia'])) {
				$search['id_freguesia'] = $_REQUEST['id_freguesia'];
			}

			$data['items'] = $praiaModel->getItemsList($search);
		}

		view('praia/search_results', $data);
	}
}