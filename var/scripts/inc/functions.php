<?php

function findLocalidadeID($localidadeName, $options = null) {
	$localidadeName = \DB::escape_string($localidadeName);

	$sql = "SELECT * 
			FROM md_localidades 
			WHERE name LIKE '".$localidadeName."'";

	if (exists($options['id_type'])) {
		$sql .= " AND id_type = ". (int) \DB::escape_string($options['id_type']);
	}

	if (exists($options['parent'])) {
		$sql .= " AND parent = ". (int) \DB::escape_string($options['parent']);
	}

	$rows = \DB::results($sql);
	if (!empty($rows)) {
		foreach($rows as $row) {
			return $row['id'];
		}
	}

	return null;
}

function findLocalidadeByGPSCoords($lat, $lon) {
	$url = 'https://json.geoapi.pt/gps/'.$lat.','.$lon;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	$response = curl_exec($ch);

	$output = array();


	if (!curl_errno($ch)) {
		$data = \json_decode($response, true);

		if(!exists($data) || exists($data['erro'])) {
			return false;
		}
		$output = array(
			"distrito" => $data['distrito'],
			"concelho" => $data['concelho'],
			"freguesia" => $data['freguesia'],
			"codigo_postal" => $data['CP'],
			"rua" => $data['rua'],
		);
	} else {
		$output = false;
	}

	curl_close($ch);
	return $output;
}

function findGPSCoordsByCodPostal($codPostal) {
	$codPostal = str_replace(' ', '', $codPostal);
	//$codPostal = str_replace('-', '', $codPostal); //Remove slash from $cosPostal for API Call
	//$url = 'https://api.duminio.com/ptcp/ptapi5f32b41b76ca01.96613850/'.$codPostal;
	$url = 'https://www.cttcodigopostal.pt/api/v1/db4d2c11d2824ff29fd5160300430961/'.$codPostal;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	$response = curl_exec($ch);

	$output = array();


	if (!curl_errno($ch)) {
		$data = \json_decode($response, true);

		if(!isset($data[0])) {
			return false;
		}
		$output = array(
			"distrito" => $data[0]['distrito'],
			"concelho" => $data[0]['concelho'],
			"freguesia" => $data[0]['freguesia'],
			"lat" => $data[0]['latitude'],
			"lon" => $data[0]['longitude'],
			"morada" => $data[0]['morada'],
		);
	} else {
		$output = false;
	}

	curl_close($ch);
	return $output;
}

function findFreguesiaByCodPostal($codPostal, $id_concelho = null) {
	$id_type = 3;

	$location = findGPSCoordsByCodPostal($codPostal);

	if(!isset($location['freguesia'])) {
		return false;
	}


	$freguesiaName = \DB::escape_string($location['freguesia']);

	/*Check if freguesia is in the database*/
	$sql = "SELECT *
			FROM md_localidades
			WHERE id_type = $id_type
				AND name LIKE '{$freguesiaName}'";

	if(!empty($id_concelho)) {
		$sql .= " AND parent = ". (int) $id_concelho;
	}

	$rows = \DB::results($sql);
	if(!empty($rows)) {
		foreach($rows as $row) {
			return $row['id'];
		}
	}
	
	/*Check if freguesia has been united*/
	return checkFreguesiaPrior2Union($freguesiaName, $id_concelho);
}

function checkFreguesiaPrior2Union($freguesiaName, $id_concelho = null) {
	$id_type = 3;

	$sql = "SELECT *
			FROM md_freguesias_prior2union 
			WHERE old_name LIKE '{$freguesiaName}'";

	if(!empty($id_concelho)) {
		$sql .= " AND id_localidade = ". (int) $id_concelho;
	}

	$rows = \DB::results($sql);
	if(!empty($rows)) {
		//Freguesia was found -> Return new id_freguesia
		foreach($rows as $row) {
			return $row['id_localidade'];
		}

	} else {
		/*Check if freguesia is within a freguesia
			Probably resulting from a union of freguesias

			If match found -> register union, add to DB and return new id_freguesia
		*/

		$sql = "SELECT *
			FROM md_localidades
			WHERE id_type = $id_type
				AND name LIKE '%{$freguesiaName}%'";

		if(!empty($id_concelho)) {
			$sql .= " AND parent = ". (int) $id_concelho;
		}

		$rows = \DB::results($sql);
		if(!empty($rows)) {
			foreach($rows as $row) {
				$id = $row['id'];
				$name = $row['name'];
				$timeStamp = \Data\Date::currentTimeStamp();

				$sql = "INSERT INTO md_freguesias_prior2union SET
							dt_intro = '{$timeStamp}',
							dt_lastmod = '{$timeStamp}',
							id_localidade = '{$id}',
							old_name = '{$freguesiaName}',
							active = 1";
				\DB::run($sql);

				return $id;
			}
		}
	}

	return false;
}