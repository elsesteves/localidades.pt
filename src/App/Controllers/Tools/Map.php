<?php

namespace Controllers\Tools;

Class Map {

	public static function show() {
		$geolocation = 'false';
		if (exists($_REQUEST['geolocation']) && $_REQUEST['geolocation'] == 'true') {
			$geolocation = 'true';
		}

		view('tools/map', array(
			"coords" => \Models\Tools\Map::startCoordinates(),
			"geolocation" => $geolocation,
	    ), true);
	}

	public static function directions() {
		$coordInfo = array('from_lat', 'from_lng', 'to_lat', 'to_lng');

		foreach($coordInfo as $coordInfoItem) {
			if (!exists($_GET[$coordInfoItem])) {
				json_return(array(
		    		"name" => 'Bad Request',
		    		"message" => "Missing latitude and/or longitude from start and/or destination."
				) , 400);
				return false;
			}
			$$coordInfoItem = $_GET[$coordInfoItem];
		}

		$data = \Models\Tools\Map::directions($from_lat, $from_lng, $to_lat, $to_lng);

		json_return($data, 200);
	}

}