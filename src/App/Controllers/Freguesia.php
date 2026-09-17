<?php

namespace Controllers;

Class Freguesia {

	public static function getListFromMunicipaliy($id_concelho) {
		$freguesiaModel = new \Models\Freguesia();
		$freguesias = $freguesiaModel->itemsBasicInfo(array("parent" => $id_concelho));
		json_return($freguesias, 200);
	}

	public static function overviewPage($id_freguesia) {
		$freguesiaModel = new \Models\Freguesia();
		$eventoModel = new \Models\Evento();

		$freguesia = $freguesiaModel->overallPageInfo($id_freguesia);

		$gps = $freguesia['freguesia']['gps'];

		$map = array(
			"gps" => $gps,
		);

		$data = array(
			"freguesia" => $freguesia['freguesia'],
			"breadcrumbs" => $freguesia['breadcrumbs'],
			"events" => $eventoModel->getItemsList(array("id_freguesia" => $id_freguesia, "limit" => 12)),
			"gallery" => $freguesiaModel->getItemGallery($id_freguesia, array("order" => 'rand', "limit" => 24)),
			"map" => $map,
			"sidebar" => array(
				"menu" => $freguesiaModel->generateSideMenu($freguesia['freguesia']),
				"weather" => \Models\Tools\Weather::getData($gps['lat'], $gps['lon'], 3, \Lang\Lang::fetchCurrentLangRef()),
				//"duty_pharmacies" => \Models\Farmacia::getDutyPharmaciesList4Concelho($freguesia['freguesia']['distrito']['title'], $freguesia['freguesia']['title']),
			),
		);

		view('freguesia/overview', $data);
	}

	public static function galleryPage($id_freguesia) {
		$freguesiaModel = new \Models\Freguesia();

		$freguesia = $freguesiaModel->overallPageInfo($id_freguesia, 'gallery');

		$gps = $freguesia['freguesia']['gps'];

		$pageNum = exists($_REQUEST['page']) ? (int) $_REQUEST['page'] : 1;

		$data = array(
			"freguesia" => $freguesia['freguesia'],
			"breadcrumbs" => $freguesia['breadcrumbs'],
			"gallery" => $freguesiaModel->getItemGallery($id_freguesia, array("limit" => 24, "page" => $pageNum)),
			"sidebar" => array(
				"menu" => $freguesiaModel->generateSideMenu($freguesia['freguesia']),
				"weather" => \Models\Tools\Weather::getData($gps['lat'], $gps['lon'], 3, \Lang\Lang::fetchCurrentLangRef()),
				//"duty_pharmacies" => \Models\Farmacia::getDutyPharmaciesList4Concelho($freguesia['freguesia']['distrito']['title'], $freguesia['freguesia']['title']),
			),
		);

		view('freguesia/gallery_page', $data);
	}

	public static function weatherPage($id_freguesia) {
		$freguesiaModel = new \Models\Freguesia();

		$freguesia = $freguesiaModel->overallPageInfo($id_freguesia, 'weather');

		$gps = $freguesia['freguesia']['gps'];

		$data = array(
			"freguesia" => $freguesia['freguesia'],
			"breadcrumbs" => $freguesia['breadcrumbs'],
			"weather" => \Models\Tools\Weather::getData($gps['lat'], $gps['lon'], 6, \Lang\Lang::fetchCurrentLangRef(), false),
			"sidebar" => array(
				"menu" => $freguesiaModel->generateSideMenu($freguesia['freguesia']),
				"weather" => \Models\Tools\Weather::getData($gps['lat'], $gps['lon'], 3, \Lang\Lang::fetchCurrentLangRef()),
				//"duty_pharmacies" => \Models\Farmacia::getDutyPharmaciesList4Concelho($freguesia['freguesia']['distrito']['title'], $freguesia['freguesia']['title']),
			),
		);

		view('freguesia/weather', $data);
	}

	public static function mapPage($id_freguesia) {
		$freguesiaModel = new \Models\Freguesia();

		$freguesia = $freguesiaModel->overallPageInfo($id_freguesia, 'map');

		$gps = $freguesia['freguesia']['gps'];

		$map = array(
			"gps" => $gps,
		);

		$data = array(
			"freguesia" => $freguesia['freguesia'],
			"breadcrumbs" => $freguesia['breadcrumbs'],
			"map" => $map,
			"sidebar" => array(
				"menu" => $freguesiaModel->generateSideMenu($freguesia['freguesia']),
				"weather" => \Models\Tools\Weather::getData($gps['lat'], $gps['lon'], 3, \Lang\Lang::fetchCurrentLangRef()),
				//"duty_pharmacies" => \Models\Farmacia::getDutyPharmaciesList4Concelho($freguesia['freguesia']['distrito']['title'], $freguesia['freguesia']['title']),
			),
		);

		view('freguesia/map', $data);
	}

	public static function pharmaciesListPage($id_freguesia) {
		$freguesiaModel = new \Models\Freguesia();
		$farmaciaModel = new \Models\Farmacia();

		$freguesia = $freguesiaModel->overallPageInfo($id_freguesia, 'pharmacies');

		$pharmacies = $farmaciaModel->getPharmaciesList(array("id_freguesia" => $id_freguesia));

		$gps = $freguesia['freguesia']['gps'];

		$map = array(
			"gps" => $gps,
			"points" => $farmaciaModel->convertIntoMapPoints($pharmacies['items']),
		);

		$data = array(
			"freguesia" => $freguesia['freguesia'],
			"breadcrumbs" => $freguesia['breadcrumbs'],
			"pharmacies" => $pharmacies,
			"map" => $map,
			"sidebar" => array(
				"menu" => $freguesiaModel->generateSideMenu($freguesia['freguesia']),
				"weather" => \Models\Tools\Weather::getData($gps['lat'], $gps['lon'], 3, \Lang\Lang::fetchCurrentLangRef()),
				//"duty_pharmacies" => \Models\Farmacia::getDutyPharmaciesList4Concelho($freguesia['freguesia']['distrito']['title'], $freguesia['freguesia']['title']),
			),
		);

		view('freguesia/pharmacies', $data);
	}

	public static function schoolsListPage($id_freguesia) {
		$freguesiaModel = new \Models\Freguesia();
		$escolaModel = new \Models\Escola();

		$freguesia = $freguesiaModel->overallPageInfo($id_freguesia, 'schools');

		$schools = $escolaModel->getSchoolsList(array("id_freguesia" => $id_freguesia));

		$gps = $freguesia['freguesia']['gps'];

		$map = array(
			"gps" => $gps,
			"points" => $escolaModel->convertIntoMapPoints($schools['items']),
		);

		$data = array(
			"freguesia" => $freguesia['freguesia'],
			"breadcrumbs" => $freguesia['breadcrumbs'],
			"schools" => $schools,
			"map" => $map,
			"sidebar" => array(
				"menu" => $freguesiaModel->generateSideMenu($freguesia['freguesia']),
				"weather" => \Models\Tools\Weather::getData($gps['lat'], $gps['lon'], 3, \Lang\Lang::fetchCurrentLangRef()),
				//"duty_pharmacies" => \Models\Farmacia::getDutyPharmaciesList4Concelho($freguesia['freguesia']['distrito']['title'], $freguesia['freguesia']['title']),
			),
		);


		view('freguesia/escolas', $data);
	}

	public static function healthCareUnitsListPage($id_freguesia) {
		$freguesiaModel = new \Models\Freguesia();
		$saudeModel = new \Models\Saude();

		$freguesia = $freguesiaModel->overallPageInfo($id_freguesia, 'healthcare');

		$healthcareUnits = $saudeModel->getHealthCareUnitsList(array("id_freguesia" => $id_freguesia));

		$gps = $freguesia['freguesia']['gps'];

		$map = array(
			"gps" => $gps,
			"points" => $saudeModel->convertIntoMapPoints($healthcareUnits['items']),
		);

		$data = array(
			"freguesia" => $freguesia['freguesia'],
			"breadcrumbs" => $freguesia['breadcrumbs'],
			"healthcare_units" => $healthcareUnits,
			"map" => $map,
			"sidebar" => array(
				"menu" => $freguesiaModel->generateSideMenu($freguesia['freguesia']),
				"weather" => \Models\Tools\Weather::getData($gps['lat'], $gps['lon'], 3, \Lang\Lang::fetchCurrentLangRef()),
				//"duty_pharmacies" => \Models\Farmacia::getDutyPharmaciesList4Concelho($freguesia['freguesia']['distrito']['title'], $freguesia['freguesia']['title']),
			),
		);

		view('freguesia/saude', $data);
	}

	public static function policePrecintsListPage($id_freguesia) {
		$freguesiaModel = new \Models\Freguesia();
		$policiaModel = new \Models\Policia();

		$freguesia = $freguesiaModel->overallPageInfo($id_freguesia, 'police');

		$precints = $policiaModel->getPrecintsList(array("id_freguesia" => $id_freguesia));

		$gps = $freguesia['freguesia']['gps'];

		$map = array(
			"gps" => $gps,
			"points" => $policiaModel->convertIntoMapPoints($precints['items']),
		);

		$data = array(
			"freguesia" => $freguesia['freguesia'],
			"breadcrumbs" => $freguesia['breadcrumbs'],
			"police_precints" => $precints,
			"map" => $map,
			"sidebar" => array(
				"menu" => $freguesiaModel->generateSideMenu($freguesia['freguesia']),
				"weather" => \Models\Tools\Weather::getData($gps['lat'], $gps['lon'], 3, \Lang\Lang::fetchCurrentLangRef()),
				//"duty_pharmacies" => \Models\Farmacia::getDutyPharmaciesList4Concelho($freguesia['freguesia']['distrito']['title'], $freguesia['freguesia']['title']),
			),
		);

		view('freguesia/policia', $data);
	}

	public static function firefightersListPage($id_freguesia) {
		$freguesiaModel = new \Models\Freguesia();
		$bombeiroModel = new \Models\Bombeiro();

		$freguesia = $freguesiaModel->overallPageInfo($id_freguesia, 'firefighters');

		$items = $bombeiroModel->getStationsList(array("id_freguesia" => $id_freguesia));

		$gps = $freguesia['freguesia']['gps'];

		$map = array(
			"gps" => $gps,
			"points" => $bombeiroModel->convertIntoMapPoints($items['items']),
		);

		$data = array(
			"freguesia" => $freguesia['freguesia'],
			"breadcrumbs" => $freguesia['breadcrumbs'],
			"items" => $items,
			"map" => $map,
			"sidebar" => array(
				"menu" => $freguesiaModel->generateSideMenu($freguesia['freguesia']),
				"weather" => \Models\Tools\Weather::getData($gps['lat'], $gps['lon'], 3, \Lang\Lang::fetchCurrentLangRef()),
				//"duty_pharmacies" => \Models\Farmacia::getDutyPharmaciesList4Concelho($freguesia['freguesia']['distrito']['title'], $freguesia['freguesia']['title']),
			),
		);

		view('freguesia/bombeiros', $data);
	}


	public static function beachesListPage($id_freguesia) {
		$freguesiaModel = new \Models\Freguesia();
		$praiaModel = new \Models\Praia();

		$freguesia = $freguesiaModel->overallPageInfo($id_freguesia, 'beaches');

		$items = $praiaModel->getItemsList(array("id_freguesia" => $id_freguesia));

		$gps = $freguesia['freguesia']['gps'];

		$map = array(
			"gps" => $gps,
			"points" => $praiaModel->convertIntoMapPoints($items['items']),
		);

		$data = array(
			"freguesia" => $freguesia['freguesia'],
			"breadcrumbs" => $freguesia['breadcrumbs'],
			"items" => $items,
			"map" => $map,
			"sidebar" => array(
				"menu" => $freguesiaModel->generateSideMenu($freguesia['freguesia']),
				"weather" => \Models\Tools\Weather::getData($gps['lat'], $gps['lon'], 3, \Lang\Lang::fetchCurrentLangRef()),
				//"duty_pharmacies" => \Models\Farmacia::getDutyPharmaciesList4Concelho($freguesia['freguesia']['distrito']['title'], $freguesia['freguesia']['title']),
			),
		);

		view('freguesia/praias', $data);
	}


	public static function tourismPointsListPage($id_freguesia) {
		$freguesiaModel = new \Models\Freguesia();
		$turismoModel = new \Models\PontoTuristico();

		$freguesia = $freguesiaModel->overallPageInfo($id_freguesia, 'tourism-points');

		$items = $turismoModel->getItemsList(array("id_freguesia" => $id_freguesia));

		$gps = $freguesia['freguesia']['gps'];

		$map = array(
			"gps" => $gps,
			"points" => $turismoModel->convertIntoMapPoints($items['items']),
		);

		$data = array(
			"freguesia" => $freguesia['freguesia'],
			"breadcrumbs" => $freguesia['breadcrumbs'],
			"items" => $items,
			"map" => $map,
			"sidebar" => array(
				"menu" => $freguesiaModel->generateSideMenu($freguesia['freguesia']),
				"weather" => \Models\Tools\Weather::getData($gps['lat'], $gps['lon'], 3, \Lang\Lang::fetchCurrentLangRef()),
				//"duty_pharmacies" => \Models\Farmacia::getDutyPharmaciesList4Concelho($freguesia['freguesia']['distrito']['title'], $freguesia['freguesia']['title']),
			),
		);

		view('freguesia/pontos_turismo', $data);
	}

	public static function eventsListPage($id_freguesia) {
		$freguesiaModel = new \Models\Freguesia();
		$eventoModel = new \Models\Evento();

		$freguesia = $freguesiaModel->overallPageInfo($id_freguesia, 'events');

		$items = $eventoModel->getItemsList(array("id_freguesia" => $id_freguesia));

		$gps = $freguesia['freguesia']['gps'];

		$map = array(
			"gps" => $gps,
			"points" => $eventoModel->convertIntoMapPoints($items['items']),
		);

		$data = array(
			"freguesia" => $freguesia['freguesia'],
			"breadcrumbs" => $freguesia['breadcrumbs'],
			"items" => $items,
			"map" => $map,
			"sidebar" => array(
				"menu" => $freguesiaModel->generateSideMenu($freguesia['freguesia']),
				"weather" => \Models\Tools\Weather::getData($gps['lat'], $gps['lon'], 3, \Lang\Lang::fetchCurrentLangRef()),
				//"duty_pharmacies" => \Models\Farmacia::getDutyPharmaciesList4Concelho($freguesia['freguesia']['distrito']['title'], $freguesia['freguesia']['title']),
			),
		);

		view('freguesia/eventos', $data);
	}



	public static function mapPoints($id_freguesia) {
		$mapPoints = array();

		/*Events*/
		$eventoModel = new \Models\Evento();
		$events = $eventoModel->getItemsList(array("id_freguesia" => $id_freguesia))['items'];
		$mapPoints = array_merge($mapPoints, $eventoModel->convertIntoMapPoints($events));

		/*Tourism Points*/
		$turismoModel = new \Models\PontoTuristico();
		$tourismPoints = $turismoModel->getItemsList(array("id_freguesia" => $id_freguesia))['items'];
		$mapPoints = array_merge($mapPoints, $turismoModel->convertIntoMapPoints($tourismPoints));

		/*Beaches*/
		$praiaModel = new \Models\Praia();
		$beaches = $praiaModel->getItemsList(array("id_freguesia" => $id_freguesia))['items'];
		$mapPoints = array_merge($mapPoints, $praiaModel->convertIntoMapPoints($beaches));

		/*Pharmacies*/
		$farmaciaModel = new \Models\Farmacia();
		$pharmacies = $farmaciaModel->getPharmaciesList(array("id_freguesia" => $id_freguesia))['items'];
		$mapPoints = array_merge($mapPoints, $farmaciaModel->convertIntoMapPoints($pharmacies));

		/*Schools*/
		$escolaModel = new \Models\Escola();
		$schools = $escolaModel->getSchoolsList(array("id_freguesia" => $id_freguesia))['items'];
		$mapPoints = array_merge($mapPoints, $escolaModel->convertIntoMapPoints($schools));

		/*Healthcare*/
		$saudeModel = new \Models\Saude();
		$healthcareUnits = $saudeModel->getHealthCareUnitsList(array("id_freguesia" => $id_freguesia))['items'];
		$mapPoints = array_merge($mapPoints, $saudeModel->convertIntoMapPoints($healthcareUnits));

		/*Police*/
		$policiaModel = new \Models\Policia();
		$precints = $policiaModel->getPrecintsList(array("id_freguesia" => $id_freguesia))['items'];
		$mapPoints = array_merge($mapPoints, $policiaModel->convertIntoMapPoints($precints));

		/*Firefighters*/
		$bombeiroModel = new \Models\Bombeiro();
		$items = $bombeiroModel->getStationsList(array("id_freguesia" => $id_freguesia))['items'];
		$mapPoints = array_merge($mapPoints, $bombeiroModel->convertIntoMapPoints($items));

		
		json_return($mapPoints, 200);
	}

}