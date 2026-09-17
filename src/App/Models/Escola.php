<?php

namespace Models;

Class Escola {

	protected $lang;
	protected $langTxt;
	protected $moduleName;
	protected $grouping;
	protected $nature;

	public function __construct() {
		$this->lang = \Lang\Lang::getLanguage();
		$this->langTxt = \Lang\Lang::fetchCurrentLangRef();

		switch ($this->langTxt) {
		    case 'pt':
		        $this->moduleName = 'escola';
		        $this->grouping = 'agrupamento-escolar';
		        break;
		    case 'en':
		        $this->moduleName = 'school';
		        $this->grouping = 'school-grouping';
		        break;
		    default:
		    	$this->moduleName = 'school';
		    	$this->grouping = 'school-grouping';
		}

		$this->nature = $this->getSchoolNatureList();
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

			$mapPoints[] = array(
				"name" => $row['title'],
				"coords" => array(
					"lat" => $row['gps']['lat'],
					"lng" => $row['gps']['lon'],
				),
				"icon" => array(
					"iconUrl" => SITE_CONFIGS['info']['baseURL'].'/assets/images/map/icons/school.png',
					"iconSize" => [32, 32],
				),
				"address" => $row['address'],
				"url" => $row['url'],
			);
		}

		return $mapPoints;
	}


	public function getSchoolNatureList() {
		$sql = "SELECT e.*, e_lang.title, e_lang.subtitle, e_lang.description
				FROM md_escolas_naturezainstitucional AS e
				LEFT JOIN md_escolas_naturezainstitucional_lang AS e_lang
					ON e_lang.parent = e.id
					AND e_lang.id_lang = {$this->lang}
				WHERE 1";

		$sql .= " AND e.active = 1
					AND e.visible = 1
					AND e.dt_delete IS NULL";

		if(exists($options['id'])) {
			$sql .= " AND e.id = ". (int) \DB::escape_string($options['id']);
		}

		$rows = \DB::results($sql);

		$output = array();

		foreach($rows as $row) {
			$title = $row['title'] ? $row['title'] : $row['name'];

			$item = array(
				"id" => $row['id'],
				"title" => $title,
			);		

			$output[$row['id']] = $item;
		}

		return $output;	
	}

	public function getSchoolGroupingsList($options = null) {
		$sql = "SELECT e.*, e_lang.title, e_lang.subtitle, e_lang.description, ST_Y(e.gps) AS gps_lat, ST_X(e.gps) AS gps_lon
				FROM md_escolas_agrupamentos AS e
				LEFT JOIN md_escolas_agrupamentos_lang AS e_lang
					ON e_lang.parent = e.id
					AND e_lang.id_lang = {$this->lang}
				WHERE 1";

		$sql .= " AND e.active = 1
					AND e.visible = 1
					AND e.dt_delete IS NULL";

		if(exists($options['id'])) {
			$sql .= " AND e.id = ". (int) \DB::escape_string($options['id']);
		}

		if(exists($options['id_distrito'])) {
			$sql .= " AND e.id_distrito = ". (int) \DB::escape_string($options['id_distrito']);
		}

		if(exists($options['id_concelho'])) {
			$sql .= " AND e.id_concelho = ". (int) \DB::escape_string($options['id_concelho']);
		}

		if(exists($options['id_freguesia'])) {
			$sql .= " AND e.id_freguesia = ". (int) \DB::escape_string($options['id_freguesia']);
		}

		$rows = \DB::results($sql);

		$output = array();

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
				),
				"ext_url" => $row['url'],
				"coduome" => $row['coduome'],
				"tax_id" => $row['tax_id'],
			);

			\Models\General::getLocalidades($row, $item);			

			$output[$row['id']] = $item;
		}

		return $output;	
	}

	public function getSchoolsList($options = null) {
		$sql = "SELECT i.*, i_lang.title, i_lang.subtitle, i_lang.description, ST_Y(i.gps) AS gps_lat, ST_X(i.gps) AS gps_lon";
		$sqlCount = "SELECT COUNT(*) AS total";

		$sqlAppend = " FROM md_escolas AS i
				LEFT JOIN md_escolas_lang AS i_lang
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

		if(exists($options['id_agrupamento'])) {
			$sqlAppend .= " AND i.id_agrupamento = ".(int) \DB::escape_string($options['id_agrupamento']);
		}

		if(exists($options['id_not'])) {
			if (is_array($options['id_not'])) {
				$sqlAppend .= " AND i.id NOT IN(". \DB::escape_string(implode(', ', $options['id_not'])) .")";
			} else {
				$sqlAppend .= " AND i.id != ".(int) \DB::escape_string($options['id_not']);
			}			
		}

		if(exists($options['cycles'])) {
			$inCycleStr = '';
			foreach($options['cycles'] as $cycle) {
				if (!empty($inCycleStr)) {
					$inCycleStr .= ", ";
				}
				$inCycleStr .= $cycle['id'];
			}

			$sqlAppend .= " AND i.id IN (SELECT id_escola FROM md_escolas2ciclos WHERE id_ciclo IN ({$inCycleStr}))";
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
				"ext_url" => $row['url'],
				"codigo_escola" => $row['codigo_escola'],
			);

			if (!empty($row['id_agrupamento'])) {
				$grouping = $this->getSchoolGroupingsList(array("id" => $row['id_agrupamento']));				
				$item['grouping'] = $grouping[$row['id_agrupamento']];
			}

			if (!empty($row['institutional_nature']) && exists($this->nature[$row['institutional_nature']])) {
				$item['nature'] = $this->nature[$row['institutional_nature']];
			}

			\Models\General::getLocalidades($row, $item);

			$item['cycles'] = $this->getSchoolCycles2School($row['id']);

			$output['items'][$row['id']] = $item;
		}

		return $output;	
	}


	public function getSchoolCycles2School($id_escola = null) {
		$sql = "SELECT ec.*, ec_lang.title, ec_lang.subtitle, ec_lang.description
				FROM md_escolas_ciclos AS ec
				LEFT JOIN md_escolas_ciclos_lang AS ec_lang
					ON ec_lang.parent = ec.id
					AND ec_lang.id_lang = {$this->lang}";

		if(exists($id_escola)) {
			$sql .= " INNER JOIN md_escolas2ciclos AS e2c
					ON e2c.id_ciclo = ec.id
					AND e2c.id_escola = ". (int) \DB::escape_string($id_escola);
		}

		$sql .= " WHERE ec.active = 1
					AND ec.visible = 1
					AND ec.dt_delete IS NULL";

		$rows = \DB::results($sql);
		$output = array();
		foreach($rows as $row) {
			$title = $row['title'] ? $row['title'] : $row['name'];

			$item = array(
				"id" => $row['id'],
				"title" => $title,
			);

			$output[$row['id']] = $item;
		}

		return $output;
	}

	protected function schoolEmails(int $id_parent) {
		$sql = "SELECT m.* 
				FROM md_escolas_emails AS m
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

	protected function schoolPhones(int $id_parent) {
		$sql = "SELECT p.* 
				FROM md_escolas_phones AS p
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

	public function schoolsPageInfo(int $id) {
		$sql = "SELECT e.*, e_lang.title, e_lang.subtitle, e_lang.description, ST_Y(e.gps) AS gps_lat, ST_X(e.gps) AS gps_lon
				FROM md_escolas AS e
				LEFT JOIN md_escolas_lang AS e_lang
					ON e_lang.parent = e.id
					AND e_lang.id_lang = {$this->lang}
				WHERE 1";

		$sql .= " AND e.active = 1
					AND e.visible = 1
					AND e.dt_delete IS NULL
					AND e.id = ". (int) \DB::escape_string($id);

		$row = \DB::results($sql, true);

		if(empty($row)) {
			return false;
		}

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
				"z" => 18,
			),			
			"codigo_escola" => $row['codigo_escola'],
			"ext_url" => $row['url'],
			"emails" => $this->schoolEmails($row['id']),
			"phones" => $this->schoolPhones($row['id']),
		);

		if (!empty($row['id_agrupamento'])) {
			$grouping = $this->getSchoolGroupingsList(array("id" => $row['id_agrupamento']));				
			$item['grouping'] = $grouping[$row['id_agrupamento']];
		}

		if (!empty($row['institutional_nature']) && exists($this->nature[$row['institutional_nature']])) {
			$item['nature'] = $this->nature[$row['institutional_nature']];
		}

		\Models\General::getLocalidades($row, $item);

		$item['cycles'] = $this->getSchoolCycles2School($row['id']);

		$output = array(
			"escola" => $item,
			"sidebar" => array(),
		);

		if (!empty($row['id_agrupamento'])) {
			$output['sidebar']['grouping_schools'] = $this->getSchoolsList(array(
				"id_not" => $row['id'],
				"id_agrupamento" => $row['id_agrupamento'],
				//"cycles" => $item['cycles'],
			));
		}

		if (!empty($row['id_freguesia'])) {
			$output['sidebar']['parish_schools'] = $this->getSchoolsList(array(
				"id_not" => $row['id'],
				"id_freguesia" => $row['id_freguesia'],
				"cycles" => $item['cycles'],
			));
		}

		$output["breadcrumbs"] = array(
			array(
				"title" => \Lang\Dictionary::get('home'),
				"url" => SITE_CONFIGS['info']['baseURL']."/".$this->langTxt,
			),
			array(
				"title" => \Lang\Dictionary::get('schools'),
				"url" => SITE_CONFIGS['info']['baseURL']."/".$this->langTxt."/".\Lang\Dictionary::get('urlparam_schools'),
			),
			array(
				"title" => $title
			),
		);


		return $output;	
	}


	public function schoolGroupingsPageInfo(int $id) {
		$sql = "SELECT e.*, e_lang.title, e_lang.subtitle, e_lang.description, ST_Y(e.gps) AS gps_lat, ST_X(e.gps) AS gps_lon
				FROM md_escolas_agrupamentos AS e
				LEFT JOIN md_escolas_agrupamentos_lang AS e_lang
					ON e_lang.parent = e.id
					AND e_lang.id_lang = {$this->lang}
				WHERE 1";

		$sql .= " AND e.active = 1
					AND e.visible = 1
					AND e.dt_delete IS NULL";

		if(exists($id)) {
			$sql .= " AND e.id = ". (int) \DB::escape_string($id);
		}

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
				"z" => 16,
			),
			"ext_url" => $row['url'],
			"coduome" => $row['coduome'],
			"tax_id" => $row['tax_id'],
		);

		$groupingSchools = $this->getSchoolsList(array(
			"id_agrupamento" => $row['id'],
		));
		$item['schools'] = $groupingSchools;

		\Models\General::getLocalidades($row, $item);

		$output = array(
			"agrupamento" => $item,
			"sidebar" => array(
				"grouping_schools" => $groupingSchools,
			),
		);

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
				"title" => \Lang\Dictionary::get('schools'),
				"url" => SITE_CONFIGS['info']['baseURL']."/".$this->langTxt."/".\Lang\Dictionary::get('urlparam_schools'),
			),
		);

		return $breadcrumbs;
	}

}