<?php

require_once __DIR__.'/../inc/bootstrap.php';
require_once __DIR__.'/../inc/functions.php';

$data = \Data\External\Spreadsheet::getData(__DIR__.'/RedeUO_ListaEscolas_unidadesorganicas.xlsx');

$rows = $data['body'];
//var_dump($rows);

$lang_id = 2;//PT

$instNature = array(
	"Publico" => 1,
	"Privado" => 2,
);

foreach($rows as $row) {
	$id_distrito = findLocalidadeID($row['DISTRITO'], array("id_type" => 1));
	$id_concelho = findLocalidadeID($row['CONCELHO'], array("id_type" => 2, "parent" => $id_distrito));
	$id_freguesia = findLocalidadeID($row['LOCALIDADE'], array("id_type" => 3, "parent" => $id_concelho));

	$name = \DB::escape_string($row['NOME']);

	$id_instNature = $instNature[$row['GRUPONATUREZAINST']] ? $instNature[$row['GRUPONATUREZAINST']] : 0;

	$zipCode = \DB::escape_string($row['CP']);

	$emails = explode('; ', $row['EMAIL']);
	$phones = array();

	if (!empty($row['TELEFONE1'])) {
		array_push($phones, $row['TELEFONE1']);
	}

	if (!empty($row['TELEFONE2'])) {
		array_push($phones, $row['TELEFONE2']);
	}

	$timeStamp = \Data\Date::currentTimeStamp();
	$sql = "INSERT INTO md_escolas_agrupamentos SET
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

	$sql .= " coduome = '". \DB::escape_string($row['CODUOME']) ."',
				address = '". \DB::escape_string($row['MORADA']) ."',
				zip_code = '". $zipCode ."',
				institutional_nature = '". $id_instNature ."',
				url = '". \DB::escape_string($row['URL']) ."',
				tax_id = '". \DB::escape_string($row['NIF']) ."',
				active = 1";

	if(\DB::run($sql)) {
		$id_agrupamento = DB::last_insert_id();

		$timeStamp = \Data\Date::currentTimeStamp();
		$sql = "INSERT INTO md_escolas_agrupamentos_lang SET
					dt_intro = '{$timeStamp}',
					dt_lastmod = '{$timeStamp}',
					id_lang = $lang_id,
					parent = $id_agrupamento,
					title = '".$name."',
					active = 1";
		\DB::run($sql);


		foreach($emails as $email) {
			if (empty($email)) {
				continue;
			}

			$email = \DB::escape_string($email);

			$timeStamp = \Data\Date::currentTimeStamp();
			$sql = "INSERT INTO md_escolas_agrupamentos_emails SET
						dt_intro = '{$timeStamp}',
						dt_lastmod = '{$timeStamp}',
						id_lang = $lang_id,
						parent = $id_agrupamento,
						value = '".$email."'";
			\DB::run($sql);
		}

		foreach($phones as $phone) {
			if (empty($phone)) {
				continue;
			}

			$phone = \DB::escape_string($phone);

			$timeStamp = \Data\Date::currentTimeStamp();
			$sql = "INSERT INTO md_escolas_agrupamentos_phones SET
						dt_intro = '{$timeStamp}',
						dt_lastmod = '{$timeStamp}',
						id_lang = $lang_id,
						parent = $id_agrupamento,
						value = '".$phone."'";
			\DB::run($sql);
		}
		
	}
}

dd('SCRIPT ENDED!!');