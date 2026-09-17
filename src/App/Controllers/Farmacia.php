<?php

namespace Controllers;

Class Farmacia {

	public static function itemInfoPage($id_item) {
		$farmaciaModel = new \Models\Farmacia();

		$farmacia = $farmaciaModel->pharmaciesPageInfo($id_item);

		$gps = $farmacia['farmacia']['gps'];

		$map = array(
			"gps" => $gps,
			"points" => $farmaciaModel->convertIntoMapPoints(array($farmacia['farmacia'])),
		);

		$data = array(
			"farmacia" => $farmacia['farmacia'],
			"breadcrumbs" => $farmacia['breadcrumbs'],
			"sidebar" => $farmacia['sidebar'],
			"map" => $map,
		);

		view('farmacia/farmacia', $data);
	}

	public static function mainPage() {
		$farmaciaModel = new \Models\Farmacia();
		$distritoModel = new \Models\Distrito();

		$search = array("limit" => 12, "order" => 'rand');

		$data = array(
			"breadcrumbs" => $farmaciaModel->breadcrumbs(),
			"distritos" => $distritoModel->itemsBasicInfo(),
			"items" => $farmaciaModel->getPharmaciesList($search),
		);

		view('farmacia/main', $data);
	}

	public static function searchResultsPage() {
		$form = new \Form();

		$isValid = $form->validate('pharmacies_search', array(
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

		$farmaciaModel = new \Models\Farmacia();
		$distritoModel = new \Models\Distrito();

		$data = array(
			"breadcrumbs" => $farmaciaModel->breadcrumbs(),
			"distritos" => $distritoModel->itemsBasicInfo()
		);

		if(exists($_REQUEST['id_distrito'])) {
			$concelhoModel = new \Models\Concelho();
			$data['concelhos'] = $concelhoModel->itemsBasicInfo(array("parent" => $_REQUEST['id_distrito']));
		}

		if(exists($_REQUEST['id_concelho'])) {
			$freguesiaModel = new \Models\Freguesia();
			$data['freguesias'] = $freguesiaModel->itemsBasicInfo(array("parent" => $_REQUEST['id_concelho']));
		}

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

			$data['items'] = $farmaciaModel->getPharmaciesList($search);
		}

		view('farmacia/search_results', $data);
	}

}