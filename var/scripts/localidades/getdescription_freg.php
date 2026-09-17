<?php

require_once __DIR__.'/../inc/bootstrap.php';
require_once __DIR__.'/../inc/functions.php';

$lang_id = 2;//PT
$module = "md_localidades";
$baseURL = "http://www.freguesias.pt/";


function getFreguesiasPage($url) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch,CURLOPT_ENCODING, 'ISO-8859-1');
	$page = curl_exec($ch);
	$page = mb_convert_encoding($page, 'UTF-8', 'ISO-8859-1');

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

$sql = "SELECT * FROM $module WHERE id_type = 3 AND id_freguesiaspt IS NOT NULL";
$rows = \DB::results($sql);

$patternDescription = '/<table width="636"  border="0" cellspacing="0" cellpadding="0"><tr><td class="titulo-6">DESCRI&Ccedil;&Atilde;O DA  FREGUESIA<\/td><\/tr><tr><td>&nbsp;<\/td><\/tr><tr><td class="texto2_preto">(.*?)<\/td><\/tr>/m';
$patternName = '/<div style="padding-top:10px; color:#000">Freguesia: (.*?)<\/div><\/td>/m';

foreach ($rows as $row) {
	$localidadeID = $row['id'];
	$ids_freguesiaspt = explode(';', $row['id_freguesiaspt']);

	foreach($ids_freguesiaspt as $id_freguesiaspt) {
		//$id_freguesiaspt = '100906';
		if (empty($id_freguesiaspt)) {
			continue;
		}

		$page = getFreguesiasPage($baseURL."freguesia.php?cod=".$id_freguesiaspt);
		//print $page;
		

		preg_match($patternDescription, $page, $descriptionMatch);
		preg_match($patternName, $page, $nameMatch);

		if(!exists($nameMatch[1])) {
			continue;
		}
		$name = $nameMatch[1];
		if ($row['name'] != $name) {
			continue;
		}
		
		if(!exists($descriptionMatch[1])) {
			continue;
		}
		$description = str_replace(array("", ""), '', $descriptionMatch[1]);
		$description = trim($description);

		if ($description == "<span class='texto2b'>(n&atilde;o dispon&iacute;vel)</span>") {
			continue;
		}

		$timeStamp = \Data\Date::currentTimeStamp();
		$sql = "UPDATE md_localidades_lang SET
					dt_lastmod = '{$timeStamp}',
					description = '".\DB::escape_string($description)."'
				WHERE id_lang = 2
					AND parent = ".$row['id'];
		if(\DB::run($sql)) {
			print "UPDATED ID_LOCALIDADE: ".$row['id'].";\n";
		}
	}
}