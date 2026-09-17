<?php

namespace Controllers;

Class Saude {

	public static function unitInfoPage($id_escola) {
		$saudeModel = new \Models\Saude();

		$unit = $saudeModel->healthCareUnitsPageInfo($id_escola);

		$gps = $unit['unidade']['gps'];

		$map = array(
			"gps" => $gps,
			"points" => $saudeModel->convertIntoMapPoints(array($unit['unidade'])),
		);

		$data = array(
			"unidade" => $unit['unidade'],
			"breadcrumbs" => $unit['breadcrumbs'],
			"sidebar" => $unit['sidebar'],
			"map" => $map,
		);

		view('saude/unidade', $data);
	}

	public static function groupingInfoPage($id_agrupamento) {
		$saudeModel = new \Models\Saude();

		$agrupamento = $saudeModel->schoolHealthCareGroupingsPageInfo($id_agrupamento);
		
		$gps = $agrupamento['agrupamento']['gps'];

		$map = array(
			"gps" => $gps,
			"points" => $saudeModel->convertIntoMapPoints($agrupamento['agrupamento']['units']['items']),
		);

		$data = array(
			"agrupamento" => $agrupamento['agrupamento'],
			"breadcrumbs" => $agrupamento['breadcrumbs'],
			"sidebar" => $agrupamento['sidebar'],
			"map" => $map,
		);

		view('saude/agrupamento', $data);
	}

	public static function mainPage() {
		$saudeModel = new \Models\Saude();
		$distritoModel = new \Models\Distrito();

		$search = array("limit" => 12, "order" => 'rand');

		if (exists($_REQUEST['id_tipo'])) {
			$search['id_tipo'] = $_REQUEST['id_tipo'];
		}

		$data = array(
			"breadcrumbs" => $saudeModel->breadcrumbs(),
			"types" => $saudeModel->getItemTypes(),
			"distritos" => $distritoModel->itemsBasicInfo(),
			"items" => $saudeModel->getHealthCareUnitsList($search),
		);

		view('saude/main', $data);
	}

	public static function searchResultsPage() {
		$form = new \Form();

		$isValid = $form->validate('healthcare_search', array(
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
			"id_tipo" => array(
				'alias' => \Lang\Dictionary::get('tourism_point_types'),
				"rules" => ['int'],
			),
		));

		$saudeModel = new \Models\Saude();
		$distritoModel = new \Models\Distrito();

		$data = array(
			"breadcrumbs" => $saudeModel->breadcrumbs(),
			"types" => $saudeModel->getItemTypes(),
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
			if (exists($_REQUEST['id_tipo'])) {
				$search['id_tipo'] = $_REQUEST['id_tipo'];
			}

			$data['items'] = $saudeModel->getHealthCareUnitsList($search);
		}

		view('saude/search_results', $data);
	}

}