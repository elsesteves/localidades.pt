<?php

require_once __DIR__.'/../inc/bootstrap.php';
require_once __DIR__.'/../inc/functions.php';

$lang_id = 2;//PT

$cycles = array(
	"Pré-escolar" => 1,
	"1º Ciclo" => 2,
	"2º Ciclo" => 3,
	"3º Ciclo" => 4,
	"Secundário" => 5,
	"Profissional" => 6,
	"Artistico" => 7,
	"Extra-escolar" => 8,
);

$instNature = array(
	"Publico" => 1,
	"Privado" => 2,
);


$data = \Data\External\Spreadsheet::getData(__DIR__.'/RedeEscolas_listaescolas.xlsx');
$rows = $data['body'];

function getAgrupamentoID($coduome) {
	$coduome = \DB::escape_string($coduome);

	$sql = "SELECT id 
			FROM md_escolas_agrupamentos 
			WHERE coduome = '{$coduome}'";

	$rows = \DB::results($sql);

	if (!empty($rows)) {
		foreach($rows as $row) {
			return $row['id'];
		}
	}

	return false;
}

foreach($rows as $row) {
	var_dump($row);

	$name = \DB::escape_string($row['NOME']);

	$id_agrupamento = getAgrupamentoID($row['CODUOME']);

	$id_distrito = findLocalidadeID($row['DISTRITO'], array("id_type" => 1));
	$id_concelho = findLocalidadeID($row['CONCELHO'], array("id_type" => 2, "parent" => $id_distrito));
	$id_freguesia = findLocalidadeID($row['LOCALIDADE'], array("id_type" => 3, "parent" => $id_concelho));

	$id_instNature = $instNature[$row['GRUPONATUREZAINST']] ? $instNature[$row['GRUPONATUREZAINST']] : 0;

	$zipCode = \DB::escape_string($row['CP']);
	$gps = findGPSCoordsByCodPostal($zipCode);

	$emails = explode('; ', $row['EMAIL']);
	$phones = array();

	if (!empty($row['TELEFONE1'])) {
		array_push($phones, $row['TELEFONE1']);
	}

	if (!empty($row['TELEFONE2'])) {
		array_push($phones, $row['TELEFONE2']);
	}

	$cycles2school = array();
	$cyclesTxt = explode(';', $row['CICLO']);
	foreach($cyclesTxt as $cycleTxt) {
		if (isset($cycles[$cycleTxt])) {
			$id_cycle = $cycles[$cycleTxt];
			array_push($cycles2school, $id_cycle);
		}
	}


	$timeStamp = \Data\Date::currentTimeStamp();
	$sql = "INSERT INTO md_escolas SET
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

	$sql .= " codigo_escola = '". \DB::escape_string($row['CODIGO']) ."',
				address = '". \DB::escape_string($row['MORADA']) ."',
				zip_code = '". $zipCode ."',
				gps = ST_GeomFromText('POINT(".$gps['lon']." ".$gps['lat'].")'),
				institutional_nature = '". $id_instNature ."',
				url = '". \DB::escape_string($row['URL']) ."',
				active = 1";

	if(\DB::run($sql)) {
		$id_escola = DB::last_insert_id();

		$timeStamp = \Data\Date::currentTimeStamp();
		$sql = "INSERT INTO md_escolas_lang SET
					dt_intro = '{$timeStamp}',
					dt_lastmod = '{$timeStamp}',
					id_lang = $lang_id,
					parent = $id_escola,
					title = '".$name."',
					active = 1";
		\DB::run($sql);


		foreach($emails as $email) {
			if (empty($email)) {
				continue;
			}

			$email = \DB::escape_string($email);

			$timeStamp = \Data\Date::currentTimeStamp();
			$sql = "INSERT INTO md_escolas_emails SET
						dt_intro = '{$timeStamp}',
						dt_lastmod = '{$timeStamp}',
						id_lang = $lang_id,
						parent = $id_escola,
						value = '".$email."'";
			\DB::run($sql);
		}

		foreach($phones as $phone) {
			if (empty($phone)) {
				continue;
			}

			$phone = \DB::escape_string($phone);

			$timeStamp = \Data\Date::currentTimeStamp();
			$sql = "INSERT INTO md_escolas_phones SET
						dt_intro = '{$timeStamp}',
						dt_lastmod = '{$timeStamp}',
						id_lang = $lang_id,
						parent = $id_escola,
						value = '".$phone."'";
			\DB::run($sql);
		}

		foreach($cycles2school as $id_cycle) {
			if (empty($id_cycle)) {
				continue;
			}

			$id_cycle = (int) \DB::escape_string($id_cycle);

			$timeStamp = \Data\Date::currentTimeStamp();
			$sql = "INSERT INTO md_escolas2ciclos SET
						dt_intro = '{$timeStamp}',
						dt_lastmod = '{$timeStamp}',
						id_escola = $id_escola,
						id_ciclo = '".$id_cycle."',
						active = 1";
			\DB::run($sql);
		}
		
	}
}