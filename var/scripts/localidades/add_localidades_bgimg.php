<?php

require_once __DIR__.'/../inc/bootstrap.php';
require_once __DIR__.'/../inc/functions.php';

$lang_id = 2;//PT
$module = "md_localidades";


function getFreguesiasPage($url) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 0);
	curl_setopt($ch,CURLOPT_ENCODING, 'ISO-8859-1');
	$page = curl_exec($ch);
	$page = mb_convert_encoding($page, 'UTF-8', 'ISO-8859-1');

	curl_close($ch);

	//Removing line breaks
	$page = str_replace(array("\r", "\n"), '', $page);

	//Removing white space between elements
	$page = str_replace("> ", ">§", $page);
	$hasSpace = true;
	while($hasSpace) {
		if (strpos($page, "§ ") !== false) {
			$page = str_replace("§ ", '§', $page);
		} else {
			$hasSpace = false;
		}
	}
	$page = str_replace("§", "", $page);

	return $page;
}

$sql = "SELECT freg.* 
		FROM md_localidades AS freg
		WHERE freg.id_type = 3";
$rows = \DB::results($sql);


foreach($rows as $row) {
	$id_localidade = $row['id'];
	//$id_freguesiaspt = '011201';
	$ids_freguesiaspt = explode(';', $row['id_freguesiaspt']);
	foreach($ids_freguesiaspt as $id_freguesiaspt) {
		$url = "http://www.freguesias.pt/portal/index.php?cod=".$id_freguesiaspt;

		print "\n";

		print $url."\n";
		$page = getFreguesiasPage($url);
		if (empty($page)) {
			print "PAGE NOT FOUND!\n";
			continue;
		}

		print "PAGE FOUND!\n";

		$pattern = '/<td width="588" bgcolor="#F5F5F5"><img src="..(.*?)" width="588" height="220" border="0" alt=""><\/td>/m';
		preg_match($pattern, $page, $matches, PREG_OFFSET_CAPTURE, 0);

		if (!exists($matches[1][0])) {
			print "IMG NOT FOUND!\n";
			continue;
		}

		print "IMG FOUND!\n";

		$imgURL = "http://www.freguesias.pt".$matches[1][0];
		$timeStamp = \Data\Date::currentTimeStamp();

		$sql = "UPDATE md_localidades SET
					dt_lastmod = '{$timeStamp}',
					bg_img_src = '{$imgURL}'
				WHERE id = ".$id_localidade;
		if (\DB::run($sql)) {
			print "UPDATED ID_LOCALIDADE: ".$id_localidade.";\n";
		}
	}

}