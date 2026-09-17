<?php

namespace Controllers;

Class Evento {

	public static function itemInfoPage($id_item) {
		$eventoModel = new \Models\Evento();

		$ponto = $eventoModel->itemPageInfo($id_item);

		$gps = $ponto['item']['gps'];

		$map = array(
			"gps" => $gps,
			"points" => $eventoModel->convertIntoMapPoints(array($ponto['item'])),
		);

		$data = array(
			"item" => $ponto['item'],
			"breadcrumbs" => $ponto['breadcrumbs'],
			"sidebar" => $ponto['sidebar'],
			"map" => $map,
		);

		view('evento/evento', $data);
	}

	public static function mainPage() {
		$eventoModel = new \Models\Evento();
		$distritoModel = new \Models\Distrito();

		$search = array("limit" => 12, "order" => 'rand');
		
		if (exists($_REQUEST['id_tipo'])) {
			$search['id_tipo'] = $_REQUEST['id_tipo'];
		}

		$data = array(
			"breadcrumbs" => $eventoModel->breadcrumbs(),
			"types" => $eventoModel->getItemTypes(),
			"distritos" => $distritoModel->itemsBasicInfo(),
			"items" => $eventoModel->getItemsList($search),
		);

		view('evento/main', $data);
	}

	public static function searchResultsPage() {
		$form = new \Form();

		$isValid = $form->validate('event_search', array(
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
				'alias' => \Lang\Dictionary::get('event_types'),
				"rules" => ['int'],
			),
			"dt_from" => array(
				'alias' => \Lang\Dictionary::get('dt_from'),
				"rules" => ['date'],
			),
			"dt_to" => array(
				'alias' => \Lang\Dictionary::get('dt_to'),
				"rules" => ['date'],
			),
		));

		$eventoModel = new \Models\Evento();
		$distritoModel = new \Models\Distrito();

		$data = array(
			"breadcrumbs" => $eventoModel->breadcrumbs(),
			"types" => $eventoModel->getItemTypes(),
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
			if (exists($_REQUEST['dt_from'])) {
				$search['dt_from'] = $_REQUEST['dt_from'];
			}
			if (exists($_REQUEST['dt_to'])) {
				$search['dt_to'] = $_REQUEST['dt_to'];
			}

			$search['order'] = 'dt_start';

			$data['items'] = $eventoModel->getItemsList($search);
		}

		view('evento/search_results', $data);
	}

}