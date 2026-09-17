<?php

require_once __DIR__.'/../inc/bootstrap.php';
require_once __DIR__.'/../inc/functions.php';

$name = \DB::escape_string($row['NOME']);

$sql = "SELECT id, zip_code FROM md_escolas_agrupamentos";

$rows = \DB::results($sql);

foreach($rows as $row) {
	var_dump($row);

	$gps = findGPSCoordsByCodPostal($row['zip_code']);

	if ($gps != false) {
		//Save gps as lon lat!!
		$sql = "UPDATE md_escolas_agrupamentos SET
					gps = ST_GeomFromText('POINT(".$gps['lon']." ".$gps['lat'].")')
					WHERE id = ".$row['id'];
		\DB::run($sql);
	}
}