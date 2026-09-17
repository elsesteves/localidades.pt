<?php

require_once __DIR__.'/../inc/bootstrap.php';
require_once __DIR__.'/../inc/functions.php';

$lang_id = 2;//PT
$module = "md_localidades";

function findLocalidadeByFregName($freg_name, $conc_name) {
	$url = "https://json.geoapi.pt/municipio/".$conc_name."/freguesia/".$freg_name;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	$response = curl_exec($ch);

	$output = array();


	if (!curl_errno($ch)) {
		$data = \json_decode($response, true);

		if(!exists($data)) {
			return false;
		}
		$output = array(
			"codigo_postal" => $data['codigopostal'],
			"url" => $data['sitio'],
		);
	} else {
		$output = false;
	}

	curl_close($ch);
	return $output;
}

function findLocalidadeByConcName($conc_name) {
	$url = "https://json.geoapi.pt/municipio/".$conc_name;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	$response = curl_exec($ch);

	$output = array();


	if (!curl_errno($ch)) {
		$data = \json_decode($response, true);

		if(!exists($data)) {
			return false;
		}
		$output = array(
			"codigo_postal" => $data['codigopostal'] ? $data['codigopostal'] : null,
			"url" => $data['sitio'] ? $data['sitio'] : null,
			"email" => $data['email'] ? $data['email'] : null,
			"phone" => $data['telefone'] ? $data['telefone'] : null,
		);
	} else {
		$output = false;
	}

	curl_close($ch);
	return $output;
}

$sql = "SELECT freg.*, conc.id AS 'id_concelho', conc.name AS 'conc_name', freg.id AS 'id_freguesia', freg.name AS 'freg_name' 
		FROM md_localidades AS freg 
		INNER JOIN md_localidades AS conc 
			ON freg.parent = conc.id 
		WHERE freg.id_type = 3";
$rows = \DB::results($sql);
foreach($rows as $row) {
	$id_localidade = $row['id'];
	$data = findLocalidadeByFregName($row['freg_name'], $row['conc_name']);

	if(exists($data['codigo_postal'])) {
		$cod_postal = $data['codigo_postal'];
	}

	if (!empty($cod_postal)) {
		$gps = findGPSCoordsByCodPostal($cod_postal);
	}


	$timeStamp = \Data\Date::currentTimeStamp();
	$sql = "UPDATE md_localidades SET
				dt_lastmod = '{$timeStamp}',";

	if(exists($cod_postal)) {
		$sql .= " zip_code = '". $cod_postal ."',";
	}
				
	if(exists($gps['lon']) && exists($gps['lat'])) {
		$sql .= " gps = ST_GeomFromText('POINT(".$gps['lon']." ".$gps['lat'].")'),";
	}

	if(exists($data['url'])) {
		$sql .= " url = '". \DB::escape_string($data['url']) ."',";
	}

	$sql .= " active = 1
			WHERE id = ".$id_localidade;

	if(\DB::run($sql)) {
		print "ID CONCELHO: ".$id_localidade.";\n";

		if(exists($data['email'])) {
			$sql = "SELECT * FROM md_localidades_emails WHERE parent = $id_localidade AND value = '".\DB::escape_string($data['email'])."'";
			$rowEmail = \DB::results($sql, true);

			if (empty($rowEmail)) {
				$timeStamp = \Data\Date::currentTimeStamp();
				$sql = "INSERT INTO md_localidades_emails SET
							dt_intro = '{$timeStamp}',
							dt_lastmod = '{$timeStamp}',
							id_lang = $lang_id, 
							parent = $id_localidade,
							value = '".\DB::escape_string($data['email'])."',
							active = 1";
				\DB::run($sql);
			}
		}


		if(exists($data['phone'])) {
			$sql = "SELECT * FROM md_localidades_phones WHERE parent = $id_localidade AND value = '".\DB::escape_string($data['phone'])."'";
			$rowPhone = \DB::results($sql, true);

			if (empty($rowPhone)) {
				$timeStamp = \Data\Date::currentTimeStamp();
				$sql = "INSERT INTO md_localidades_phones SET
							dt_intro = '{$timeStamp}',
							dt_lastmod = '{$timeStamp}',
							id_lang = $lang_id, 
							parent = $id_localidade,
							value = '".\DB::escape_string($data['phone'])."',
							active = 1";
				\DB::run($sql);
			}
		}
	}	
}

