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

	return $page;
}

$sql = "SELECT *
		FROM {$module}
		WHERE id_type = 3";
$rows = \DB::results($sql);
foreach($rows as $row) {
	$localidadeID = $row['id'];
	$ids_freguesiaspt = explode(';', $row['id_freguesiaspt']);

	foreach($ids_freguesiaspt as $id_freguesiaspt) {
		if (empty($id_freguesiaspt)) {
			continue;
		}

		$url = $baseURL . "freguesia.php?cod=".$id_freguesiaspt;
		$page = getFreguesiasPage($url);

		$pattern = '/<table width="656" height="147" border="0" cellpadding="0" cellspacing="0">(.*?)<\/table>/ms';
		preg_match($pattern, $page, $matches, PREG_OFFSET_CAPTURE, 0);
		$imgContainer = $matches[1][0];

		$pattern = '/<img src="(.*?)" width="218" height="147" \/>/sm';
		preg_match_all($pattern, $imgContainer, $matches);
		$imgs = $matches[1];
		var_dump($imgs);

		foreach($imgs as $img) {
			$img_url = $baseURL.$img;

			$sql = "SELECT * 
					FROM {$module}_images 
					WHERE parent = $localidadeID
						AND id_lang = $lang_id
						AND name = '{$img_url}'";
			$imgRow = \DB::results($sql, true);

			if(!empty($imgRow)) {
				continue;
			}

			$timeStamp = \Data\Date::currentTimeStamp();

			$sql = "INSERT INTO {$module}_images SET
						dt_intro = '{$timeStamp}',
						dt_lastmod = '{$timeStamp}',
						parent = $localidadeID,
						id_lang = $lang_id,
						name = '{$img_url}'";
			\DB::run($sql);
		}
	}	
}