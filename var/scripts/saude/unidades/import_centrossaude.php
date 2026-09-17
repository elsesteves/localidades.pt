<?php

require_once __DIR__.'/../../inc/bootstrap.php';
require_once __DIR__.'/../../inc/functions.php';

$lang_id = 2;//PT

$nature = array(
	"Público" => "1",
	"Privados" => "2",
);

$baseURL = "https://sns.gov.pt";
$url = $baseURL."/institucional/entidades-de-saude/";

$page = crawlPage($url);

//print $url;
//dd($page);

$re = '/<span id="rs_read_this" class="categorieslist-item-title">Serviço Nacional de Saúde - Serviços Desconcentrados das Administrações Regionais de Saúde<\/span>(.*?)<ul class="entitieslist">(.*?)<\/ul>/ms';
//preg_match($re, $page, $matches, PREG_OFFSET_CAPTURE, 0);
preg_match_all($re, $page, $match, PREG_SET_ORDER, 0);
//var_dump($match);

//print "\\n\\n\\n\\".$page;

$groupingListTxt = $match[0][2];
//var_dump($groupingListTxt);


$groupings = array();

$re = '/<li id="rs_read_this" class="entitieslist-item">(.*?)<a href="(.*?)">(.*?)<\/a>/m';
preg_match_all($re, $groupingListTxt, $matches, PREG_SET_ORDER, 0);

//var_dump($matches);

foreach($matches as $match) {
	$groupings[] = array(
		"name" => $match[3],
		"url" => $match[2],
	);
}

//var_dump($groupings);
$groupingDetailsPattern = '/<div class="col-xs-12 col-sm-3 entitydetails">(.*?)<\/div>(.*?)<\/div><div class="row"><div class="col-xs-12">/ms';
$groupingInfoPattern = '/<div id="rs_read_this"><div class="col-xss-12 col-xs-9 col-sm-12">(.*?)<br \/><strong>(.*?)<\/strong><br \/><div class="entitydetails-contacts-title"><span>Contactos<\/span><\/div><p>(.*?)<br \/>(.*?)<\/p><p><strong>Telefone<\/strong><br \/>(.*?)<\/p><p><strong>Fax<\/strong><br \/>(.*?)<\/p><p><strong>E-mail<\/strong><br \/><a href="mailto:(.*?)">(.*?)<\/a><\/p><\/div><\/div><\/div><\/div>/ms';
$groupingImgPattern = '/<div class="row"><div class="col-xss-12 col-xs-3 col-sm-12"><img src="(.*?)" class="img-responsive" alt="(.*?)" \/>/m';
$centerListPattern = '/<p><strong>Outros Contactos<\/strong><\/p>(.*?)<\/div><div id="rs_read_this"><div class="text-right">Data de Atualização:/m';
$centerListPattern2 = '/<p><strong>Contactos<\/strong><\/p>(.*?)<br \/>E-mail:(.*?)<\/a><\/p>(.*?)<\/div><div id="rs_read_this"><div class="text-right">Data de Atualização:/m';
$centerItemPattern = '/<p>(.*?)<\/p><p>Morada: (.*?)<br \/>(.*?)<br \/>Telefone: (.*?)<br \/>(.*?)E-mail:<u><a href="mailto:(.*?)" target="_blank" rel="noopener">(.*?)<\/a><\/u><\/p>/m';
foreach($groupings as $groupingKey => $grouping) {
	$groupingPage = crawlPage($grouping['url']);
	//dd($groupingPage);

	preg_match_all($groupingDetailsPattern, $groupingPage, $matches, PREG_SET_ORDER, 0);
	$groupingDetails = array(
		"imgTxt" => $matches[0][1],
		"infoTxt" => $matches[0][2],
	);
	//dd($groupingDetails);

	preg_match($groupingInfoPattern, $groupingDetails['infoTxt'], $match);

	if(exists($match)) {
		$groupings[$groupingKey]['resp_name'] = $match[1];
		$groupings[$groupingKey]['resp_position'] = $match[2];
		$groupings[$groupingKey]['address'] = $match[3].", ".$match[4];
		$groupings[$groupingKey]['zip_code'] = substr($match[4], 0, 8);
		$groupings[$groupingKey]['phone'] = $match[5];
		$groupings[$groupingKey]['email'] = $match[7];
	}	

	preg_match($groupingImgPattern, $groupingDetails['imgTxt'], $match);
	if (isset($match[1])) {
		//dd($match[1]);
		$groupings[$groupingKey]['resp_photo'] = $match[1];
	}
	

	preg_match_all($centerListPattern, $groupingPage, $matches, PREG_SET_ORDER, 0);
	
	if (isset($matches[0])) {
		$centerListTxt = $matches[0][1];
	} else {
		preg_match_all($centerListPattern2, $groupingPage, $matches, PREG_SET_ORDER, 0);
		//dd($matches);
		if (isset($matches[0])) {
			$centerListTxt = $matches[0][3];
		} else {
			//var_dump($grouping);
		}
		//dd($centerListTxt);
	}

	if (!isset($centerListTxt)) {
		continue;
	}

	preg_match_all($centerItemPattern, $centerListTxt, $matches, PREG_SET_ORDER, 0);
	//dd($matches);

	$centers = array();
	foreach($matches as $match) {
		$centers[] = array(
			"name" => $match[1],
			"address" => $match[2].", ".$match[3],
			"zip_code" => substr($match[3], 0, 8),
			"phone" => $match[4],
			"email" => $match[6],
		);
	}

	$groupings[$groupingKey]['centers'] = $centers;
}


