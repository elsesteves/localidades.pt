<?php

require_once __DIR__.'/../inc/bootstrap.php';
require_once __DIR__.'/../inc/functions.php';

$lang_id = 2;//PT
$module = "md_localidades";
$baseURL = "https://www.municipiosefreguesias.pt/";


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

$sql = "SELECT * FROM $module WHERE id_type = 2 AND bg_img_src IS NULL AND id_pnmf IS NOT NULL";
$rows = \DB::results($sql);

$pattern = '/<div class="section-title section-bg resize-bg" style="background-image:url\(\'(.*?)\'\);background-position: center;background-repeat: no-repeat;background-size:contain;">/m';
foreach($rows as $row) {
	$id_pnmf = $row['id_pnmf'];
	//$id_pnmf = 241;
	$url = $baseURL."municipio/".$id_pnmf."/nao-interessa";
	$page = getPNMFsPage($url);

	preg_match($pattern, $page, $bg_img_match);
	if (!exists($bg_img_match[1])) {
		continue;
	}

	$bg_img = $bg_img_match[1];

	$timeStamp = \Data\Date::currentTimeStamp();
	$sql = "UPDATE $module SET
				dt_lastmod = '{$timeStamp}',
				bg_img_src = '{$bg_img}'
			WHERE id = ".$row['id'];
	if (\DB::run($sql)) {
		print "UPDATED ID_LOCALIDADE: ".$row['id'].";\n";
	}
}