<?php

require_once __DIR__.'/../../inc/bootstrap.php';
require_once __DIR__.'/../../inc/functions.php';

$lang_id = 2;//PT
$module = "md_policias";
$id_type = 2; //GNR 1->PSP

$data = \Data\External\Spreadsheet::getData(__DIR__.'/postos_gnr.xlsx');
$rows = $data['body'];

$zipCodePattern = '/(\d{4}-\d{3})/m';

foreach($rows as $row) {
	//var_dump($row);

	$name = \DB::escape_string(ucwords(strtolower($row['unidade'])));
	$address = \DB::escape_string($row['morada']);

	preg_match($zipCodePattern, $address, $matches, PREG_OFFSET_CAPTURE, 0);

	$zipCode = null;
	if (exists($matches[0][0])) {
		$zipCode= \DB::escape_string($matches[0][0]);
	}

	$gps = $id_distrito = $id_concelho = $id_freguesia = null;
	if(exists($zipCode)) {
		$gps = findGPSCoordsByCodPostal($zipCode);

		$local = findGPSCoordsByCodPostal($zipCode);

		if(!empty($local)) {
			$id_distrito = findLocalidadeID($local['distrito'], array("id_type" => 1));
			$id_concelho = findLocalidadeID($local['concelho'], array("id_type" => 2, "parent" => $id_distrito));
			$id_freguesia = findLocalidadeID($local['freguesia'], array("id_type" => 3, "parent" => $id_concelho));
		}
	}

	$timeStamp = \Data\Date::currentTimeStamp();
	$sql = "INSERT INTO {$module} SET
				dt_intro = '{$timeStamp}',
				dt_lastmod = '{$timeStamp}',
				name = '{$name}',
				id_type = {$id_type},";

	if(exists($id_distrito)) {
		$sql .= " id_distrito = $id_distrito,";
	}
	if(exists($id_concelho)) {
		$sql .= " id_concelho = $id_concelho,";
	}
	if(exists($id_freguesia)) {
		$sql .= " id_freguesia = $id_freguesia,";
	}
	if(exists($address)) {
		$sql .= " address = '".$address."',";
	}

	$sql .= " zip_code = '". $zipCode ."',";

	if(exists($gps['lon']) && exists($gps['lat'])) {
		$sql .= " gps = ST_GeomFromText('POINT(".$gps['lon']." ".$gps['lat'].")'),";
	}

	$sql .= " active = 1";

	//dd($sql);
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
			print " ID FREGUESIA: {$id_freguesia};";
		}
		print "\n\n";
	}
}