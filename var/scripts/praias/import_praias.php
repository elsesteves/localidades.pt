<?php

require_once __DIR__.'/../inc/bootstrap.php';
require_once __DIR__.'/../inc/functions.php';

$lang_id = 2;//PT
$module = "md_praias";
$id_type=2; //Fluviais

$data = \Data\External\Spreadsheet::getData(__DIR__.'/praias_fluviais.xlsx');
$rows = $data['body'];

foreach($rows as $row) {
	//var_dump($row);

	if (strpos($row['gps_coords'], 'Point(') === false) {
		continue;
	}

	$wikidata_id = str_replace('http://www.wikidata.org/entity/', '', $row['beach']);

	$coords = str_replace(array('Point(', ')'), '', $row['gps_coords']);
	$coords = explode(' ', $coords);

	$gps = array(
		"lon" => $coords[0],
		"lat" => $coords[1],
	);

	$local = findLocalidadeByGPSCoords($gps['lat'], $gps['lon']);

	//var_dump($local);

	$name = \DB::escape_string($row['beachLabel']);

	$zipCode = \DB::escape_string($local['codigo_postal']);

	$id_distrito = findLocalidadeID($local['distrito'], array("id_type" => 1));
	$id_concelho = findLocalidadeID($local['concelho'], array("id_type" => 2, "parent" => $id_distrito));
	$id_freguesia = findLocalidadeID($local['freguesia'], array("id_type" => 3, "parent" => $id_concelho));

	if(empty($id_freguesia)) {
		$id_freguesia = findFreguesiaByCodPostal($zipCode, $id_concelho);
	}

	$timeStamp = \Data\Date::currentTimeStamp();
	$sql = "INSERT INTO {$module} SET
				dt_intro = '{$timeStamp}',
				dt_lastmod = '{$timeStamp}',
				name = '{$name}',";

	if (!empty($id_type)) {
		$sql .= " id_type = $id_type,";
	}

	if(!empty($id_distrito)) {
		$sql .= " id_distrito = $id_distrito,";
	}
	if(!empty($id_concelho)) {
		$sql .= " id_concelho = $id_concelho,";
	}
	if(!empty($id_freguesia)) {
		$sql .= " id_freguesia = $id_freguesia,";
	}

	if(exists($zipCode)) {
		$sql .= " zip_code = '". $zipCode ."',";
	}	

	if(exists($gps['lon']) && exists($gps['lat'])) {
		$sql .= " gps = ST_GeomFromText('POINT(".$gps['lon']." ".$gps['lat'].")'),";
	}

	if(!empty($row['image'])) {
		$sql .= " ext_img_url = '". \DB::escape_string($row['image']) ."',";
	}

	$sql .= " wikidata_id = '".$wikidata_id."',";

	$sql .= " active = 1";

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