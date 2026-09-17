<?php

namespace Controllers;

Class Policia {

	public static function itemInfoPage($id_item) {
		$policiaModel = new \Models\Policia();
		
		$policia = $policiaModel->precintsPageInfo($id_item);

		$gps = $policia['esquadra']['gps'];

		$map = array(
			"gps" => $gps,
			"points" => $policiaModel->convertIntoMapPoints(array($policia['esquadra'])),
		);

		$data = array(
			"esquadra" => $policia['esquadra'],
			"breadcrumbs" => $policia['breadcrumbs'],
			"sidebar" => $policia['sidebar'],
			"map" => $map,
		);

		view('policia/esquadra', $data);
	}

	public static function mainPage() {
		$policiaModel = new \Models\Policia();
		$distritoModel = new \Models\Distrito();

		$search = array("limit" => 12, "order" => 'rand');

		$data = array(
			"breadcrumbs" => $policiaModel->breadcrumbs(),
			"distritos" => $distritoModel->itemsBasicInfo(),
			"items" => $policiaModel->getPrecintsList($search),
		);

		view('policia/main', $data);
	}

	public static function searchResultsPage() {
		$form = new \Form();

		$isValid = $form->validate('police_search', array(
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

		$policiaModel = new \Models\Policia();
		$distritoModel = new \Models\Distrito();

		$data = array(
			"breadcrumbs" => $policiaModel->breadcrumbs(),
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

			$data['items'] = $policiaModel->getPrecintsList($search);
		}

		view('policia/search_results', $data);
	}

}