<?php

namespace Controllers;

Class PontoTuristico {

	public static function itemInfoPage($id_item) {
		$turismoModel = new \Models\PontoTuristico();

		$ponto = $turismoModel->itemPageInfo($id_item);

		$gps = $ponto['item']['gps'];

		$map = array(
			"gps" => $gps,
			"points" => $turismoModel->convertIntoMapPoints(array($ponto['item'])),
		);

		$data = array(
			"item" => $ponto['item'],
			"breadcrumbs" => $ponto['breadcrumbs'],
			"sidebar" => $ponto['sidebar'],
			"map" => $map,
		);

		view('turismo/ponto', $data);
	}

	public static function mainPage() {
		$turismoModel = new \Models\PontoTuristico();
		$distritoModel = new \Models\Distrito();

		$search = array("limit" => 12, "order" => 'rand');

		if (exists($_REQUEST['id_tipo'])) {
			$search['id_tipo'] = $_REQUEST['id_tipo'];
		}

		$data = array(
			"breadcrumbs" => $turismoModel->breadcrumbs(),
			"types" => $turismoModel->getItemTypes(),
			"distritos" => $distritoModel->itemsBasicInfo(),
			"items" => $turismoModel->getItemsList($search),
		);

		view('turismo/main', $data);
	}

	public static function searchResultsPage() {
		$form = new \Form();

		$isValid = $form->validate('tourism_search', array(
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

		$turismoModel = new \Models\PontoTuristico();
		$distritoModel = new \Models\Distrito();

		$data = array(
			"breadcrumbs" => $turismoModel->breadcrumbs(),
			"types" => $turismoModel->getItemTypes(),
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

			$data['items'] = $turismoModel->getItemsList($search);
		}

		view('turismo/search_results', $data);
	}

}