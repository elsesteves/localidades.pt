<?php

require_once __DIR__.'/../inc/bootstrap.php';
require_once __DIR__.'/../inc/functions.php';

$lang_id = 2;//PT
$module = "md_praias";
$baseURL = "https://praias.beachcam.pt";

function getPage($url) {
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

$distritosDisp = array(
	"Aveiro" => 1, 
	"Beja" => 168, 
	"Braga" => 258, 
	"Coimbra" => 991, 
	"Faro" => 1248, 
	"Ilha de Porto Santo" => 3242, 
	"Leiria" => 1589, 
	"Lisboa" => 1716, 
	"Porto" => 1952, 
	"Setúbal" => 2377, 
	"Viana do Castelo" => 2446,
);


$beachItemPattern = '/<div class="cards"><a href="(.*?)"><figure><img src="(.*?)" alt="(.*?)"><\/figure><article><small>(.*?)<\/small><p>(.*?)<\/p>/m';
$beachCamLinkPattern = '/Partilhar<\/a><\/li><li><a href="(.*?)" target="_blank"><img src="\/images\/icon-livecam\.svg">Live Cam<\/a><\/li>/m';
$beachGPSPattern = '/<li><a href="https:\/\/www.google.pt\/maps\/place\/(.*?)\/@(.*?),(.*?),(.*?)" target="_blank"><img src="\/images\/icon-pin-white.svg">Obter direc&#231;&#245;es<\/a><\/li>/m';
foreach($distritosDisp as $distName => $id_distrito) {
	$url = $baseURL."/pt/pesquisa/?d=".$distName;
	$page = getPage($url);

	preg_match_all($beachItemPattern, $page, $beaches, PREG_SET_ORDER, 0);

	foreach($beaches as $beach) {
		$beachName = trim($beach[3]);
		$beachName = html_entity_decode($beachName);
		$beachPageURL = $baseURL.$beach[1];
		$beachImg = $baseURL.$beach[2];

		$beachPage = getPage($beachPageURL);
		
		preg_match($beachCamLinkPattern, $beachPage, $camLinkMatch);
		$camLink = $camLinkMatch[1];

		$sql = "SELECT * FROM md_praias WHERE id_distrito = $id_distrito AND name LIKE '".$beachName."'";
		$row = \DB::results($sql, true);

		if(!exists($row)) {
			preg_match($beachGPSPattern, $beachPage, $gpsMatch);
			$gps = array(
				"lon" => $gpsMatch[3],
				"lat" => $gpsMatch[2],
			);

			$local = findLocalidadeByGPSCoords($gps['lat'], $gps['lon']);

			$name = \DB::escape_string($beachName);

			$id_concelho = null;
			$id_freguesia = null;
			$zipCode = null;

			if($local != false) {
				$zipCode = \DB::escape_string($local['codigo_postal']);

				$id_concelho = findLocalidadeID($local['concelho'], array("id_type" => 2, "parent" => $id_distrito));
				$id_freguesia = findLocalidadeID($local['freguesia'], array("id_type" => 3, "parent" => $id_concelho));

				if(empty($id_freguesia)) {
					$id_freguesia = findFreguesiaByCodPostal($zipCode, $id_concelho);
				}
			}

			$timeStamp = \Data\Date::currentTimeStamp();
			$sql = "INSERT INTO {$module} SET
				dt_intro = '{$timeStamp}',
				dt_lastmod = '{$timeStamp}',
				name = '{$name}',";

			$sql .= " id_type = 1,";

			if(exists($id_distrito)) {
				$sql .= " id_distrito = $id_distrito,";
			}
			if(exists($id_concelho)) {
				$sql .= " id_concelho = $id_concelho,";
			}
			if(exists($id_freguesia)) {
				$sql .= " id_freguesia = $id_freguesia,";
			}

			if(exists($zipCode)) {
				$sql .= " zip_code = '". $zipCode ."',";
			}	

			if(exists($gps['lon']) && exists($gps['lat'])) {
				$sql .= " gps = ST_GeomFromText('POINT(".$gps['lon']." ".$gps['lat'].")'),";
			}

			if(!empty($beachImg)) {
				$sql .= " ext_img_url = '". \DB::escape_string($beachImg) ."',";
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
			}
		} else {
			$id_row = $row['id'];
		}

		if(!empty($camLink)) {
			$timeStamp = \Data\Date::currentTimeStamp();
			$sql = "INSERT INTO {$module}_cams SET
						dt_intro = '{$timeStamp}',
						dt_lastmod = '{$timeStamp}',
						id_lang = $lang_id,
						parent = $id_row,
						name = 'MEO Beachcam',
						value = '".$camLink."',
						active = 1";
			\DB::run($sql);
		}


		print "ID PRAIA: ".$id_row.";\n";
	}

} 