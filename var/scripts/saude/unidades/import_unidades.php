<?php

require_once __DIR__.'/../../inc/bootstrap.php';
require_once __DIR__.'/../../inc/functions.php';

$lang_id = 2;//PT

$data = \Data\External\Spreadsheet::getData(__DIR__.'/hospitais.xlsx');
$rows = $data['body'];

$nature = array(
	"Público" => "1",
	"Privados" => "2",
);


foreach($rows as $row) {
	//dd($row);

	$id_nature = $nature[$row['Natureza']] ? $nature[$row['Natureza']] : 0;

	$name = \DB::escape_string($row['Entidade']);

	$zipCode = \DB::escape_string($row['Código Postal']);
	$zipCode = str_replace(' ', '', $zipCode);
	$gps = findGPSCoordsByCodPostal($zipCode);

	$id_distrito = findLocalidadeID($row['Distrito'], array("id_type" => 1));
	$id_concelho = findLocalidadeID($row['Concelho'], array("id_type" => 2, "parent" => $id_distrito));
	//$id_freguesia = findLocalidadeID($row['Localidade'], array("id_type" => 3, "parent" => $id_concelho));

	$id_freguesia = findFreguesiaByCodPostal($zipCode, $id_concelho);

	$address = \DB::escape_string($row['Morada']);

	$timeStamp = \Data\Date::currentTimeStamp();
	$sql = "INSERT INTO md_saude_unidades SET
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

	$sql .= " tax_id = '". \DB::escape_string($row['NIF / NIPC']) ."',
				nature = ". $id_nature .",
				active = 1";

	if(\DB::run($sql)) {
		$id_row = DB::last_insert_id();

		$timeStamp = \Data\Date::currentTimeStamp();
		$sql = "INSERT INTO md_saude_unidades_lang SET
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