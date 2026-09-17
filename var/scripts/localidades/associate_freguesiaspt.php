<?php

require_once __DIR__.'/../inc/bootstrap.php';
require_once __DIR__.'/../inc/functions.php';

$lang_id = 2;//PT
$module = "md_localidades";
$baseURL = "http://www.freguesias.pt/";

$localidades = array();


function getFreguesiasPage($url) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch,CURLOPT_ENCODING, 'ISO-8859-1');
	$page = curl_exec($ch);
	$page = mb_convert_encoding($page, 'UTF-8', 'ISO-8859-1');

	curl_close($ch);

	return $page;
}


$url = $baseURL . "portugal.php";
$page = getFreguesiasPage($url);

/*
$pattern = '/ <select name="select" class="texto2_preto" id="select" onchange="MM_jumpMenu\(\'parent\',this,0\)">(.*)<\/select>/ms';
preg_match($pattern, $page, $matches, PREG_OFFSET_CAPTURE, 0);
$distritosList = $matches[1][0];
*/

$pattern = '/<option value="(.*?)">(.*?)<\/option>/m';
preg_match_all($pattern, $page, $districts);

foreach($districts[0] as $districtKey => $district) {

	$pattern = '/value="distrito\.php\?cod=(.*?)"/m';
	preg_match($pattern, $district, $districtID, PREG_OFFSET_CAPTURE, 0);

	$id_freguesiaspt_distrito = $districtID[1][0];
	$districtsLink = $districts[1][$districtKey];

	$localidades['distritos'][$id_freguesiaspt_distrito] = array(
		"id_freguesiaspt" => $id_freguesiaspt_distrito,
		"id_type" => 1,
		"link" => $districtsLink,
		"name" => $districts[2][$districtKey],
		"concelhos" => array(),
	);

	
	$districtPage = getFreguesiasPage($baseURL.$districtsLink);
	$pattern = '/<option value="(.*?)">(.*?)<\/option>/m';
	preg_match_all($pattern, $districtPage, $concelhos);

	foreach($concelhos[0] as $concelhoKey => $concelho) {

		$pattern = '/value="concelho\.php\?cod=(.*?)"/m';
		preg_match($pattern, $concelho, $concelhoID, PREG_OFFSET_CAPTURE, 0);

		$id_freguesiaspt_concelho = $concelhoID[1][0];
		$concelhoLink = $concelhos[1][$concelhoKey];

		$localidades['distritos'][$id_freguesiaspt_distrito]["concelhos"][$id_freguesiaspt_concelho] = array(
			"id_freguesiaspt" => $id_freguesiaspt_concelho,
			"id_type" => 2,
			"link" => $concelhoLink,
			"name" => $concelhos[2][$concelhoKey],
			"freguesias" => array(),
		);


		$concelhoPage = getFreguesiasPage($baseURL.$concelhoLink);
		$pattern = '/<option value="(.*?)">(.*?)<\/option>/m';
		preg_match_all($pattern, $concelhoPage, $freguesias);

		foreach($freguesias[0] as $freguesiaKey => $freguesia) {

			$pattern = '/value="freguesia\.php\?cod=(.*?)"/m';
			preg_match($pattern, $freguesia, $freguesiaID, PREG_OFFSET_CAPTURE, 0);

			$id_freguesiaspt_freguesia = $freguesiaID[1][0];
			$freguesiaLink = $freguesias[1][$freguesiaKey];

			$localidades['distritos'][$id_freguesiaspt_distrito]["concelhos"][$id_freguesiaspt_concelho]["freguesias"][$id_freguesiaspt_freguesia] = array(
				"id_freguesiaspt" => $id_freguesiaspt_freguesia,
				"id_type" => 3,
				"link" => $freguesiaLink,
				"name" => $freguesias[2][$freguesiaKey],
			);
		}
	}


	
}

//var_dump($localidades);


foreach($localidades['distritos'] as $distrito) {
	$id_distrito = findLocalidadeID($distrito['name'], array("id_type" => $distrito['id_type']));

	$sql = "UPDATE md_localidades SET
				id_freguesiaspt = '".$distrito['id_freguesiaspt']."'
			WHERE id = ".$id_distrito;

	print "DIST: ".$distrito['name']."|".$id_distrito."|".$sql."\n\n";
	\DB::run($sql);

	foreach($distrito['concelhos'] as $concelho) {
		$id_concelho = findLocalidadeID($concelho['name'], array("id_type" => $concelho['id_type'], "parent" => $id_distrito));

		$sql = "UPDATE md_localidades SET
					id_freguesiaspt = '".$concelho['id_freguesiaspt']."'
				WHERE id = ".$id_concelho;

		print "CONC: ".$concelho['name']."|".$id_concelho."|".$sql."\n\n";
		\DB::run($sql);

		foreach($concelho['freguesias'] as $freguesia) {
			$id_freguesia = findLocalidadeID($freguesia['name'], array("id_type" => $freguesia['id_type'], "parent" => $id_concelho));

			if(exists($id_freguesia)) {
				$sql = "UPDATE md_localidades SET
							id_freguesiaspt = '".$freguesia['id_freguesiaspt']."'
						WHERE id = ".$id_freguesia;

				print "FREG: ".$freguesia['name']."|".$id_freguesia."|".$sql."\n\n";
				\DB::run($sql);
			} else {
				$id_freguesia = checkFreguesiaPrior2Union($freguesia['name'], $id_concelho);

				if(!empty($id_freguesia)) {
					$sql = "SELECT id_freguesiaspt FROM md_localidades WHERE id = ".$id_freguesia;
					$row = \DB::results($sql, true);

					$row_freguesiaspt_ids = explode(';', $row['id_freguesiaspt']);
					if (!in_array($freguesia['id_freguesiaspt'], $row_freguesiaspt_ids)) {
						array_push($row_freguesiaspt_ids, $freguesia['id_freguesiaspt']);

						$sql = "UPDATE md_localidades SET
									id_freguesiaspt = '". \DB::escape_string(implode(';', $row_freguesiaspt_ids)) ."'
								WHERE id = ".$id_freguesia;

						print "FREG: ".$freguesia['name']."|".$id_freguesia."|".$sql."\n\n";
						\DB::run($sql);
					}
				}
				
			}

			
		}
	}
}
print 'SCRIPT ENDED!!';