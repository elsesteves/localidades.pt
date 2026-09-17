<?php

require_once __DIR__.'/../inc/bootstrap.php';
require_once __DIR__.'/../inc/functions.php';

$lang_id = 2;//PT

$sql = "SELECT * FROM md_escolas WHERE id_freguesia IS NULL";
$rows = \DB::results($sql);

foreach($rows as $row) {
	print "\n\n";
	print "Escola ID: ". $row['id'].";";
	$id_freguesia = (int) findFreguesiaByCodPostal($row['zip_code'], $row['id_concelho']);

	//dd($id_freguesia);

	if (!empty($id_freguesia)) {
		print " Freguesia ID: ". $id_freguesia.";";
		$sql = "UPDATE md_escolas SET
					id_freguesia = {$id_freguesia}
				WHERE id = ". (int) $row['id'];
		\DB::run($sql);
	}
}

print "\n\nSCRIPT ENDED!!!";