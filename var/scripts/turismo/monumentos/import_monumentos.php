<?php

require_once __DIR__.'/../../inc/bootstrap.php';
require_once __DIR__.'/../../inc/functions.php';

$lang_id = 2;//PT
$module = "md_turismo_monumentos";


$tipos = array(); //wikidata_id => internal_id
$monumentos = array(); //wikidata_id => internal_id

$data = \Data\External\Spreadsheet::getData(__DIR__.'/monumentos.xlsx');
$rows = $data['body'];

foreach($rows as $row) {
	var_dump($row);

	$wikidata_id = str_replace('http://www.wikidata.org/entity/', '', $row['monument']);

	if (!exists($monumentos[$wikidata_id])) {
		if (strpos($row['gps_coords'], 'Point(') === false) {
			continue;
		}

		$coords = str_replace(array('Point(', ')'), '', $row['gps_coords']);
		$coords = explode(' ', $coords);

		$gps = array(
			"lon" => $coords[0],
			"lat" => $coords[1],
		);

		$local = findLocalidadeByGPSCoords($gps['lat'], $gps['lon']);

		$name = \DB::escape_string($row['monumentLabel']);

		$zipCode = \DB::escape_string($local['codigo_postal']);

		$id_distrito = findLocalidadeID($local['distrito'], array("id_type" => 1));
		$id_concelho = findLocalidadeID($local['concelho'], array("id_type" => 2, "parent" => $id_distrito));
		$id_freguesia = findLocalidadeID($local['freguesia'], array("id_type" => 3, "parent" => $id_concelho));

		if(empty($id_freguesia)) {
			$id_freguesia = findFreguesiaByCodPostal($zipCode, $id_concelho);
		}

		$address = \DB::escape_string($row['locationLabel']);

		$sipa_id = '';
		if (!empty($row['sipa_id'])) {
			$sipa_id = (int) $row['sipa_id'];
		}

		$wlm_id = '';
		$dgpc_id = '';
		if(!empty($row['idwlm'])) {
			$wlm_id = $row['idwlm'];
			if (strpos($row['idwlm'], 'DGPC-') !== false) {
				$dgpc_id = str_replace('DGPC-', '', $row['idwlm']);
			}
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

		if(!empty($row['image'])) {
			$sql .= " ext_img_url = '". \DB::escape_string($row['image']) ."',";
		}

		$sql .= " wikidata_id = '".$wikidata_id."',";

		if(!empty($sipa_id)) {
			$sql .= " sipa_id = '".$sipa_id."',";
		}
		if(!empty($dgpc_id)) {
			$sql .= " dgpc_id = '".$dgpc_id."',";
		}
		if(!empty($wlm_id)) {
			$sql .= " wlm_id = '".$wlm_id."',";
		}

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

			$monumentos[$wikidata_id] = $id_row;
		}
	} else {
		$id_row = $monumentos[$wikidata_id];
	}


	$wikidata_type_id = str_replace('http://www.wikidata.org/entity/', '', $row['type']);
	if (!exists($tipos[$wikidata_type_id])) {
		$timeStamp = \Data\Date::currentTimeStamp();

		$sql = "INSERT INTO md_turismo_monumentos_tipos SET
					dt_intro = '{$timeStamp}',
					dt_lastmod = '{$timeStamp}',
					name = '".$row['typeLabel']."',
					wikidata_id = '{$wikidata_type_id}',
					active = 1";
		if(\DB::run($sql)) {
			$id_tipo = DB::last_insert_id();

			$sql = "INSERT INTO md_turismo_monumentos_tipos_lang SET
					dt_intro = '{$timeStamp}',
					dt_lastmod = '{$timeStamp}',
					id_lang = $lang_id,
					parent = $id_tipo,
					title = '".$row['typeLabel']."',
					description = '".$row['typeDescription']."',
					active = 1";
			\DB::run($sql);

			$tipos[$wikidata_type_id] = $id_tipo;
		}
	} else {
		$id_tipo = $tipos[$wikidata_type_id];
	}

	$timeStamp = \Data\Date::currentTimeStamp();
	$sql = "INSERT INTO md_turismo_monumentos2tipos SET
				dt_intro = '{$timeStamp}',
				dt_lastmod = '{$timeStamp}',
				id_monumento = '{$id_row}',
				id_tipo = '{$id_tipo}',
				active = 1";
	\DB::run($sql);
}