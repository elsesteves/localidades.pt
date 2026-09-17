<?php 

namespace Models\Tools;

Class Map {

	/*https://github.com/GIScience/openrouteservice-docs#instruction-types*/
	protected static $instructionTypes;

	public static function instructionTypesInfo() {
		self::$instructionTypes = array(
			0 => array(
				"name" => "Left",
				"title" => \Lang\Dictionary::get('map_instructions_left'),
				"icon" => "/assets/images/map/directions/turn-left.png",
			),
			1 => array(
				"name" => "Right",
				"title" => \Lang\Dictionary::get('map_instructions_right'),
				"icon" => "/assets/images/map/directions/turn-right.png",
			),
			2 => array(
				"name" => "Sharp left",
				"title" => \Lang\Dictionary::get('map_instructions_sharp_left'),
				"icon" => "/assets/images/map/directions/sharp_left.png",
			),
			3 => array(
				"name" => "Sharp right",
				"title" => \Lang\Dictionary::get('map_instructions_sharp_right'),
				"icon" => "/assets/images/map/directions/sharp_right.png",
			),
			4 => array(
				"name" => "Slight left",
				"title" => \Lang\Dictionary::get('map_instructions_slight_left'),
				"icon" => "/assets/images/map/directions/slight_turn-left.png",
			),
			5 => array(
				"name" => "Slight right",
				"title" => \Lang\Dictionary::get('map_instructions_slight_right'),
				"icon" => "/assets/images/map/directions/slight_turn-right.png",
			),
			6 => array(
				"name" => "Straight",
				"title" => \Lang\Dictionary::get('map_instructions_straight'),
				"icon" => "/assets/images/map/directions/straight-up-arrow.png",
			),
			7 => array(
				"name" => "Enter roundabout",
				"title" => \Lang\Dictionary::get('map_instructions_enter_roundabout'),
				"icon" => "/assets/images/map/directions/roundabout_enter.png",
			),
			8 => array(
				"name" => "Exit roundabout",
				"title" => \Lang\Dictionary::get('map_instructions_exit_roundabout'),
				"icon" => "/assets/images/map/directions/roundabout_exit.png",
			),
			9 => array(
				"name" => "U-turn",
				"title" => \Lang\Dictionary::get('map_instructions_u_turn'),
				"icon" => "/assets/images/map/directions/u-turn.png",
			),
			10 => array(
				"name" => "Goal",
				"title" => \Lang\Dictionary::get('map_instructions_goal'),
				"icon" => "/assets/images/map/directions/goal.png",
			),
			11 => array(
				"name" => "Depart",
				"title" => \Lang\Dictionary::get('map_instructions_depart'),
				"icon" => "/assets/images/map/directions/departure.png",
			),
			12 => array(
				"name" => "Keep left",
				"title" => \Lang\Dictionary::get('map_instructions_keep_left'),
				"icon" => "/assets/images/map/directions/keep_left.png",
			),
			13 => array(
				"name" => "Keep right",
				"title" => \Lang\Dictionary::get('map_instructions_keep_right'),
				"icon" => "/assets/images/map/directions/keep_right.png",
			),
		);
	}

	public static function startCoordinates() {
		$coords = array(
			"lat" => 38.714111,
			"lon" => -9.136583,
			"z" => 10,
		);

		foreach($coords as $key => $val) {
			if (exists($_REQUEST[$key])) {
				$coords[$key] = $_REQUEST[$key];
			}
		}		

		return $coords;
	}

	public static function directions($from_lat, $from_lng, $to_lat, $to_lng) {
		/*
		https://github.com/GIScience/openrouteservice-docs
		*/
		$apiKey = SITE_CONFIGS['api']['openrouteservice']['key'];

		$routeMethod = 'driving-car';

		$link = "https://api.openrouteservice.org/v2/directions/{$routeMethod}?api_key={$apiKey}&start={$from_lng},{$from_lat}&end={$to_lng},{$to_lat}";

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $link);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);

		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		  "Accept: application/json, application/geo+json, application/gpx+xml, img/png; charset=utf-8"
		));

		$response = curl_exec($ch);
		curl_close($ch);

		$response = json_decode($response, true);

		if (!exists(self::$instructionTypes)) {
			self::instructionTypesInfo();
		}

		//Lat & Lng are in the wrong order (lng is coming first from the api)
		$coordinates_out = array();
		$coordinates = $response['features'][0]['geometry']['coordinates'];

		$output = array();
		foreach($coordinates as $coordinate_key => $coordinate) {
			$output['coordinates'][$coordinate_key] = array(
				0 => $coordinate[1],
				1 => $coordinate[0],
			);
		}

		//$output['steps'] = $response['features'][0]['properties']['segments'][0]['steps'];
		foreach($response['features'][0]['properties']['segments'][0]['steps'] as $step_key => $step) {
			$id_type = $step['type'];
			$type = self::$instructionTypes[$id_type];
			$type['id'] = $id_type;

			$step['type'] = $type;

			$output['steps'][$step_key] = $step;
		}

		$output['distance'] = $response['features'][0]['properties']['segments'][0]['distance'];
		$output['duration'] = $response['features'][0]['properties']['segments'][0]['duration'];
		$output['full'] = $response;

		return $output;
	}

}