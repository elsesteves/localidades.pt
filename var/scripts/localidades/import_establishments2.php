<?php

require_once __DIR__.'/../inc/bootstrap.php';
require_once __DIR__.'/../inc/functions.php';

$lang_id = 2;//PT
$module = "md_estabelecimentos";
$baseURL = "http://www.freguesias.pt/";


$id_type = 2; //Alojamento
$id_categoria_freguesiasPT= '0'; //Restauração em freguesias.pt https://www.freguesias.pt/portal/onde_comer_dormir.php?cod=011201&categoria=0&button=Listar


function getFreguesiasPage($url) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch,CURLOPT_ENCODING, 'ISO-8859-1');
	$page = curl_exec($ch);
	$page = mb_convert_encoding($page, 'UTF-8', 'ISO-8859-1');

	curl_close($ch);

	$page = str_replace(array("\r", "\n"), '', $page); //Removing line breaks

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


$sql = "SELECT * 
		FROM md_localidades 
		WHERE id_type = 3 
			AND id_freguesiaspt IS NOT NULL";
$rows = \DB::results($sql);

foreach($rows as $row) {

	$sql = "SELECT * 
		FROM md_localidades 
		WHERE id_type = 2 
			AND id = ".$row['parent'];
	$concelhoRow = \DB::results($sql, true);

	$id_freguesia = $row['id'];
	$id_concelho = $row['parent'];
	$id_distrito = $concelhoRow['parent'];

	$ids_freguesiaspt = explode(';', $row['id_freguesiaspt']);

	foreach($ids_freguesiaspt as $id_freguesiaspt) {
		if(empty($id_freguesiaspt)) {
			continue;
		}
		//$id_freguesiaspt = '011201';

		print "id_freguesiaspt: ".$id_freguesiaspt.";\n";

		$url = $baseURL."portal/onde_comer_dormir.php?categoria=".$id_categoria_freguesiasPT."&button=Listar&cod=".$id_freguesiaspt;
		$page = getFreguesiasPage($url);
		//print $page;

		if(empty($page)) {
			continue;
		}

		$re = '/<img src="imagens\/icon_restaurante.gif" alt="Restaurante" title="Restaurante" width="16">(.*?)<\/table><\/td><\/tr><\/table><\/td>/ms';
		preg_match_all($re, $page, $matches, PREG_SET_ORDER, 0);

		foreach($matches as $establishmentInfo) {
			$establishment = array();
			//var_dump($establishmentInfo[1]);

			$patName = '/<span class="titulos_azul_escuro">(.*?)<\/span>/ms';
			preg_match($patName, $establishmentInfo[1], $estName);

			$patAddr = '/<img src="imagens\/icon_cod_postal.png" alt="Morada" title="Morada" width="16"><\/td><td align="left" valign="top" class="texto" style="padding-bottom:4px">(.*?)<\/td><\/tr><\/table><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="left" valign="top" class="texto"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td width="25" style="padding-bottom:4px">&nbsp;<\/td><td align="left" valign="top" style="padding-bottom:4px">(.*?) (.*?)<\/td>/ms';
			preg_match($patAddr, $establishmentInfo[1], $estAddr);

			$patPhone = '/<tr><td width="25" align="left" valign="top" style="padding-bottom:4px"><img src="imagens\/icon_phone.gif" alt="Telefone" title="Telefone" width="16" ><\/td><td align="left" class="texto" style="padding-bottom:4px">(.*?)<\/td><\/tr>/ms';
			preg_match($patPhone, $establishmentInfo[1], $estPhone);

			$patEmail = '/<img src="imagens\/icon_email.gif" alt="Email" title="Email" width="16"><\/td><td align="left" valign="top" style="padding-bottom:2px"><a href="mailto:(.*?)" class="texto1"/ms';
			preg_match($patEmail, $establishmentInfo[1], $estEmail);

			$patURL = '/<img src="imagens\/icon_website.gif" alt="Portal" title="Portal" width="16"><\/td><td align="left" valign="top" style="padding-bottom:4px"><a href="http:(.*?)" target="_blank" class="texto1">/ms';
			preg_match($patURL, $establishmentInfo[1], $estURL);

			if (exists($estName[1])) {
				$establishment['name'] = \DB::escape_string($estName[1]);
			}
			if (exists($estAddr[1])) {
				$establishment['address'] = \DB::escape_string($estAddr[1]);
			}
			if (exists($estAddr[2])) {
				$codPostal = substr(\DB::escape_string($estAddr[2]), 0, 8);
				if(substr($codPostal, 7, 1) == '<') {
					$codPostal = substr($codPostal, 0, 4) . '-' . substr($codPostal, 4, 3);
				}
				$establishment['cod_postal'] = $codPostal;
				$gps = findGPSCoordsByCodPostal($establishment['cod_postal']);			
			}
			if (exists($estPhone[1])) {
				$establishment['phone'] = \DB::escape_string($estPhone[1]);
			}
			if (exists($estEmail[1])) {
				$establishment['email'] = \DB::escape_string($estEmail[1]);
			}
			if (exists($estURL[1])) {
				$establishment['url'] = \DB::escape_string($estURL[1]);
			}

			$name = $establishment['name'];
			$timeStamp = \Data\Date::currentTimeStamp();

			//Check if record already exists
			$sql = "SELECT * 
					FROM {$module} 
					WHERE id_type = $id_type
						AND name = '{$name}'
						AND id_freguesia = $id_freguesia";
			print $sql."\n";
			$estabelecimento = \DB::results($sql, true);
			if(!empty($estabelecimento)) {
				$sql = "UPDATE {$module} SET
						dt_lastmod = '{$timeStamp}',";

				if(exists($establishment['cod_postal'])) {
					$sql .= " zip_code = '". $establishment['cod_postal'] ."',";

					
					if(exists($gps['lon']) && exists($gps['lat'])) {
						$sql .= " gps = ST_GeomFromText('POINT(".$gps['lon']." ".$gps['lat'].")'),";
					}
				}

				$sql .= " active = 1
						WHERE id_type = $id_type
							AND name = '".$name."'
							AND id_freguesia = $id_freguesia";

				\DB::run($sql);

				print "FOUND ID_ROW: ".$estabelecimento['id']."; ID FREGUESIA: ".$id_freguesia.";\n\n";

				continue;
			}
			
			

			$sql = "INSERT INTO {$module} SET
				dt_intro = '{$timeStamp}',
				dt_lastmod = '{$timeStamp}',
				id_type = $id_type,
				name = '".$name."',";

			if(!empty($id_distrito)) {
				$sql .= " id_distrito = $id_distrito,";
			}
			if(!empty($id_concelho)) {
				$sql .= " id_concelho = $id_concelho,";
			}
			if(!empty($id_freguesia)) {
				$sql .= " id_freguesia = $id_freguesia,";
			}
			if(exists($address)) {
				$sql .= " address = '".$establishment['address']."',";
			}

			if(exists($establishment['cod_postal'])) {
				$sql .= " zip_code = '". $establishment['cod_postal'] ."',";

				
				if(exists($gps['lon']) && exists($gps['lat'])) {
					$sql .= " gps = ST_GeomFromText('POINT(".$gps['lon']." ".$gps['lat'].")'),";
				}
			}

			if (exists($establishment['url'])) {
				$sql .= " url = '".$establishment['url']."',";
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


				if(exists($establishment['phone'])) {
					$timeStamp = \Data\Date::currentTimeStamp();
					$sql = "INSERT INTO {$module}_phones SET
								dt_intro = '{$timeStamp}',
								dt_lastmod = '{$timeStamp}',
								id_lang = $lang_id,
								parent = $id_row,
								value = '".$establishment['phone']."',
								active = 1";
					\DB::run($sql);
				}


				if(exists($establishment['email'])) {
					$timeStamp = \Data\Date::currentTimeStamp();
					$sql = "INSERT INTO {$module}_emails SET
								dt_intro = '{$timeStamp}',
								dt_lastmod = '{$timeStamp}',
								id_lang = $lang_id,
								parent = $id_row,
								value = '".$establishment['email']."',
								active = 1";
					\DB::run($sql);
				}
			}

			print "CREATED ID_ROW: ". $id_row ."; ID FREGUESIA: ".$id_freguesia.";\n\n";
		}
		

	}
}