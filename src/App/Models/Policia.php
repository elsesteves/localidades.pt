<?php

namespace Models;

Class Policia {

	protected $lang;
	protected $langTxt;
	protected $moduleName;

	public function __construct() {
		$this->lang = \Lang\Lang::getLanguage();
		$this->langTxt = \Lang\Lang::fetchCurrentLangRef();

		switch ($this->langTxt) {
		    case 'pt':
		        $this->moduleName = 'policia';
		        break;
		    case 'en':
		        $this->moduleName = 'police';
		        break;
		    default:
		    	$this->moduleName = 'police';
		}
	}

	protected function generateItemURL($row) {
		$title = $row['title'] ? $row['title'] : $row['name'];

		$url = SITE_CONFIGS['info']['baseURL']."/".$this->langTxt."/".$this->moduleName."/".$row['id']."/".\Data\Str::permalink_clean($title);

		return $url;
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
					"iconUrl" => SITE_CONFIGS['info']['baseURL'].'/assets/images/map/icons/badge.png',
					"iconSize" => [32, 32],
				),
				"address" => $row['address'],
				"url" => $row['url'],
			);
		}

		return $mapPoints;
	}


	public function getPrecintsList($options = null) {
		$sql = "SELECT i.*, i_lang.title, i_lang.subtitle, i_lang.description, ST_Y(i.gps) AS gps_lat, ST_X(i.gps) AS gps_lon";
		$sqlCount = "SELECT COUNT(*) AS total";

		$sqlAppend = " FROM md_policias AS i
				LEFT JOIN md_policias_lang AS i_lang
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
			$title = mb_ucwords(mb_strtolower($title));

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
			);

			\Models\General::getLocalidades($row, $item);			

			$output['items'][$row['id']] = $item;
		}

		return $output;	
	}

	public function precintsPageInfo(int $id) {
		$sql = "SELECT p.*, p_lang.title, p_lang.subtitle, p_lang.description, ST_Y(p.gps) AS gps_lat, ST_X(p.gps) AS gps_lon
				FROM md_policias AS p
				LEFT JOIN md_policias_lang AS p_lang
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

		$title = $row['title'] ? $row['title'] : $row['name'];
		$title = mb_ucwords(mb_strtolower($title));

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
		);

		\Models\General::getLocalidades($row, $item);

		$output = array(
			"esquadra" => $item,
			"sidebar" => array(),
		);

		if (!empty($row['id_freguesia'])) {
			$output['sidebar']['municipality_precints'] = $this->getPrecintsList(array(
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
				"title" => \Lang\Dictionary::get('law_enforcement'),
				"url" => SITE_CONFIGS['info']['baseURL']."/".$this->langTxt."/".\Lang\Dictionary::get('urlparam_police'),
			),
		);

		return $breadcrumbs;
	}
}