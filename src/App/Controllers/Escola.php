<?php

namespace Controllers;

Class Escola {

	public static function schoolInfoPage($id_escola) {
		$escolaModel = new \Models\Escola();

		$escola = $escolaModel->schoolsPageInfo($id_escola);

		$gps = $escola['escola']['gps'];

		$map = array(
			"gps" => $gps,
			"points" => $escolaModel->convertIntoMapPoints(array($escola['escola'])),
		);

		$data = array(
			"escola" => $escola['escola'],
			"breadcrumbs" => $escola['breadcrumbs'],
			"sidebar" => $escola['sidebar'],
			"map" => $map,
		);

		view('escola/escola', $data);
	}

	public static function groupingInfoPage($id_agrupamento) {
		$escolaModel = new \Models\Escola();

		$agrupamento = $escolaModel->schoolGroupingsPageInfo($id_agrupamento);

		$gps = $agrupamento['agrupamento']['gps'];

		$map = array(
			"gps" => $gps,
			"points" => $escolaModel->convertIntoMapPoints($agrupamento['agrupamento']['schools']['items']),
		);

		$data = array(
			"agrupamento" => $agrupamento['agrupamento'],
			"breadcrumbs" => $agrupamento['breadcrumbs'],
			"sidebar" => $agrupamento['sidebar'],
			"map" => $map,
		);

		view('escola/agrupamento', $data);
	}

	public static function mainPage() {
		$escolaModel = new \Models\Escola();
		$distritoModel = new \Models\Distrito();

		$search = array("limit" => 12, "order" => 'rand');

		if (exists($_REQUEST['id_ciclo'])) {
			$search['cycles'][]['id'] = $_REQUEST['id_ciclo'];
		}

		$data = array(
			"breadcrumbs" => $escolaModel->breadcrumbs(),
			"distritos" => $distritoModel->itemsBasicInfo(),
			"cycles" => $escolaModel->getSchoolCycles2School(),
			"items" => $escolaModel->getSchoolsList($search),
		);

		view('escola/main', $data);
	}

	public static function searchResultsPage() {
		$form = new \Form();

		$isValid = $form->validate('school_search', array(
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
			"id_ciclo" => array(
				'alias' => \Lang\Dictionary::get('school_cycles'),
				"rules" => ['int'],
			),
		));

		$escolaModel = new \Models\Escola();
		$distritoModel = new \Models\Distrito();

		$data = array(
			"breadcrumbs" => $escolaModel->breadcrumbs(),
			"distritos" => $distritoModel->itemsBasicInfo(),
			"cycles" => $escolaModel->getSchoolCycles2School(),
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
			if (exists($_REQUEST['id_ciclo'])) {
				$search['cycles'][]['id'] = $_REQUEST['id_ciclo'];
			}

			$data['items'] = $escolaModel->getSchoolsList($search);
		}

		view('escola/search_results', $data);
	}

}