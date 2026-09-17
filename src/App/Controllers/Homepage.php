<?php

namespace Controllers;

Class Homepage {

	public static function homepage() {
		$data = array();

		$search = array("limit" => 12, "order" => 'rand');

		$distritoModel = new \Models\Distrito();
		$data["dist_by_region"] = $distritoModel->distritosByRegion();

		$eventoModel = new \Models\Evento();
		$data["eventos"] = $eventoModel->getItemsList($search);

		$turismoModel = new \Models\PontoTuristico();
		$data["turismo"] = $turismoModel->getItemsList($search);

		$praiaModel = new \Models\Praia();
		$data["praias"] = $praiaModel->getItemsList($search);

		//$saudeModel = new \Models\Saude();
		//$data["saude"] = $saudeModel->getHealthCareUnitsList($search);

		//$farmaciaModel = new \Models\Farmacia();
		//$data["farmacias"] = $farmaciaModel->getPharmaciesList($search);

		//$escolaModel = new \Models\Escola();
		//$data["escolas"] = $escolaModel->getSchoolsList($search);

		//$policiaModel = new \Models\Policia();
		//$data["policia"] = $policiaModel->getPrecintsList($search);

		//$bombeiroModel = new \Models\Bombeiro();
		//$data["bombeiros"] = $bombeiroModel->getStationsList($search);


		view('homepage/homepage', $data);
	}

}