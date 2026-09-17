<?php

namespace Models;

Class Saude {

	protected $lang;
	protected $langTxt;
	protected $moduleName;
	protected $grouping;
	protected $healthCareUnitsType;

	public function __construct() {
		$this->lang = \Lang\Lang::getLanguage();
		$this->langTxt = \Lang\Lang::fetchCurrentLangRef();

		switch ($this->langTxt) {
		    case 'pt':
		        $this->moduleName = 'unidade-saude';
		        $this->grouping = 'agrupamento-saude';
		        break;
		    case 'en':
		        $this->moduleName = 'health-unit';
		        $this->grouping = 'healthcare-grouping';
		        break;
		    default:
		    	$this->moduleName = 'health-unit';
		    	$this->grouping = 'healthcare-grouping';
		}

		$this->healthCareUnitsType = array(
			"1" => \Lang\Dictionary::get('healthcare_units_type_hospital'),
			"2" => \Lang\Dictionary::get('healthcare_units_type_healthcenter'),
		);

		//$this->nature = $this->getSchoolNatureList();
	}

	protected function generateItemURL($row) {
		$title = $row['title'] ? $row['title'] : $row['name'];

		$url = SITE_CONFIGS['info']['baseURL']."/".$this->langTxt."/".$this->moduleName."/".$row['id']."/".\Data\Str::permalink_clean($title);

		return $url;
	}

	protected function generateGroupingItemURL($row) {
		$title = $row['title'] ? $row['title'] : $row['name'];

		$url = SITE_CONFIGS['info']['baseURL']."/".$this->langTxt."/".$this->grouping."/".$row['id']."/".\Data\Str::permalink_clean($title);

		return $url;
	}

	public function convertIntoMapPoints($rows) {
		$mapPoints = array();

		foreach($rows as $row) {
			if (!exists($row['gps']['lat']) || !exists($row['gps']['lon'])) {
				continue;
			}

			switch ($row['type']['id']) {
				case 1:
					$icon = 'hospital.png';
					break;
				case 2:
					$icon = 'stethoscope.png';
					break;
				default:
					$icon = 'stethoscope.png';
			}

			$mapPoints[] = array(
				"name" => $row['title'],
				"coords" => array(
					"lat" => $row['gps']['lat'],
					"lng" => $row['gps']['lon'],
				),
				"icon" => array(
					"iconUrl" => SITE_CONFIGS['info']['baseURL'].'/assets/images/map/icons/'.$icon,
					"iconSize" => [32, 32],
				),
				"address" => $row['address'],
				"url" => $row['url'],
			);
		}

		return $mapPoints;
	}

	public function getItemTypes($id_type = null) {
		$output = array();

		foreach($this->healthCareUnitsType as $type_id => $type) {
			if(exists($id_type) && $id_type != $type_id) {
				continue;
			}

			$output[] = array(
				"id" => $type_id,
				"title" => $type,
			);
		}

		return $output;
	}

	protected function getHealthCareUnitsType($id_type) {
		if (!exists($this->healthCareUnitsType[$id_type])) {
			return false;
		}

		return array(
			"id" => $id_type,
			"title" => $this->healthCareUnitsType[$id_type],
		);
	}

	public function schoolHealthCareGroupingsPageInfo(int $id) {
		$sql = "SELECT g.*, g_lang.title, g_lang.subtitle, g_lang.description, ST_Y(g.gps) AS gps_lat, ST_X(g.gps) AS gps_lon
				FROM md_saude_unidades_agrupamentos AS g
				LEFT JOIN md_saude_unidades_agrupamentos_lang AS g_lang
					ON g_lang.parent = g.id
					AND g_lang.id_lang = {$this->lang}
				WHERE g.active = 1
					AND g.visible = 1
					AND g.dt_delete IS NULL
					AND g.id = ". (int) \DB::escape_string($id);

		$row = \DB::results($sql, true);

		$title = $row['title'] ? $row['title'] : $row['name'];

		$item = array(
			"id" => $row['id'],
			"url" => $this->generateGroupingItemURL($row),
			"title" => $title,
			"subtitle" => $row['subtitle'],
			"description" => $row['description'],
			"address" => $row['address'],
			"zip_code" => $row['zip_code'],				
			"gps" => array(
				"lat" => $row['gps_lat'],
				"lon" => $row['gps_lon'],
				"z" => 12,
			),
			"resp" => array(
				"name" => $row['resp_name'],
				"position" => $row['resp_position'],
				"photo" => $row['resp_photo'],
			),
			"ext_url" => $row['url'],
			"emails" => $this->groupingEmails($row['id']),
			"phones" => $this->groupingPhones($row['id']),
		);

		$groupingUnits = $this->getHealthCareUnitsList(array(
			"id_agrupamento" => $row['id'],
		));
		$item['units'] = $groupingUnits;

		$output = array(
			"agrupamento" => $item,
			"sidebar" => array(
				"grouping_units" => $groupingUnits,
			),
		);


		$output["breadcrumbs"] = array(
			array(
				"title" => \Lang\Dictionary::get('home'),
				"url" => SITE_CONFIGS['info']['baseURL']."/".$this->langTxt,
			),
			array(
				"title" => \Lang\Dictionary::get('schools'),
				"url" => SITE_CONFIGS['info']['baseURL']."/".$this->langTxt."/".\Lang\Dictionary::get('urlparam_healthcare'),
			),
			array(
				"title" => $title
			),
		);

		return $output;
	}

	public function schoolHealthCareGroupingsList($options = null) {
		$sql = "SELECT i.*, i_lang.title, i_lang.subtitle, i_lang.description, ST_Y(i.gps) AS gps_lat, ST_X(i.gps) AS gps_lon";
		$sqlCount = "SELECT COUNT(*) AS total";

		$sqlAppend = " FROM md_saude_unidades_agrupamentos AS i
				LEFT JOIN md_saude_unidades_agrupamentos_lang AS i_lang
					ON i_lang.parent = i.id
					AND i_lang.id_lang = {$this->lang}
				WHERE i.active = 1
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

			$item = array(
				"id" => $row['id'],
				"url" => $this->generateGroupingItemURL($row),
				"title" => $title,
				"subtitle" => $row['subtitle'],
				"description" => $row['description'],
				"address" => $row['address'],
				"zip_code" => $row['zip_code'],				
				"gps" => array(
					"lat" => $row['gps_lat'],
					"lon" => $row['gps_lon'],
					"z" => 16,
				),
				"resp" => array(
					"name" => $row['resp_name'],
					"position" => $row['resp_position'],
					"photo" => $row['resp_photo'],
				),
				"ext_url" => $row['url'],				
			);

			$output['items'][$row['id']] = $item;
		}

		return $output;
	}

	protected function groupingEmails(int $id_parent) {
		$sql = "SELECT m.* 
				FROM md_saude_unidades_agrupamentos_emails AS m
				WHERE m.parent = {$id_parent}
					AND m.id_lang = {$this->lang}
					AND m.active = 1
					AND m.visible = 1
					AND m.dt_delete IS NULL";

		$rows = \DB::results($sql);

		$emails = array();
		foreach($rows as $row) {
			$emails[] = array(
				"label" => $row['name'],
				"address" => $row['value'],
			);
		}

		return $emails;
	}

	protected function groupingPhones(int $id_parent) {
		$sql = "SELECT p.* 
				FROM md_saude_unidades_agrupamentos_phones AS p
				WHERE p.parent = {$id_parent}
					AND p.id_lang = {$this->lang}
					AND p.active = 1
					AND p.visible = 1
					AND p.dt_delete IS NULL";

		$rows = \DB::results($sql);

		$phones = array();
		foreach($rows as $row) {
			$phones[] = array(
				"label" => $row['name'],
				"number" => $row['value'],
			);
		}

		return $phones;
	}


	public function getHealthCareUnitsList($options = null) {
		$sql = "SELECT su.*, su_lang.title, su_lang.subtitle, su_lang.description, ST_Y(su.gps) AS gps_lat, ST_X(su.gps) AS gps_lon";
		$sqlCount = "SELECT COUNT(*) AS total";

		$sqlAppend = " FROM md_saude_unidades AS su
				LEFT JOIN md_saude_unidades_lang AS su_lang
					ON su_lang.parent = su.id
					AND su_lang.id_lang = {$this->lang}
				WHERE 1 
					AND su.active = 1
					AND su.visible = 1
					AND su.dt_delete IS NULL";

		if(exists($options['id'])) {
			$sqlAppend .= " AND su.id = ". (int) \DB::escape_string($options['id']);
		}

		if(exists($options['id_distrito'])) {
			$sqlAppend .= " AND su.id_distrito = ". (int) \DB::escape_string($options['id_distrito']);
		}

		if(exists($options['id_concelho'])) {
			$sqlAppend .= " AND su.id_concelho = ". (int) \DB::escape_string($options['id_concelho']);
		}

		if(exists($options['id_freguesia'])) {
			$sqlAppend .= " AND su.id_freguesia = ". (int) \DB::escape_string($options['id_freguesia']);
		}

		if(exists($options['id_agrupamento'])) {
			$sqlAppend .= " AND su.id_agrupamento = ".(int) \DB::escape_string($options['id_agrupamento']);
		}

		if(exists($options['id_tipo'])) {
			if (is_array($options['id_tipo'])) {
				$sqlAppend .= " ON su.id_tipo IN(".  \DB::escape_string(implode(', ', $options['id_tipo'])) .")";
			} else {
				$sqlAppend .= " ON su.id_tipo = " . (int) \DB::escape_string($options['id_tipo']);
			}
		}

		if(exists($options['id_not'])) {
			if (is_array($options['id_not'])) {
				$sqlAppend .= " AND su.id NOT IN(". \DB::escape_string(implode(', ', $options['id_not'])) .")";
			} else {
				$sqlAppend .= " AND su.id != ".(int) \DB::escape_string($options['id_not']);
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

			$item = array(
				"id" => $row['id'],
				"url" => $this->generateItemURL($row),
				"title" => $title,
				"subtitle" => $row['subtitle'],
				"description" => $row['description'],
				"address" => $row['address'],
				"zip_code" => $row['zip_code'],				
				"gps" => array(
					"lat" => $row['gps_lat'],
					"lon" => $row['gps_lon'],
				),
				"type" => $this->getHealthCareUnitsType($row['id_tipo']),
			);

			/*
			if (!empty($row['id_agrupamento'])) {
				$grouping = $this->schoolHealthCareGroupingsList(array("id" => $row['id_agrupamento']));				
				$item['grouping'] = $grouping[$row['id_agrupamento']];
			}

			
			if (!empty($row['institutional_nature']) && exists($this->nature[$row['institutional_nature']])) {
				$item['nature'] = $this->nature[$row['institutional_nature']];
			}
			*/

			\Models\General::getLocalidades($row, $item);

			$output['items'][$row['id']] = $item;
		}

		return $output;	
	}

	protected function unitEmails(int $id_parent) {
		$sql = "SELECT m.* 
				FROM md_saude_unidades_emails AS m
				WHERE m.parent = {$id_parent}
					AND m.id_lang = {$this->lang}
					AND m.active = 1
					AND m.visible = 1
					AND m.dt_delete IS NULL";

		$rows = \DB::results($sql);

		$emails = array();
		foreach($rows as $row) {
			$emails[] = array(
				"label" => $row['name'],
				"address" => $row['value'],
			);
		}

		return $emails;
	}

	protected function unitPhones(int $id_parent) {
		$sql = "SELECT p.* 
				FROM md_saude_unidades_phones AS p
				WHERE p.parent = {$id_parent}
					AND p.id_lang = {$this->lang}
					AND p.active = 1
					AND p.visible = 1
					AND p.dt_delete IS NULL";

		$rows = \DB::results($sql);

		$phones = array();
		foreach($rows as $row) {
			$phones[] = array(
				"label" => $row['name'],
				"number" => $row['value'],
			);
		}

		return $phones;
	}

	public function healthCareUnitsPageInfo($id) {
		$sql = "SELECT su.*, su_lang.title, su_lang.subtitle, su_lang.description, ST_Y(su.gps) AS gps_lat, ST_X(su.gps) AS gps_lon
				FROM md_saude_unidades AS su
				LEFT JOIN md_saude_unidades_lang AS su_lang
					ON su_lang.parent = su.id
					AND su_lang.id_lang = {$this->lang}
				WHERE 1";

		$sql .= " AND su.active = 1
					AND su.visible = 1
					AND su.dt_delete IS NULL
					AND su.id = ". (int) \DB::escape_string($id);
		

		$row = \DB::results($sql, true);
		
		$title = $row['title'] ? $row['title'] : $row['name'];

		$item = array(
			"id" => $row['id'],
			"url" => $this->generateItemURL($row),
			"title" => $title,
			"subtitle" => $row['subtitle'],
			"description" => $row['description'],
			"address" => $row['address'],
			"zip_code" => $row['zip_code'],				
			"gps" => array(
				"lat" => $row['gps_lat'],
				"lon" => $row['gps_lon'],
				"z" => 16,
			),
			"emails" => $this->unitEmails($row['id']),
			"phones" => $this->unitPhones($row['id']),
			"type" => $this->getHealthCareUnitsType($row['id_tipo']),
		);

		
		if (!empty($row['id_agrupamento'])) {
			$grouping = $this->schoolHealthCareGroupingsList(array("id" => $row['id_agrupamento']))['items'];				
			$item['grouping'] = $grouping[$row['id_agrupamento']];
		}

		/*
		if (!empty($row['institutional_nature']) && exists($this->nature[$row['institutional_nature']])) {
			$item['nature'] = $this->nature[$row['institutional_nature']];
		}
		*/

		\Models\General::getLocalidades($row, $item);
		
		$output = array(
			"unidade" => $item,
			"sidebar" => array(),
		);

		if (!empty($row['id_agrupamento'])) {
			$output['sidebar']['grouping_units'] = $this->getHealthCareUnitsList(array(
				"id_not" => $row['id'],
				"id_agrupamento" => $row['id_agrupamento'],
			));
		}

		if (!empty($row['id_concelho'])) {
			$output['sidebar']['municipality_units'] = $this->getHealthCareUnitsList(array(
				"id_not" => $row['id'],
				"id_concelho" => $row['id_concelho'],
				//"id_tipo" => $row['id_tipo']
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
				"title" => \Lang\Dictionary::get('healthcare'),
				"url" => SITE_CONFIGS['info']['baseURL']."/".$this->langTxt."/".\Lang\Dictionary::get('urlparam_healthcare'),
			),
		);

		return $breadcrumbs;
	}
}