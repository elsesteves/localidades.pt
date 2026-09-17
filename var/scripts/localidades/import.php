<?php

require_once __DIR__.'/../inc/bootstrap.php';

die('ALREADY RAN THIS SCRIPT!!!');


$data = \Data\External\Spreadsheet::getData(__DIR__.'/freguesias-de-portugal.xlsx');

//dd($data);

$localidades = array();

foreach($data['body'] as $row) {
	$distrito = $row['distrito'];
	$concelho = $row['concelho'];
	$freguesia = $row['freguesia'];

	$external_urls = array();
	if(!empty($row['page_cm'])) {
		array_push($external_urls, array(
			"name" => "Página no site da CM $concelho",
			"value" => $row['page_cm'],
		));
	}

	if (strpos($row['notas'], 'relacionado: ') !== false) {
		array_push($external_urls, array(
			"name" => "Relacionado",
			"value" => str_replace('relacionado: ', '', $row['notas']),
		));
	}

	$localidades['distritos'][$distrito]['name'] = $distrito;
	$localidades['distritos'][$distrito]['concelhos'][$concelho]['name'] = $concelho;
	$localidades['distritos'][$distrito]['concelhos'][$concelho]['freguesias'][$freguesia] = array(
		"name" => $freguesia,
		"url" => $row['website'],
		"social_media" => array(
			$row['facebook_url'],
		),
		"external_urls" => $external_urls,
		"notes" => $row['notas'],
	);
}


//dd($localidades);

$lang_id = 2;//PT
foreach($localidades['distritos'] as $distritoData) {
	addDistrito($distritoData);
}

dd('SCRIPT ENDED!!');

function addDistrito($localidadeData) {
	global $lang_id;
	$timeStamp = \Data\Date::currentTimeStamp();
	$id_type = 1; //distrito

	$localidadeName = \DB::escape_string($localidadeData['name']);

	$sql = "INSERT INTO md_localidades SET
				dt_intro = '{$timeStamp}',
				dt_lastmod = '{$timeStamp}',
				id_type = $id_type,
				name = '".$localidadeName."'";

	if(\DB::run($sql)) {
		$id_localidade = DB::last_insert_id();

		$sql = "INSERT INTO md_localidades_lang SET
				dt_intro = '{$timeStamp}',
				dt_lastmod = '{$timeStamp}',
				id_lang = $lang_id,
				parent = $id_localidade,
				title = '".$localidadeName."'";
		\DB::run($sql);

		foreach($localidadeData['concelhos'] as $concelho) {
			addConcelho($concelho, $id_localidade);
		}
	}
}

function addConcelho($localidadeData, $id_parent) {
	global $lang_id;
	$timeStamp = \Data\Date::currentTimeStamp();
	$id_type = 2; //concelho

	$localidadeName = \DB::escape_string($localidadeData['name']);

	$sql = "INSERT INTO md_localidades SET
				dt_intro = '{$timeStamp}',
				dt_lastmod = '{$timeStamp}',
				parent = {$id_parent},
				id_type = $id_type,
				name = '".$localidadeName."'";

	if(\DB::run($sql)) {
		$id_localidade = DB::last_insert_id();

		$sql = "INSERT INTO md_localidades_lang SET
				dt_intro = '{$timeStamp}',
				dt_lastmod = '{$timeStamp}',
				id_lang = $lang_id,
				parent = $id_localidade,
				title = '".$localidadeName."'";
		\DB::run($sql);

		foreach($localidadeData['freguesias'] as $freguesia) {
			addFreguesia($freguesia, $id_localidade);
		}
	}
}

function addFreguesia($localidadeData, $id_parent) {
	global $lang_id;
	$timeStamp = \Data\Date::currentTimeStamp();
	$id_type = 3; //freguesia

	$localidadeName = \DB::escape_string($localidadeData['name']);
	$localidadeURL = \DB::escape_string($localidadeData['url']);

	$sql = "INSERT INTO md_localidades SET
				dt_intro = '{$timeStamp}',
				dt_lastmod = '{$timeStamp}',
				parent = {$id_parent},
				id_type = $id_type,
				name = '".$localidadeName."'";

	if(\DB::run($sql)) {
		$id_localidade = DB::last_insert_id();

		$sql = "INSERT INTO md_localidades_lang SET
				dt_intro = '{$timeStamp}',
				dt_lastmod = '{$timeStamp}',
				id_lang = $lang_id,
				parent = $id_localidade,
				title = '".$localidadeName."'";

		if (!empty($localidadeURL)) {
			$sql .= ", url = '".$localidadeURL."'";
		}

		\DB::run($sql);

		addLocalidadeSocialMedia($localidadeData['social_media'], $id_localidade);
		addLocalidadeExternalURLs($localidadeData['external_urls'], $id_localidade);
	}
}


function addLocalidadeSocialMedia($socialMediaLinks, $id_parent) {
	global $lang_id;
	$timeStamp = \Data\Date::currentTimeStamp();

	foreach($socialMediaLinks as $socialMedia) {
		$socialMedia = \DB::escape_string($socialMedia);

		if(empty($socialMedia)) {
			continue;
		}

		$sql = "INSERT INTO md_localidades_social SET
					dt_intro = '{$timeStamp}',
					dt_lastmod = '{$timeStamp}',
					id_lang = 2,
					parent = $id_parent,
					value = '".$socialMedia."'";
		\DB::run($sql);
	}
}

function addLocalidadeExternalURLs($externalURLs, $id_parent) {
	global $lang_id;
	$timeStamp = \Data\Date::currentTimeStamp();

	foreach($externalURLs as $externalURL) {
		$url = \DB::escape_string($externalURL['value']);
		$name = \DB::escape_string($externalURL['name']);

		$sql = "INSERT INTO md_localidades_exturls SET
					dt_intro = '{$timeStamp}',
					dt_lastmod = '{$timeStamp}',
					id_lang = 2,
					parent = $id_parent,
					value = '".$url."'";

		if (!empty($name)) {
			$sql .= ", name = '".$name."'";
		}

		\DB::run($sql);
	}
}

/*
//Delete empty social media records
DELETE FROM `md_localidades_social` WHERE value=''


$sql = "SELECT sys_modules.*, sys_modules_lang.single, sys_modules_lang.plural, sys_modules_lang.title 
					FROM sys_modules 
						LEFT JOIN sys_modules_lang 
							ON sys_modules_lang.parent = sys_modules.id 
							AND sys_modules_lang.id_lang = 2";				

$sql .= " WHERE sys_modules.parent = 0";

$sql .= " ORDER BY -sys_modules.pos DESC";
$rows = DB::results($sql);

dd($rows);
*/