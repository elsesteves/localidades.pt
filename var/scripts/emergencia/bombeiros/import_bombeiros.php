<?php

require_once __DIR__.'/../../inc/bootstrap.php';
require_once __DIR__.'/../../inc/functions.php';

$lang_id = 2;//PT
$module = "md_emergencia_bombeiros";

$data = \Data\External\Spreadsheet::getData(__DIR__.'/bombeiros.xlsx');
$rows = $data['body'];


foreach($rows as $row) {
	var_dump($row);

	if (strpos($row['coordenadas_geográficas'], 'Point(') === false) {
		continue;
	}

	$coords = str_replace(array('Point(', ')'), '', $row['coordenadas_geográficas']);
	$coords = explode(' ', $coords);

	var_dump($coords);

	$gps = array(
		"lon" => $coords[0],
		"lat" => $coords[1],
	);

	$local = findLocalidadeByGPSCoords($gps['lat'], $gps['lon']);

	var_dump($local);

	if (!exists($local)) {
		continue;
	}

	$name = \DB::escape_string($row['itemLabel']);

	$zipCode = \DB::escape_string($local['codigo_postal']);

	$id_distrito = findLocalidadeID($local['distrito'], array("id_type" => 1));
	$id_concelho = findLocalidadeID($local['concelho'], array("id_type" => 2, "parent" => $id_distrito));
	$id_freguesia = findLocalidadeID($local['freguesia'], array("id_type" => 3, "parent" => $id_concelho));

	if(empty($id_freguesia)) {
		$id_freguesia = findFreguesiaByCodPostal($zipCode, $id_concelho);
	}
	

	$address = \DB::escape_string($local['rua']);

	$dt_established = '';
	if (!empty($row['data_de_criação_ou_fundação'])) {
		$dt_established = str_replace(array('T', 'Z'), array(' ', ''), $row['data_de_criação_ou_fundação']);
	}

	$timeStamp = \Data\Date::currentTimeStamp();
	$sql = "INSERT INTO {$module} SET
				dt_intro = '{$timeStamp}',
				dt_lastmod = '{$timeStamp}',
				name = '{$name}',";

	if(!empty($id_distrito)) {
		$sql .= " id_distrito = $id_distrito,";
	}
	if(!empty($id_concelho)) {
		$sql .= " id_concelho = $id_concelho,";
	}
	if(!empty($id_freguesia)) {
		$sql .= " id_freguesia = $id_freguesia,";
	}

	$sql .= " address = '". $address ."',
				zip_code = '". $zipCode ."',";

	if(exists($gps['lon']) && exists($gps['lat'])) {
		$sql .= " gps = ST_GeomFromText('POINT(".$gps['lon']." ".$gps['lat'].")'),";
	}

	$sql .= " url = '". \DB::escape_string($row['sítio_web_oficial']) ."',
				ext_img_url = '". \DB::escape_string($row['imagem']) ."',
				active = 1";

	if (!empty($dt_established)) {
		$sql .= ", dt_established = '". $dt_established ."'";
	}

	if(\DB::run($sql)) {
		$id_row = DB::last_insert_id();

		$timeStamp = \Data\Date::currentTimeStamp();
		$sql = "INSERT INTO {$module}_lang SET
					dt_intro = '{$timeStamp}',
					dt_lastmod = '{$timeStamp}',
					id_lang = $lang_id,
					parent = $id_row,
					title = '".$name."',
					active = 1";
		\DB::run($sql);

		print "ROW ID: {$id_row};";
		if(!empty($id_freguesia)) {
			print " ID FREGUESiA: {$id_freguesia};";
		}
		print "\n\n";
	}
}