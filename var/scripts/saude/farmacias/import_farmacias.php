<?php

require_once __DIR__.'/../../inc/bootstrap.php';
require_once __DIR__.'/../../inc/functions.php';

$lang_id = 2;//PT

$data = \Data\External\Spreadsheet::getData(__DIR__.'/Infarmed_ResultadosDePesquisa_FarmaciasLista.xls');
$rows = $data['body'];


foreach($rows as $row) {
	var_dump($row);

	$name = \DB::escape_string($row['Farmácia']);

	$zipCode = \DB::escape_string($row['Código Postal']);
	$gps = findGPSCoordsByCodPostal($zipCode);

	$id_distrito = findLocalidadeID($row['Distrito'], array("id_type" => 1));
	$id_concelho = findLocalidadeID($row['Concelho'], array("id_type" => 2, "parent" => $id_distrito));
	$id_freguesia = findLocalidadeID($row['Freguesia'], array("id_type" => 3, "parent" => $id_concelho));

	if(empty($id_freguesia)) {
		$id_freguesia = findFreguesiaByCodPostal($zipCode, $id_concelho);
	}

	$address = \DB::escape_string($row['Arruamento']);

	if (!empty($row['Freguesia'])) {
		$address .= ", ". \DB::escape_string($row['Freguesia']);
	} else {
		if(!empty($row['Localidade'])) {
			$localidade = \DB::escape_string($row['Localidade']);
			$address .= ", ".ucwords(strtolower($localidade));
		}		 
	}

	$timeStamp = \Data\Date::currentTimeStamp();
	$sql = "INSERT INTO md_saude_farmacias SET
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

	if(!empty($id_agrupamento)) {
		$sql .= " id_agrupamento = $id_agrupamento,";
	}

	$sql .= " address = '". $address ."',
				zip_code = '". $zipCode ."',
				gps = ST_GeomFromText('POINT(".$gps['lon']." ".$gps['lat'].")'),
				tax_id = '". \DB::escape_string($row['NIF / NIPC']) ."',
				management = '". \DB::escape_string($row['Propriedade/ Exploração']) ."',
				alvara_num = '". (int) $row['Nº do Alvará'] ."',
				active = 1";

	if(\DB::run($sql)) {
		$id_row = DB::last_insert_id();

		$timeStamp = \Data\Date::currentTimeStamp();
		$sql = "INSERT INTO md_saude_farmacias_lang SET
					dt_intro = '{$timeStamp}',
					dt_lastmod = '{$timeStamp}',
					id_lang = $lang_id,
					parent = $id_row,
					title = '".$name."',
					active = 1";
		\DB::run($sql);

		print "\nID: {$id_row};\n\n";
	}
	
}

print "\n\nSCRIPT ENDED!!!";