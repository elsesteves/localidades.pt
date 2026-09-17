<?php

namespace Controllers;

Class Bombeiro {

	public static function itemInfoPage($id_item) {
		$bombeiroModel = new \Models\Bombeiro();

		$bombeiro = $bombeiroModel->stationsPageInfo($id_item);

		$gps = $bombeiro['item']['gps'];

		$map = array(
			"gps" => $gps,
			"points" => $bombeiroModel->convertIntoMapPoints(array($bombeiro['item'])),
		);

		$data = array(
			"item" => $bombeiro['item'],
			"breadcrumbs" => $bombeiro['breadcrumbs'],
			"sidebar" => $bombeiro['sidebar'],
			"map" => $map,
		);

		view('bombeiro/quartel', $data);
	}

	public static function mainPage() {
		$bombeiroModel = new \Models\Bombeiro();
		$distritoModel = new \Models\Distrito();

		$search = array("limit" => 12, "order" => 'rand');

		$data = array(
			"breadcrumbs" => $bombeiroModel->breadcrumbs(),
			"distritos" => $distritoModel->itemsBasicInfo(),
			"items" => $bombeiroModel->getStationsList($search),
		);

		view('bombeiro/main', $data);
	}

	public static function searchResultsPage() {
		$form = new \Form();

		$isValid = $form->validate('firefighters_search', array(
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

		$bombeiroModel = new \Models\Bombeiro();
		$distritoModel = new \Models\Distrito();

		$data = array(
			"breadcrumbs" => $bombeiroModel->breadcrumbs(),
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

			$data['items'] = $bombeiroModel->getStationsList($search);
		}

		view('bombeiro/search_results', $data);
	}

}