/*
Missing Centers Data
Manual Digging
array(2) {
  ["name"]=>
  string(47) "Agrupamento de Centros de Saúde Baixo Alentejo"
  ["url"]=>
  string(89) "https://www.sns.gov.pt/entidades-de-saude/agrupamento-de-centros-de-saude-baixo-alentejo/"
}
array(2) {
  ["name"]=>
  string(62) "Agrupamento de Centros de Saúde do Douro II &#8211; Douro Sul"
  ["url"]=>
  string(87) "https://www.sns.gov.pt/entidades-de-saude/agrupamento-de-centros-do-douro-ii-douro-sul/"
}
array(2) {
  ["name"]=>
  string(54) "Agrupamento de Centros de Saúde do Ave – Famalicão"
  ["url"]=>
  string(82) "https://www.sns.gov.pt/entidades-de-saude/agrupamento-de-centros-do-ave-famalicao/"
}
array(2) {
  ["name"]=>
  string(55) "Agrupamento de Centros de Saúde do Cávado I – Braga"
  ["url"]=>
  string(83) "https://www.sns.gov.pt/entidades-de-saude/agrupamento-de-centros-do-cavado-i-braga/"
}
array(2) {
  ["name"]=>
  string(76) "Agrupamento de Centros de Saúde do Grande Porto I &#8211; Santo Tirso/Trofa"
  ["url"]=>
  string(100) "https://www.sns.gov.pt/entidades-de-saude/agrupamento-de-centros-do-grande-porto-i-santo-tirsotrofa/"
}
array(2) {
  ["name"]=>
  string(79) "Agrupamento de Centros de Saúde de Entre Douro e Vouga II &#8211; Aveiro Norte"
  ["url"]=>
  string(104) "https://www.sns.gov.pt/entidades-de-saude/agrupamento-de-centros-de-entre-douro-e-vouga-ii-aveiro-norte/"
}
*/

//dd($groupings);



