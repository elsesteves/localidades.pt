<?php

namespace Controllers\Tools;

Class Weather {

	public static function api() {
	    if (isset($_GET['lat']) && isset($_GET['lon'])) {
			$info = \Models\Tools\Weather::getData($_GET['lat'], $_GET['lon'], 5, \Lang\Lang::fetchCurrentLangRef());
			json_return($info, 200);
	    } else {
	    	json_return(array(
	    		"name" => 'Bad Request',
	    		"message" => "Missing latitude and/or longitude."
			) , 400);
		}
	}
}