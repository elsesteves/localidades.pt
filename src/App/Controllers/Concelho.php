<?php

namespace Controllers;

Class Concelho {

	public static function getListFromDistrict($id_distrito) {
		$concelhoModel = new \Models\Concelho();
		$concelhos = $concelhoModel->itemsBasicInfo(array("parent" => $id_distrito));
		json_return($concelhos, 200);
	}

	public static function overviewPage($id_concelho) {
		$concelhoModel = new \Models\Concelho();
		$freguesiaModel = new \Models\Freguesia();
		$eventoModel = new \Models\Evento();

		$concelho = $concelhoModel->overallPageInfo($id_concelho);

		$gps = $concelho['concelho']['gps'];

		$map = array(
			"gps" => $gps,
		);

		$data = array(
			"concelho" => $concelho['concelho'],
			"breadcrumbs" => $concelho['breadcrumbs'],
			"freguesias" => $freguesiaModel->itemsBasicInfo(array("parent" => $id_concelho)),
			"events" => $eventoModel->getItemsList(array("id_concelho" => $id_concelho, "limit" => 12)),
			"gallery" => $concelhoModel->getItemGallery($id_concelho, array("order" => 'rand', "limit" => 24)),
			"map" => $map,
			"sidebar" => array(
				"menu" => $concelhoModel->generateSideMenu($concelho['concelho']),
				"weather" => \Models\Tools\Weather::getData($gps['lat'], $gps['lon'], 3, \Lang\Lang::fetchCurrentLangRef()),
				"duty_pharmacies" => \Models\Farmacia::getDutyPharmaciesList4Concelho($concelho['concelho']['distrito']['title'], $concelho['concelho']['title']),
			),
		);

		view('concelho/overview', $data);
	}

	public static function galleryPage($id_concelho) {
		$concelhoModel = new \Models\Concelho();

		$concelho = $concelhoModel->overallPageInfo($id_concelho, 'gallery');

		$gps = $concelho['concelho']['gps'];

		$pageNum = exists($_REQUEST['page']) ? (int) $_REQUEST['page'] : 1;

		$data = array(
			"concelho" => $concelho['concelho'],
			"breadcrumbs" => $concelho['breadcrumbs'],
			"gallery" => $concelhoModel->getItemGallery($id_concelho, array("limit" => 24, "page" => $pageNum)),
			"sidebar" => array(
				"menu" => $concelhoModel->generateSideMenu($concelho['concelho']),
				"weather" => \Models\Tools\Weather::getData($gps['lat'], $gps['lon'], 3, \Lang\Lang::fetchCurrentLangRef()),
				"duty_pharmacies" => \Models\Farmacia::getDutyPharmaciesList4Concelho($concelho['concelho']['distrito']['title'], $concelho['concelho']['title']),
			),
		);

		view('concelho/gallery_page', $data);
	}


	public static function weatherPage($id_concelho) {
		$concelhoModel = new \Models\Concelho();

		$concelho = $concelhoModel->overallPageInfo($id_concelho, 'weather');

		$gps = $concelho['concelho']['gps'];

		$data = array(
			"concelho" => $concelho['concelho'],
			"breadcrumbs" => $concelho['breadcrumbs'],
			"weather" => \Models\Tools\Weather::getData($gps['lat'], $gps['lon'], 6, \Lang\Lang::fetchCurrentLangRef(), false),
			"sidebar" => array(
				"menu" => $concelhoModel->generateSideMenu($concelho['concelho']),
				"weather" => \Models\Tools\Weather::getData($gps['lat'], $gps['lon'], 3, \Lang\Lang::fetchCurrentLangRef()),
				"duty_pharmacies" => \Models\Farmacia::getDutyPharmaciesList4Concelho($concelho['concelho']['distrito']['title'], $concelho['concelho']['title']),
			),
		);

		view('concelho/weather', $data);
	}

	public static function mapPage($id_concelho) {
		$concelhoModel = new \Models\Concelho();

		$concelho = $concelhoModel->overallPageInfo($id_concelho, 'map');

		$gps = $concelho['concelho']['gps'];

		$map = array(
			"gps" => $gps,
		);

		$data = array(
			"concelho" => $concelho['concelho'],
			"breadcrumbs" => $concelho['breadcrumbs'],
			"map" => $map,
			"sidebar" => array(
				"menu" => $concelhoModel->generateSideMenu($concelho['concelho']),
				"weather" => \Models\Tools\Weather::getData($gps['lat'], $gps['lon'], 3, \Lang\Lang::fetchCurrentLangRef()),
				"duty_pharmacies" => \Models\Farmacia::getDutyPharmaciesList4Concelho($concelho['concelho']['distrito']['title'], $concelho['concelho']['title']),
			),
		);

		view('concelho/map', $data);
	}

	public static function pharmaciesListPage($id_concelho) {
		$concelhoModel = new \Models\Concelho();
		$farmaciaModel = new \Models\Farmacia();

		$concelho = $concelhoModel->overallPageInfo($id_concelho, 'pharmacies');

		$pharmacies = $farmaciaModel->getPharmaciesList(array("id_concelho" => $id_concelho));

		$gps = $concelho['concelho']['gps'];

		$map = array(
			"gps" => $gps,
			"points" => $farmaciaModel->convertIntoMapPoints($pharmacies['items']),
		);

		$data = array(
			"concelho" => $concelho['concelho'],
			"breadcrumbs" => $concelho['breadcrumbs'],
			"pharmacies" => $pharmacies,
			"map" => $map,
			"sidebar" => array(
				"menu" => $concelhoModel->generateSideMenu($concelho['concelho']),
				"weather" => \Models\Tools\Weather::getData($gps['lat'], $gps['lon'], 3, \Lang\Lang::fetchCurrentLangRef()),
				"duty_pharmacies" => \Models\Farmacia::getDutyPharmaciesList4Concelho($concelho['concelho']['distrito']['title'], $concelho['concelho']['title']),
			),
		);

		view('concelho/pharmacies', $data);
	}


	public static function schoolsListPage($id_concelho) {
		$concelhoModel = new \Models\Concelho();
		$escolaModel = new \Models\Escola();

		$concelho = $concelhoModel->overallPageInfo($id_concelho, 'schools');

		$schools = $escolaModel->getSchoolsList(array("id_concelho" => $id_concelho));

		$gps = $concelho['concelho']['gps'];

		$map = array(
			"gps" => $gps,
			"points" => $escolaModel->convertIntoMapPoints($schools['items']),
		);

		$data = array(
			"concelho" => $concelho['concelho'],
			"breadcrumbs" => $concelho['breadcrumbs'],
			"schools" => $schools,
			"map" => $map,
			"sidebar" => array(
				"menu" => $concelhoModel->generateSideMenu($concelho['concelho']),
				"weather" => \Models\Tools\Weather::getData($gps['lat'], $gps['lon'], 3, \Lang\Lang::fetchCurrentLangRef()),
				"duty_pharmacies" => \Models\Farmacia::getDutyPharmaciesList4Concelho($concelho['concelho']['distrito']['title'], $concelho['concelho']['title']),
			),
		);


		view('concelho/escolas', $data);
	}

	public static function healthCareUnitsListPage($id_concelho) {
		$concelhoModel = new \Models\Concelho();
		$saudeModel = new \Models\Saude();

		$concelho = $concelhoModel->overallPageInfo($id_concelho, 'healthcare');

		$healthcareUnits = $saudeModel->getHealthCareUnitsList(array("id_concelho" => $id_concelho));

		$gps = $concelho['concelho']['gps'];

		$map = array(
			"gps" => $gps,
			"points" => $saudeModel->convertIntoMapPoints($healthcareUnits['items']),
		);

		$data = array(
			"concelho" => $concelho['concelho'],
			"breadcrumbs" => $concelho['breadcrumbs'],
			"healthcare_units" => $healthcareUnits,
			"map" => $map,
			"sidebar" => array(
				"menu" => $concelhoModel->generateSideMenu($concelho['concelho']),
				"weather" => \Models\Tools\Weather::getData($gps['lat'], $gps['lon'], 3, \Lang\Lang::fetchCurrentLangRef()),
				"duty_pharmacies" => \Models\Farmacia::getDutyPharmaciesList4Concelho($concelho['concelho']['distrito']['title'], $concelho['concelho']['title']),
			),
		);

		view('concelho/saude', $data);
	}


	public static function policePrecintsListPage($id_concelho) {
		$concelhoModel = new \Models\Concelho();
		$policiaModel = new \Models\Policia();

		$concelho = $concelhoModel->overallPageInfo($id_concelho, 'police');

		$precints = $policiaModel->getPrecintsList(array("id_concelho" => $id_concelho));

		$gps = $concelho['concelho']['gps'];

		$map = array(
			"gps" => $gps,
			"points" => $policiaModel->convertIntoMapPoints($precints['items']),
		);

		$data = array(
			"concelho" => $concelho['concelho'],
			"breadcrumbs" => $concelho['breadcrumbs'],
			"police_precints" => $precints,
			"map" => $map,
			"sidebar" => array(
				"menu" => $concelhoModel->generateSideMenu($concelho['concelho']),
				"weather" => \Models\Tools\Weather::getData($gps['lat'], $gps['lon'], 3, \Lang\Lang::fetchCurrentLangRef()),
				"duty_pharmacies" => \Models\Farmacia::getDutyPharmaciesList4Concelho($concelho['concelho']['distrito']['title'], $concelho['concelho']['title']),
			),
		);

		view('concelho/policia', $data);
	}


	public static function firefightersListPage($id_concelho) {
		$concelhoModel = new \Models\Concelho();
		$bombeiroModel = new \Models\Bombeiro();

		$concelho = $concelhoModel->overallPageInfo($id_concelho, 'firefighters');

		$items = $bombeiroModel->getStationsList(array("id_concelho" => $id_concelho));

		$gps = $concelho['concelho']['gps'];

		$map = array(
			"gps" => $gps,
			"points" => $bombeiroModel->convertIntoMapPoints($items['items']),
		);

		$data = array(
			"concelho" => $concelho['concelho'],
			"breadcrumbs" => $concelho['breadcrumbs'],
			"items" => $items,
			"map" => $map,
			"sidebar" => array(
				"menu" => $concelhoModel->generateSideMenu($concelho['concelho']),
				"weather" => \Models\Tools\Weather::getData($gps['lat'], $gps['lon'], 3, \Lang\Lang::fetchCurrentLangRef()),
				"duty_pharmacies" => \Models\Farmacia::getDutyPharmaciesList4Concelho($concelho['concelho']['distrito']['title'], $concelho['concelho']['title']),
			),
		);

		view('concelho/bombeiros', $data);
	}


	public static function beachesListPage($id_concelho) {
		$concelhoModel = new \Models\Concelho();
		$praiaModel = new \Models\Praia();

		$concelho = $concelhoModel->overallPageInfo($id_concelho, 'beaches');

		$items = $praiaModel->getItemsList(array("id_concelho" => $id_concelho));

		$gps = $concelho['concelho']['gps'];

		$map = array(
			"gps" => $gps,
			"points" => $praiaModel->convertIntoMapPoints($items['items']),
		);

		$data = array(
			"concelho" => $concelho['concelho'],
			"breadcrumbs" => $concelho['breadcrumbs'],
			"items" => $items,
			"map" => $map,
			"sidebar" => array(
				"menu" => $concelhoModel->generateSideMenu($concelho['concelho']),
				"weather" => \Models\Tools\Weather::getData($gps['lat'], $gps['lon'], 3, \Lang\Lang::fetchCurrentLangRef()),
				"duty_pharmacies" => \Models\Farmacia::getDutyPharmaciesList4Concelho($concelho['concelho']['distrito']['title'], $concelho['concelho']['title']),
			),
		);

		view('concelho/praias', $data);
	}


	public static function tourismPointsListPage($id_concelho) {
		$concelhoModel = new \Models\Concelho();
		$turismoModel = new \Models\PontoTuristico();

		$concelho = $concelhoModel->overallPageInfo($id_concelho, 'tourism-points');

		$items = $turismoModel->getItemsList(array("id_concelho" => $id_concelho));

		$gps = $concelho['concelho']['gps'];

		$map = array(
			"gps" => $gps,
			"points" => $turismoModel->convertIntoMapPoints($items['items']),
		);

		$data = array(
			"concelho" => $concelho['concelho'],
			"breadcrumbs" => $concelho['breadcrumbs'],
			"items" => $items,
			"map" => $map,
			"sidebar" => array(
				"menu" => $concelhoModel->generateSideMenu($concelho['concelho']),
				"weather" => \Models\Tools\Weather::getData($gps['lat'], $gps['lon'], 3, \Lang\Lang::fetchCurrentLangRef()),
				"duty_pharmacies" => \Models\Farmacia::getDutyPharmaciesList4Concelho($concelho['concelho']['distrito']['title'], $concelho['concelho']['title']),
			),
		);

		view('concelho/pontos_turismo', $data);
	}


	public static function eventsListPage($id_concelho) {
		$concelhoModel = new \Models\Concelho();
		$eventoModel = new \Models\Evento();

		$concelho = $concelhoModel->overallPageInfo($id_concelho, 'events');

		$items = $eventoModel->getItemsList(array("id_concelho" => $id_concelho));

		$gps = $concelho['concelho']['gps'];

		$map = array(
			"gps" => $gps,
			"points" => $eventoModel->convertIntoMapPoints($items['items']),
		);

		$data = array(
			"concelho" => $concelho['concelho'],
			"breadcrumbs" => $concelho['breadcrumbs'],
			"items" => $items,
			"map" => $map,
			"sidebar" => array(
				"menu" => $concelhoModel->generateSideMenu($concelho['concelho']),
				"weather" => \Models\Tools\Weather::getData($gps['lat'], $gps['lon'], 3, \Lang\Lang::fetchCurrentLangRef()),
				"duty_pharmacies" => \Models\Farmacia::getDutyPharmaciesList4Concelho($concelho['concelho']['distrito']['title'], $concelho['concelho']['title']),
			),
		);

		view('concelho/eventos', $data);
	}

	public static function mapPoints($id_concelho) {
		$mapPoints = array();

		/*Events*/
		$eventoModel = new \Models\Evento();
		$events = $eventoModel->getItemsList(array("id_concelho" => $id_concelho))['items'];
		$mapPoints = array_merge($mapPoints, $eventoModel->convertIntoMapPoints($events));

		/*Tourism Points*/
		$turismoModel = new \Models\PontoTuristico();
		$tourismPoints = $turismoModel->getItemsList(array("id_concelho" => $id_concelho))['items'];
		$mapPoints = array_merge($mapPoints, $turismoModel->convertIntoMapPoints($tourismPoints));

		/*Beaches*/
		$praiaModel = new \Models\Praia();
		$beaches = $praiaModel->getItemsList(array("id_concelho" => $id_concelho))['items'];
		$mapPoints = array_merge($mapPoints, $praiaModel->convertIntoMapPoints($beaches));

		/*Pharmacies*/
		$farmaciaModel = new \Models\Farmacia();
		$pharmacies = $farmaciaModel->getPharmaciesList(array("id_concelho" => $id_concelho))['items'];
		$mapPoints = array_merge($mapPoints, $farmaciaModel->convertIntoMapPoints($pharmacies));

		/*Schools*/
		$escolaModel = new \Models\Escola();
		$schools = $escolaModel->getSchoolsList(array("id_concelho" => $id_concelho))['items'];
		$mapPoints = array_merge($mapPoints, $escolaModel->convertIntoMapPoints($schools));

		/*Healthcare*/
		$saudeModel = new \Models\Saude();
		$healthcareUnits = $saudeModel->getHealthCareUnitsList(array("id_concelho" => $id_concelho))['items'];
		$mapPoints = array_merge($mapPoints, $saudeModel->convertIntoMapPoints($healthcareUnits));

		/*Police*/
		$policiaModel = new \Models\Policia();
		$precints = $policiaModel->getPrecintsList(array("id_concelho" => $id_concelho))['items'];
		$mapPoints = array_merge($mapPoints, $policiaModel->convertIntoMapPoints($precints));

		/*Firefighters*/
		$bombeiroModel = new \Models\Bombeiro();
		$items = $bombeiroModel->getStationsList(array("id_concelho" => $id_concelho))['items'];
		$mapPoints = array_merge($mapPoints, $bombeiroModel->convertIntoMapPoints($items));

		
		json_return($mapPoints, 200);
	}

}