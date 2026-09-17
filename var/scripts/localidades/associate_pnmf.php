<?php

require_once __DIR__.'/../inc/bootstrap.php';
require_once __DIR__.'/../inc/functions.php';

$lang_id = 2;//PT
$module = "md_localidades";
$baseURL = "https://www.municipiosefreguesias.pt/";

$localidades = array();


function getPNMFsPage($url, $postFields = array()) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);

	if(!empty($postFields)) {
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
	}

	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
	//curl_setopt($ch,CURLOPT_ENCODING, 'ISO-8859-1');
	$page = curl_exec($ch);
	//$page = mb_convert_encoding($page, 'UTF-8', 'ISO-8859-1');

	curl_close($ch);

	//Removing line breaks
	$page = str_replace(array("\r", "\n"), '', $page);

	//Removing white space between elements
	$page = str_replace("> ", ">§", $page);
	$page = str_replace(" <", "§<", $page);
	$hasSpace = true;
	while($hasSpace) {
		if (strpos($page, "§ ") !== false) {
			$page = str_replace("§ ", '§', $page);
		} elseif (strpos($page, " §") !== false) {
			$page = str_replace(" §", '§', $page);
		} else {
			$hasSpace = false;
		}
	}
	$page = str_replace("§", "", $page);

	return $page;
}

$url = $baseURL . "freguesias/";
$page = getPNMFsPage($url);


$pattern = '/<div class="entry-meta" style="cursor:pointer;" onclick="getmunicipios\(\'(.*?)\'\)">(.*?)<\/div>/m';
preg_match_all($pattern, $page, $districts);


foreach($districts[0] as $districtKey => $district) {
	$id_pnmf_distrito = $districts[1][$districtKey];

	$localidades['distritos'][$id_pnmf_distrito] = array(
		"id_pnmf" => $id_pnmf_distrito,
		"id_type" => 1,
		"name" => $districts[2][$districtKey],
		"concelhos" => array(),
	);

	$postFields = array(
		"flag" => "gmunicipiosjuntas",
		"id_distrito" => $id_pnmf_distrito,
		"c" => "1",
	);
	$districtPage = getPNMFsPage($baseURL."requestapi.php", $postFields);

	$pattern = '/<div class="entry-meta" style="cursor:pointer;" onclick="getjuntas\(\'(.*?)\'\)">(.*?)<\/div>/m';
	preg_match_all($pattern, $districtPage, $concelhos);

	foreach($concelhos[0] as $concelhoKey => $concelho) {
		$id_pnmf_concelho = $concelhos[1][$concelhoKey];

		$localidades['distritos'][$id_pnmf_distrito]["concelhos"][$id_pnmf_concelho] = array(
			"id_pnmf" => $id_pnmf_concelho,
			"id_type" => 2,
			"name" => trim($concelhos[2][$concelhoKey]),
			"freguesias" => array(),
		);

		$postFields = array(
			"flag" => "gjuntas",
			"id_concelho" => $id_pnmf_concelho,
			"c" => "1",
		);
		$concelhoPage = getPNMFsPage($baseURL."requestapi.php", $postFields);

		$pattern = '/<a href="\/freguesia\/(.*?)\/(.*?)" alt="(.*?)" style="font-size:10px;float:left;color:#df0001;" class="btn-link">Ver Página da Freguesia de (.*?)<\/a>/m';
		preg_match_all($pattern, $concelhoPage, $freguesias);

		foreach($freguesias[0] as $freguesiaKey => $freguesia) {

			$id_pnmf_freguesia = $freguesias[1][$freguesiaKey];

			$localidades['distritos'][$id_pnmf_distrito]["concelhos"][$id_pnmf_concelho]["freguesias"][$id_pnmf_freguesia] = array(
				"id_pnmf" => $id_pnmf_freguesia,
				"id_type" => 3,
				"name" => $freguesias[3][$freguesiaKey],
			);
		}
	}


	
}



foreach($localidades['distritos'] as $distrito) {
	$id_distrito = findLocalidadeID($distrito['name'], array("id_type" => $distrito['id_type']));

	$sql = "UPDATE md_localidades SET
				id_pnmf = '".$distrito['id_pnmf']."'
			WHERE id = ".$id_distrito;

	print "DIST: ".$distrito['name']."|".$id_distrito."|".$sql."\n\n";
	\DB::run($sql);

	foreach($distrito['concelhos'] as $concelho) {
		$id_concelho = findLocalidadeID($concelho['name'], array("id_type" => $concelho['id_type'], "parent" => $id_distrito));

		$sql = "UPDATE md_localidades SET
					id_pnmf = '".$concelho['id_pnmf']."'
				WHERE id = ".$id_concelho;

		print "CONC: ".$concelho['name']."|".$id_concelho."|".$sql."\n\n";
		\DB::run($sql);

		foreach($concelho['freguesias'] as $freguesia) {
			$id_freguesia = findLocalidadeID($freguesia['name'], array("id_type" => $freguesia['id_type'], "parent" => $id_concelho));

			if(exists($id_freguesia)) {
				$sql = "UPDATE md_localidades SET
							id_pnmf = '".$freguesia['id_pnmf']."'
						WHERE id = ".$id_freguesia;

				print "FREG: ".$freguesia['name']."|".$id_freguesia."|".$sql."\n\n";
				\DB::run($sql);
			} else {
				$id_freguesia = checkFreguesiaPrior2Union($freguesia['name'], $id_concelho);

				if(!empty($id_freguesia)) {
					$sql = "SELECT id_pnmf FROM md_localidades WHERE id = ".$id_freguesia;
					$row = \DB::results($sql, true);

					$row_pnmf_ids = explode(';', $row['id_pnmf']);
					if (!in_array($freguesia['id_pnmf'], $row_pnmf_ids)) {
						array_push($row_pnmf_ids, $freguesia['id_pnmf']);

						$sql = "UPDATE md_localidades SET
									id_pnmf = '". \DB::escape_string(implode(';', $row_pnmf_ids)) ."'
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