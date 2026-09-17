<?php

namespace Controllers;

Class Distrito {

	public static function overviewPage($id_distrito) {
		$concelhoModel = new \Models\Concelho();
		$distritoModel = new \Models\Distrito();
		$eventoModel = new \Models\Evento();

		$distrito = $distritoModel->overallPageInfo($id_distrito);

		$gps = $distrito['distrito']['gps'];

		$map = array(
			"gps" => $gps,
		);

		$data = array(
			"distrito" => $distrito['distrito'],
			"breadcrumbs" => $distrito['breadcrumbs'],
			"concelhos" => $concelhoModel->itemsBasicInfo(array("parent" => $id_distrito)),
			"events" => $eventoModel->getItemsList(array("id_distrito" => $id_distrito, "limit" => 12)),
			"gallery" => $distritoModel->getItemGallery($id_distrito, array("order" => 'rand', "limit" => 24)),
			"map" => $map,
			"sidebar" => array(
				"menu" => $distritoModel->generateSideMenu($distrito['distrito']),
				"weather" => \Models\Tools\Weather::getData($gps['lat'], $gps['lon'], 3, \Lang\Lang::fetchCurrentLangRef()),
				//"duty_pharmacies" => \Models\Farmacia::getDutyPharmaciesList4Concelho($distrito['distrito']['distrito']['title'], $distrito['concelho']['title']),
			),
		);

		view('distrito/overview', $data);
	}

	public static function galleryPage($id_distrito) {
		$distritoModel = new \Models\Distrito();

		$distrito = $distritoModel->overallPageInfo($id_distrito, 'gallery');

		$gps = $distrito['distrito']['gps'];

		$pageNum = exists($_REQUEST['page']) ? (int) $_REQUEST['page'] : 1;

		$data = array(
			"distrito" => $distrito['distrito'],
			"breadcrumbs" => $distrito['breadcrumbs'],
			"gallery" => $distritoModel->getItemGallery($id_distrito, array("limit" => 24, "page" => $pageNum)),
			"sidebar" => array(
				"menu" => $distritoModel->generateSideMenu($distrito['distrito']),
				"weather" => \Models\Tools\Weather::getData($gps['lat'], $gps['lon'], 3, \Lang\Lang::fetchCurrentLangRef()),
				//"duty_pharmacies" => \Models\Farmacia::getDutyPharmaciesList4Concelho($distrito['distrito']['distrito']['title'], $distrito['concelho']['title']),
			),
		);

		view('distrito/gallery_page', $data);
	}

	public static function weatherPage($id_distrito) {
		$distritoModel = new \Models\Distrito();

		$distrito = $distritoModel->overallPageInfo($id_distrito, 'weather');

		$gps = $distrito['distrito']['gps'];

		$data = array(
			"distrito" => $distrito['distrito'],
			"breadcrumbs" => $distrito['breadcrumbs'],
			"weather" => \Models\Tools\Weather::getData($gps['lat'], $gps['lon'], 6, \Lang\Lang::fetchCurrentLangRef(), false),
			"sidebar" => array(
				"menu" => $distritoModel->generateSideMenu($distrito['distrito']),
				"weather" => \Models\Tools\Weather::getData($gps['lat'], $gps['lon'], 3, \Lang\Lang::fetchCurrentLangRef()),
				//"duty_pharmacies" => \Models\Farmacia::getDutyPharmaciesList4Concelho($distrito['distrito']['distrito']['title'], $distrito['concelho']['title']),
			),
		);

		view('distrito/weather', $data);
	}


	public static function mapPage($id_distrito) {
		$distritoModel = new \Models\Distrito();

		$distrito = $distritoModel->overallPageInfo($id_distrito, 'map');

		$gps = $distrito['distrito']['gps'];

		$map = array(
			"gps" => $gps,
		);

		$data = array(
			"distrito" => $distrito['distrito'],
			"breadcrumbs" => $distrito['breadcrumbs'],
			"map" => $map,
			"sidebar" => array(
				"menu" => $distritoModel->generateSideMenu($distrito['distrito']),
				"weather" => \Models\Tools\Weather::getData($gps['lat'], $gps['lon'], 3, \Lang\Lang::fetchCurrentLangRef()),
				//"duty_pharmacies" => \Models\Farmacia::getDutyPharmaciesList4Concelho($distrito['distrito']['distrito']['title'], $distrito['concelho']['title']),
			),
		);

		view('distrito/map', $data);
	}

	public static function pharmaciesListPage($id_distrito) {
		$distritoModel = new \Models\Distrito();
		$farmaciaModel = new \Models\Farmacia();

		$distrito = $distritoModel->overallPageInfo($id_distrito, 'pharmacies');

		$pharmacies = $farmaciaModel->getPharmaciesList(array("id_distrito" => $id_distrito));

		$gps = $distrito['distrito']['gps'];

		$map = array(
			"gps" => $gps,
			"points" => $farmaciaModel->convertIntoMapPoints($pharmacies['items']),
		);

		$data = array(
			"distrito" => $distrito['distrito'],
			"breadcrumbs" => $distrito['breadcrumbs'],
			"pharmacies" => $pharmacies,
			"map" => $map,
			"sidebar" => array(
				"menu" => $distritoModel->generateSideMenu($distrito['distrito']),
				"weather" => \Models\Tools\Weather::getData($gps['lat'], $gps['lon'], 3, \Lang\Lang::fetchCurrentLangRef()),
				//"duty_pharmacies" => \Models\Farmacia::getDutyPharmaciesList4Concelho($distrito['distrito']['distrito']['title'], $distrito['concelho']['title']),
			),
		);

		view('distrito/pharmacies', $data);
	}

	public static function schoolsListPage($id_distrito) {
		$distritoModel = new \Models\Distrito();
		$escolaModel = new \Models\Escola();

		$distrito = $distritoModel->overallPageInfo($id_distrito, 'schools');

		$schools = $escolaModel->getSchoolsList(array("id_distrito" => $id_distrito));

		$gps = $distrito['distrito']['gps'];

		$map = array(
			"gps" => $gps,
			"points" => $escolaModel->convertIntoMapPoints($schools['items']),
		);

		$data = array(
			"distrito" => $distrito['distrito'],
			"breadcrumbs" => $distrito['breadcrumbs'],
			"schools" => $schools,
			"map" => $map,
			"sidebar" => array(
				"menu" => $distritoModel->generateSideMenu($distrito['distrito']),
				"weather" => \Models\Tools\Weather::getData($gps['lat'], $gps['lon'], 3, \Lang\Lang::fetchCurrentLangRef()),
				//"duty_pharmacies" => \Models\Farmacia::getDutyPharmaciesList4Concelho($distrito['distrito']['distrito']['title'], $distrito['concelho']['title']),
			),
		);


		view('distrito/escolas', $data);
	}

	public static function healthCareUnitsListPage($id_distrito) {
		$distritoModel = new \Models\Distrito();
		$saudeModel = new \Models\Saude();

		$distrito = $distritoModel->overallPageInfo($id_distrito, 'healthcare');

		$healthcareUnits = $saudeModel->getHealthCareUnitsList(array("id_distrito" => $id_distrito));

		$gps = $distrito['distrito']['gps'];

		$map = array(
			"gps" => $gps,
			"points" => $saudeModel->convertIntoMapPoints($healthcareUnits['items']),
		);

		$data = array(
			"distrito" => $distrito['distrito'],
			"breadcrumbs" => $distrito['breadcrumbs'],
			"healthcare_units" => $healthcareUnits,
			"map" => $map,
			"sidebar" => array(
				"menu" => $distritoModel->generateSideMenu($distrito['distrito']),
				"weather" => \Models\Tools\Weather::getData($gps['lat'], $gps['lon'], 3, \Lang\Lang::fetchCurrentLangRef()),
				//"duty_pharmacies" => \Models\Farmacia::getDutyPharmaciesList4Concelho($distrito['distrito']['distrito']['title'], $distrito['concelho']['title']),
			),
		);

		view('distrito/saude', $data);
	}

	public static function policePrecintsListPage($id_distrito) {
		$distritoModel = new \Models\Distrito();
		$policiaModel = new \Models\Policia();

		$distrito = $distritoModel->overallPageInfo($id_distrito, 'police');

		$precints = $policiaModel->getPrecintsList(array("id_distrito" => $id_distrito));

		$gps = $distrito['distrito']['gps'];

		$map = array(
			"gps" => $gps,
			"points" => $policiaModel->convertIntoMapPoints($precints['items']),
		);

		$data = array(
			"distrito" => $distrito['distrito'],
			"breadcrumbs" => $distrito['breadcrumbs'],
			"police_precints" => $precints,
			"map" => $map,
			"sidebar" => array(
				"menu" => $distritoModel->generateSideMenu($distrito['distrito']),
				"weather" => \Models\Tools\Weather::getData($gps['lat'], $gps['lon'], 3, \Lang\Lang::fetchCurrentLangRef()),
				//"duty_pharmacies" => \Models\Farmacia::getDutyPharmaciesList4Concelho($distrito['distrito']['distrito']['title'], $distrito['concelho']['title']),
			),
		);

		view('distrito/policia', $data);
	}

	public static function firefightersListPage($id_distrito) {
		$distritoModel = new \Models\Distrito();
		$bombeiroModel = new \Models\Bombeiro();

		$distrito = $distritoModel->overallPageInfo($id_distrito, 'firefighters');

		$items = $bombeiroModel->getStationsList(array("id_distrito" => $id_distrito));

		$gps = $distrito['distrito']['gps'];

		$map = array(
			"gps" => $gps,
			"points" => $bombeiroModel->convertIntoMapPoints($items['items']),
		);

		$data = array(
			"distrito" => $distrito['distrito'],
			"breadcrumbs" => $distrito['breadcrumbs'],
			"items" => $items,
			"map" => $map,
			"sidebar" => array(
				"menu" => $distritoModel->generateSideMenu($distrito['distrito']),
				"weather" => \Models\Tools\Weather::getData($gps['lat'], $gps['lon'], 3, \Lang\Lang::fetchCurrentLangRef()),
				//"duty_pharmacies" => \Models\Farmacia::getDutyPharmaciesList4Concelho($distrito['distrito']['distrito']['title'], $distrito['concelho']['title']),
			),
		);

		view('distrito/bombeiros', $data);
	}

	public static function beachesListPage($id_distrito) {
		$distritoModel = new \Models\Distrito();
		$praiaModel = new \Models\Praia();

		$distrito = $distritoModel->overallPageInfo($id_distrito, 'beaches');

		$items = $praiaModel->getItemsList(array("id_distrito" => $id_distrito));

		$gps = $distrito['distrito']['gps'];

		$map = array(
			"gps" => $gps,
			"points" => $praiaModel->convertIntoMapPoints($items['items']),
		);

		$data = array(
			"distrito" => $distrito['distrito'],
			"breadcrumbs" => $distrito['breadcrumbs'],
			"items" => $items,
			"map" => $map,
			"sidebar" => array(
				"menu" => $distritoModel->generateSideMenu($distrito['distrito']),
				"weather" => \Models\Tools\Weather::getData($gps['lat'], $gps['lon'], 3, \Lang\Lang::fetchCurrentLangRef()),
				//"duty_pharmacies" => \Models\Farmacia::getDutyPharmaciesList4Concelho($distrito['distrito']['distrito']['title'], $distrito['concelho']['title']),
			),
		);

		view('distrito/praias', $data);
	}

	public static function tourismPointsListPage($id_distrito) {
		$distritoModel = new \Models\Distrito();
		$turismoModel = new \Models\PontoTuristico();

		$distrito = $distritoModel->overallPageInfo($id_distrito, 'tourism-points');

		$items = $turismoModel->getItemsList(array("id_distrito" => $id_distrito));

		$gps = $distrito['distrito']['gps'];

		$map = array(
			"gps" => $gps,
			"points" => $turismoModel->convertIntoMapPoints($items['items']),
		);

		$data = array(
			"distrito" => $distrito['distrito'],
			"breadcrumbs" => $distrito['breadcrumbs'],
			"items" => $items,
			"map" => $map,
			"sidebar" => array(
				"menu" => $distritoModel->generateSideMenu($distrito['distrito']),
				"weather" => \Models\Tools\Weather::getData($gps['lat'], $gps['lon'], 3, \Lang\Lang::fetchCurrentLangRef()),
				//"duty_pharmacies" => \Models\Farmacia::getDutyPharmaciesList4Concelho($distrito['distrito']['distrito']['title'], $distrito['concelho']['title']),
			),
		);

		view('distrito/pontos_turismo', $data);
	}

	public static function eventsListPage($id_distrito) {
		$distritoModel = new \Models\Distrito();
		$eventoModel = new \Models\Evento();

		$distrito = $distritoModel->overallPageInfo($id_distrito, 'events');

		$items = $eventoModel->getItemsList(array("id_distrito" => $id_distrito));

		$gps = $distrito['distrito']['gps'];

		$map = array(
			"gps" => $gps,
			"points" => $eventoModel->convertIntoMapPoints($items['items']),
		);

		$data = array(
			"distrito" => $distrito['distrito'],
			"breadcrumbs" => $distrito['breadcrumbs'],
			"items" => $items,
			"map" => $map,
			"sidebar" => array(
				"menu" => $distritoModel->generateSideMenu($distrito['distrito']),
				"weather" => \Models\Tools\Weather::getData($gps['lat'], $gps['lon'], 3, \Lang\Lang::fetchCurrentLangRef()),
				//"duty_pharmacies" => \Models\Farmacia::getDutyPharmaciesList4Concelho($distrito['distrito']['distrito']['title'], $distrito['concelho']['title']),
			),
		);

		view('distrito/eventos', $data);
	}

	public static function mapPoints($id_distrito) {
		$mapPoints = array();

		/*Events*/
		$eventoModel = new \Models\Evento();
		$events = $eventoModel->getItemsList(array("id_distrito" => $id_distrito))['items'];
		$mapPoints = array_merge($mapPoints, $eventoModel->convertIntoMapPoints($events));

		/*Tourism Points*/
		$turismoModel = new \Models\PontoTuristico();
		$tourismPoints = $turismoModel->getItemsList(array("id_distrito" => $id_distrito))['items'];
		$mapPoints = array_merge($mapPoints, $turismoModel->convertIntoMapPoints($tourismPoints));

		/*Beaches*/
		$praiaModel = new \Models\Praia();
		$beaches = $praiaModel->getItemsList(array("id_distrito" => $id_distrito))['items'];
		$mapPoints = array_merge($mapPoints, $praiaModel->convertIntoMapPoints($beaches));

		/*Pharmacies*/
		$farmaciaModel = new \Models\Farmacia();
		$pharmacies = $farmaciaModel->getPharmaciesList(array("id_distrito" => $id_distrito))['items'];
		$mapPoints = array_merge($mapPoints, $farmaciaModel->convertIntoMapPoints($pharmacies));

		/*Schools*/
		$escolaModel = new \Models\Escola();
		$schools = $escolaModel->getSchoolsList(array("id_distrito" => $id_distrito))['items'];
		$mapPoints = array_merge($mapPoints, $escolaModel->convertIntoMapPoints($schools));

		/*Healthcare*/
		$saudeModel = new \Models\Saude();
		$healthcareUnits = $saudeModel->getHealthCareUnitsList(array("id_distrito" => $id_distrito))['items'];
		$mapPoints = array_merge($mapPoints, $saudeModel->convertIntoMapPoints($healthcareUnits));

		/*Police*/
		$policiaModel = new \Models\Policia();
		$precints = $policiaModel->getPrecintsList(array("id_distrito" => $id_distrito))['items'];
		$mapPoints = array_merge($mapPoints, $policiaModel->convertIntoMapPoints($precints));

		/*Firefighters*/
		$bombeiroModel = new \Models\Bombeiro();
		$items = $bombeiroModel->getStationsList(array("id_distrito" => $id_distrito))['items'];
		$mapPoints = array_merge($mapPoints, $bombeiroModel->convertIntoMapPoints($items));

		
		json_return($mapPoints, 200);
	}
}