foreach($groupings as $grouping) {
	$name = \DB::escape_string($grouping['name']);

	$zipCode = \DB::escape_string($grouping['zip_code']);
	$gps = findGPSCoordsByCodPostal($zipCode);

	//$id_distrito = findLocalidadeID($gps['distrito'], array("id_type" => 1));
	//$id_concelho = findLocalidadeID($gps['concelho'], array("id_type" => 2, "parent" => $id_distrito));
	//$id_freguesia = findLocalidadeID($gps['freguesia'], array("id_type" => 3, "parent" => $id_concelho));

	$address = \DB::escape_string($grouping['address']);


	$timeStamp = \Data\Date::currentTimeStamp();
	$sql = "INSERT INTO md_saude_unidades_agrupamentos SET
				dt_intro = '{$timeStamp}',
				dt_lastmod = '{$timeStamp}',
				name = '{$name}',";

	if(exists($id_distrito)) {
		$sql .= " id_distrito = $id_distrito,";
	}
	if(exists($id_concelho)) {
		$sql .= " id_concelho = $id_concelho,";
	}
	if(exists($id_freguesia)) {
		$sql .= " id_freguesia = $id_freguesia,";
	}

	$sql .= " address = '". $address ."',
				zip_code = '". $zipCode ."',";

	if(exists($gps['lon']) && exists($gps['lat'])) {
		$sql .= " gps = ST_GeomFromText('POINT(".$gps['lon']." ".$gps['lat'].")'),";
	}

	$sql .= " url = '". \DB::escape_string($grouping['url']) ."',
				resp_name = '". \DB::escape_string($grouping['resp_name']) ."',
				resp_position = '". \DB::escape_string($grouping['resp_position']) ."',
				resp_photo = '". \DB::escape_string($grouping['resp_photo']) ."',
				active = 1";

	if(\DB::run($sql)) {
		$id_grouping = DB::last_insert_id();

		$timeStamp = \Data\Date::currentTimeStamp();
		$sql = "INSERT INTO md_saude_unidades_agrupamentos_lang SET
					dt_intro = '{$timeStamp}',
					dt_lastmod = '{$timeStamp}',
					id_lang = $lang_id,
					parent = $id_grouping,
					title = '".$name."',
					active = 1";
		\DB::run($sql);

		if(exists($grouping['email'])) {
			$sql = "INSERT INTO md_saude_unidades_agrupamentos_emails SET
						dt_intro = '{$timeStamp}',
						dt_lastmod = '{$timeStamp}',
						id_lang = $lang_id,
						parent = $id_grouping,
						value =  '". \DB::escape_string($grouping['email']) ."',
						active = 1";
			\DB::run($sql);
		}
		
		if(exists($grouping['phone'])) {
			$sql = "INSERT INTO md_saude_unidades_agrupamentos_phones SET
						dt_intro = '{$timeStamp}',
						dt_lastmod = '{$timeStamp}',
						id_lang = $lang_id,
						parent = $id_grouping,
						value =  '". \DB::escape_string($grouping['phone']) ."',
						active = 1";
			\DB::run($sql);
		}

		foreach($grouping['centers'] as $center) {
			$name = \DB::escape_string($center['name']);

			$zipCode = \DB::escape_string($center['zip_code']);
			$gps = findGPSCoordsByCodPostal($zipCode);

			$id_distrito = findLocalidadeID($gps['distrito'], array("id_type" => 1));
			$id_concelho = findLocalidadeID($gps['concelho'], array("id_type" => 2, "parent" => $id_distrito));
			$id_freguesia = findLocalidadeID($gps['freguesia'], array("id_type" => 3, "parent" => $id_concelho));

			$address = \DB::escape_string($center['address']);


			$timeStamp = \Data\Date::currentTimeStamp();
			$sql = "INSERT INTO md_saude_unidades SET
						dt_intro = '{$timeStamp}',
						dt_lastmod = '{$timeStamp}',
						name = '{$name}',";

			if(exists($id_distrito)) {
				$sql .= " id_distrito = $id_distrito,";
			}
			if(exists($id_concelho)) {
				$sql .= " id_concelho = $id_concelho,";
			}
			if(exists($id_freguesia)) {
				$sql .= " id_freguesia = $id_freguesia,";
			}

			$sql .= " address = '". $address ."',
						zip_code = '". $zipCode ."',";

			if(exists($gps['lon']) && exists($gps['lat'])) {
				$sql .= " gps = ST_GeomFromText('POINT(".$gps['lon']." ".$gps['lat'].")'),";
			}

			$sql .= " id_agrupamento = {$id_grouping},
						id_tipo = 2,
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

				if(exists($center['email'])) {
					$sql = "INSERT INTO md_saude_unidades_emails SET
								dt_intro = '{$timeStamp}',
								dt_lastmod = '{$timeStamp}',
								id_lang = $lang_id,
								parent = $id_grouping,
								value =  '". \DB::escape_string($center['email']) ."',
								active = 1";
					\DB::run($sql);
				}
				
				if(exists($center['phone'])) {
					$sql = "INSERT INTO md_saude_unidades_phones SET
								dt_intro = '{$timeStamp}',
								dt_lastmod = '{$timeStamp}',
								id_lang = $lang_id,
								parent = $id_grouping,
								value =  '". \DB::escape_string($center['phone']) ."',
								active = 1";
					\DB::run($sql);
				}
			}
		}
	}
}

dd('SCRIPT HAS ENDED!!');