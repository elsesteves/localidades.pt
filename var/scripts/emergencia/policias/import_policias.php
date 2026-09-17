<?php

require_once __DIR__.'/../../inc/bootstrap.php';
require_once __DIR__.'/../../inc/functions.php';

$lang_id = 2;//PT
$module = "md_policias";

$data = \Data\External\Spreadsheet::getData(__DIR__.'/esquadras.xlsx');
$rows = $data['body'];


foreach($rows as $row) {
	//var_dump($row);

	$name = \DB::escape_string($row['UNIDADE']);

	$zipCode = \DB::escape_string($row['CÓD. POSTAL']);
	$gps = findGPSCoordsByCodPostal($zipCode);

	$local = findGPSCoordsByCodPostal($zipCode);

	if(!empty($local)) {
		$id_distrito = findLocalidadeID($local['distrito'], array("id_type" => 1));
		$id_concelho = findLocalidadeID($local['concelho'], array("id_type" => 2, "parent" => $id_distrito));
		$id_freguesia = findLocalidadeID($local['freguesia'], array("id_type" => 3, "parent" => $id_concelho));
		$address = \DB::escape_string($local['morada']);
	}

	$emails = explode('; ', $row['EMAIL']);
	$phones = explode('; ', $row['TELEFONE']);

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
	if(!empty($address)) {
		$sql .= " address = '".$address."',";
	}

	$sql .= " zip_code = '". $zipCode ."',";

	if(exists($gps['lon']) && exists($gps['lat'])) {
		$sql .= " gps = ST_GeomFromText('POINT(".$gps['lon']." ".$gps['lat'].")'),";
	}

	$sql .= " active = 1";

	//print $sql;
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

		foreach($emails as $email) {
			if (empty($email)) {
				continue;
			}

			$email = \DB::escape_string($email);

			$timeStamp = \Data\Date::currentTimeStamp();
			$sql = "INSERT INTO {$module}_emails SET
						dt_intro = '{$timeStamp}',
						dt_lastmod = '{$timeStamp}',
						id_lang = $lang_id,
						parent = $id_row,
						value = '".$email."'";
			\DB::run($sql);
		}

		foreach($phones as $phone) {
			if (empty($phone)) {
				continue;
			}

			$phone = \DB::escape_string($phone);

			$timeStamp = \Data\Date::currentTimeStamp();
			$sql = "INSERT INTO {$module}_phones SET
						dt_intro = '{$timeStamp}',
						dt_lastmod = '{$timeStamp}',
						id_lang = $lang_id,
						parent = $id_row,
						value = '".$phone."'";
			\DB::run($sql);
		}
	}
}