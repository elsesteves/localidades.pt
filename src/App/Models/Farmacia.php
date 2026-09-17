<?php

namespace Models;

Class Farmacia {

	protected $lang;
	protected $langTxt;
	protected $moduleName;

	public function __construct() {
		$this->lang = \Lang\Lang::getLanguage();
		$this->langTxt = \Lang\Lang::fetchCurrentLangRef();

		switch ($this->langTxt) {
		    case 'pt':
		        $this->moduleName = 'farmacia';
		        break;
		    case 'en':
		        $this->moduleName = 'pharmacy';
		        break;
		    default:
		    	$this->moduleName = 'pharmacy';
		}
	}

	protected function generateItemURL($row) {
		$title = $row['title'] ? $row['title'] : $row['name'];

		$url = SITE_CONFIGS['info']['baseURL']."/".$this->langTxt."/".$this->moduleName."/".$row['id']."/".\Data\Str::permalink_clean($title);

		return $url;
	}

	public static function getDutyPharmaciesList4Concelho($distritoName, $concelhoName) {
		$distritoName = str_replace(' ', '_', $distritoName);
		$concelhoName = str_replace(' ', '_', $concelhoName);

		$url = "https://farmaciasdeservico.net/widget/?localidade=".$distritoName."%7C".$concelhoName."&cor_fundo=%23ffffff&cor_titulo=%23000000&cor_texto=%23333333&margem=16&v=1";

		//dd($url);

		$error = null;
		$page = crawlPage($url, null, $error);
		//dd($page);

		$pattern = '/<div class="farmacia">((.|\s)*?)<\/div>/m';
		preg_match_all($pattern, $page, $matches, PREG_SET_ORDER, 0);

		$dutyPharmacies = array();

		foreach($matches as $match) {
			$dutyPharmacies[] = $match[1];
		}

		return $dutyPharmacies;
	}

	public function convertIntoMapPoints($rows) {
		$mapPoints = array();

		foreach($rows as $row) {
			if (!exists($row['gps']['lat']) || !exists($row['gps']['lon'])) {
				continue;
			}

			$mapPoints[] = array(
				"name" => $row['title'],
				"coords" => array(
					"lat" => $row['gps']['lat'],
					"lng" => $row['gps']['lon'],
				),
				"icon" => array(
					"iconUrl" => SITE_CONFIGS['info']['baseURL'].'/assets/images/map/icons/pharmacy.png',
					"iconSize" => [32, 32],
				),
				"address" => $row['address'],
				"url" => $row['url'],
			);
		}

		return $mapPoints;
	}

	public function getPharmaciesList($options = null) {
		$sql = "SELECT i.*, i_lang.title, i_lang.subtitle, i_lang.description, ST_Y(i.gps) AS gps_lat, ST_X(i.gps) AS gps_lon";
		$sqlCount = "SELECT COUNT(*) AS total";

		$sqlAppend = " FROM md_saude_farmacias AS i
				LEFT JOIN md_saude_farmacias_lang AS i_lang
					ON i_lang.parent = i.id
					AND i_lang.id_lang = {$this->lang}
				WHERE 1 
					AND i.active = 1
					AND i.visible = 1
					AND i.dt_delete IS NULL";

		if(exists($options['id'])) {
			$sqlAppend .= " AND i.id = ". (int) \DB::escape_string($options['id']);
		}

		if(exists($options['id_distrito'])) {
			$sqlAppend .= " AND i.id_distrito = ". (int) \DB::escape_string($options['id_distrito']);
		}

		if(exists($options['id_concelho'])) {
			$sqlAppend .= " AND i.id_concelho = ". (int) \DB::escape_string($options['id_concelho']);
		}

		if(exists($options['id_freguesia'])) {
			$sqlAppend .= " AND i.id_freguesia = ". (int) \DB::escape_string($options['id_freguesia']);
		}

		if(exists($options['id_not'])) {
			if (is_array($options['id_not'])) {
				$sqlAppend .= " AND i.id NOT IN(". \DB::escape_string(implode(', ', $options['id_not'])) .")";
			} else {
				$sqlAppend .= " AND i.id != ".(int) \DB::escape_string($options['id_not']);
			}			
		}

		$sql .= $sqlAppend;
		$sqlCount .= $sqlAppend;

		if (exists($options['order'])) {
			if ($options['order'] == 'rand') {
				$sql .= " ORDER BY RAND()";
			}			
		}

		$page = 1;
		$limit = null;
		if (exists($options['limit'])) {
			$limit = (int) $options['limit'];
			
			if (exists($options['page']) && $options['page'] > 1) {
				$page = (int) $options['page'];
			}

			$offset = ($page - 1) * $limit;

			$sql .= " LIMIT ".$limit;
			$sql .= " OFFSET ".$offset;
		}

		$rows = \DB::results($sql);
		$totalRes = \DB::results($sqlCount, true);

		$output = array(
			"items" => array(),
			"pagination" => array(
				"total_results" => $totalRes['total'],
				"current_page" => $page,
				"last_page" => exists($limit) ? ceil($totalRes['total']/$limit) : 1,
			),
		);

		foreach($rows as $row) {
			$title = $row['title'] ? $row['title'] : $row['name'];
			$title = \Lang\Dictionary::get('pharmacy') .' '. mb_ucwords(mb_strtolower($title));

			$item = array(
				"id" => $row['id'],
				"url" => $this->generateItemURL($row),
				"title" => $title,
				"subtitle" => $row['subtitle'],
				"description" => $row['description'],
				"address" => mb_ucwords(mb_strtolower($row['address'])),
				"zip_code" => $row['zip_code'],				
				"gps" => array(
					"lat" => $row['gps_lat'],
					"lon" => $row['gps_lon'],
				),
				"tax_id" => $row['tax_id'],
				"license_num" => $row['alvara_num'],
				"management" => $row['management'],
			);

			\Models\General::getLocalidades($row, $item);		

			$output['items'][$row['id']] = $item;
		}

		return $output;	
	}

	public function pharmaciesPageInfo(int $id) {
		$sql = "SELECT p.*, p_lang.title, p_lang.subtitle, p_lang.description, ST_Y(p.gps) AS gps_lat, ST_X(p.gps) AS gps_lon
				FROM md_saude_farmacias AS p
				LEFT JOIN md_saude_farmacias_lang AS p_lang
					ON p_lang.parent = p.id
					AND p_lang.id_lang = {$this->lang}
				WHERE 1
				AND p.active = 1
					AND p.visible = 1
					AND p.dt_delete IS NULL
					AND p.id = ". (int) \DB::escape_string($id);
		
		$row = \DB::results($sql, true);

		if(empty($row)) {
			return false;
		}

		$freguesiaModel = new \Models\Freguesia();
		$concelhoModel = new \Models\Concelho();

		$title = $row['title'] ? $row['title'] : $row['name'];
		$title = \Lang\Dictionary::get('pharmacy') .' '. mb_ucwords(mb_strtolower($title));

		$item = array(
			"id" => $row['id'],
			"url" => $this->generateItemURL($row),
			"title" => $title,
			"subtitle" => $row['subtitle'],
			"description" => $row['description'],
			"address" => mb_ucwords(mb_strtolower($row['address'])),
			"zip_code" => $row['zip_code'],				
			"gps" => array(
				"lat" => $row['gps_lat'],
				"lon" => $row['gps_lon'],
				"z" => 18,
			),
			"tax_id" => $row['tax_id'],
			"license_num" => $row['alvara_num'],
			"management" => $row['management'],
		);

		\Models\General::getLocalidades($row, $item);

		$output = array(
			"farmacia" => $item,
			"sidebar" => array(),
		);

		if (!empty($row['id_freguesia'])) {
			$output['sidebar']['municipality_pharmacies'] = $this->getPharmaciesList(array(
				"id_not" => $row['id'],
				"id_concelho" => $row['id_concelho'],
			));
		}

		$output["breadcrumbs"] = $this->breadcrumbs();
		$output["breadcrumbs"][] = array(
			"title" => $title
		);

		return $output;
	}

	public function breadcrumbs() {
		$breadcrumbs = array(
			array(
				"title" => \Lang\Dictionary::get('home'),
				"url" => SITE_CONFIGS['info']['baseURL']."/".$this->langTxt,
			),
			array(
				"title" => \Lang\Dictionary::get('pharmacies'),
				"url" => SITE_CONFIGS['info']['baseURL']."/".$this->langTxt."/".\Lang\Dictionary::get('urlparam_pharmacies'),
			),
		);

		return $breadcrumbs;
	}

}