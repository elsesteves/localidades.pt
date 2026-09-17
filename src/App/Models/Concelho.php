<?php

namespace Models;

Class Concelho {

	protected $lang;
	protected $langTxt;
	protected $moduleName;

	public function __construct() {
		$this->lang = \Lang\Lang::getLanguage();
		$this->langTxt = \Lang\Lang::fetchCurrentLangRef();

		switch ($this->langTxt) {
		    case 'pt':
		        $this->moduleName = 'municipio';
		        break;
		    case 'en':
		        $this->moduleName = 'municipality';
		        break;
		    default:
		    	$this->moduleName = 'municipality';
		}
	}

	protected function generateItemURL($row) {
		$title = $row['title'] ? $row['title'] : $row['name'];

		$url = SITE_CONFIGS['info']['baseURL']."/".$this->langTxt."/".$this->moduleName."/".$row['id']."/".\Data\Str::permalink_clean($title);

		return $url;
	}


	public function overallPageInfo(int $id, $tab = null) {
		$sql = "SELECT c.*, c_lang.title, c_lang.subtitle, c_lang.description, ST_Y(c.gps) AS gps_lat, ST_X(c.gps) AS gps_lon, c.gps_z
				FROM md_localidades AS c
				LEFT JOIN md_localidades_lang AS c_lang
					ON c_lang.parent = c.id
					AND c_lang.id_lang = {$this->lang}
				WHERE 1";
		/*
		$sql .= " AND c.active = 1
					AND c.visible = 1
					AND c.dt_delete IS NULL";
		*/
		$sql .= " AND c.id_type = 2
					AND c.id = ". (int) \DB::escape_string($id);

		$row = \DB::results($sql, true);

		if(empty($row)) {
			return false;
		}

		$id_distrito = $row['parent'];
		$distritoModel = new \Models\Distrito();

		$title = $row['title'] ? $row['title'] : $row['name'];

		$localidade = array(
			"id" => $row['id'],
			"url" => $this->generateItemURL($row),
			"title" => $title,
			"subtitle" => $row['subtitle'],
			"description" => $row['description'],
			"img" => array(
				"background" => \Data\Str::imgExistsCheck($row['bg_img_src']),
			),
			"gps" => array(
				"lat" => $row['gps_lat'],
				"lon" => $row['gps_lon'],
				"z" => $row['gps_z'] ? $row['gps_z'] : 12,
			),
		);

		$distritoInfo = $distritoModel->itemsBasicInfo(array("id" => $id_distrito));

		$localidade['distrito'] = array(
			"id" => $id_distrito,
			"title" => $distritoInfo[$id_distrito]['title'],
			"url" => $distritoInfo[$id_distrito]['url'],
		);

		$output = array(
			"concelho" => $localidade,
			"breadcrumbs" => $this->breadcrumbs($distritoInfo[$id_distrito], $row, $title, $tab),
		);

		return $output;
	}

	public function getItemGallery(int $id_item, $options = null) {
		$sql = "SELECT li.*, li_lang.caption";
		$sqlCount = "SELECT COUNT(*) AS total";

		$sqlAppend = " FROM md_localidades_images AS li
				LEFT JOIN md_localidades_images_lang AS li_lang
					ON li_lang.parent = li.id
					AND li_lang.id_lang = {$this->lang}
				LEFT JOIN md_localidades AS f
					ON li.parent = f.id
				    AND f.id_type = 3
				LEFT JOIN md_localidades AS c
					ON f.parent = c.id
				    AND c.id_type = 2
				WHERE c.id = $id_item";

		
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
			"pagination" => array(
				"total_results" => $totalRes['total'],
				"current_page" => $page,
				"last_page" => exists($limit) ? ceil($totalRes['total']/$limit) : 1,
			),
		);

		$gallery = array();
		foreach($rows as $row) {
			$gallery[] = array(
				"id" => $row['id'],
				"src" => $row['name'],
				"caption" => $row['caption'],
			);
		}

		$output['items'] = $gallery;

		return $output;
	}


	protected function breadcrumbs($distrito, $row, $title, $tab = null) {
		$breadcrumbs = array(
			array(
				"title" => \Lang\Dictionary::get('home'),
				"url" => SITE_CONFIGS['info']['baseURL']."/".$this->langTxt,
			),
			array(
				"title" => $distrito['title'],
				"url" => $distrito['url'],
			),
		);

		switch ($tab) {
			case 'weather':
				$breadcrumbs[] = array(
					"title" => $title,
					"url" => $this->generateItemURL($row),
				);
				$breadcrumbs[] = array(
					"title" => \Lang\Dictionary::get('weather_forecast'),
				);
				break;

			case 'healthcare':
				$breadcrumbs[] = array(
					"title" => $title,
					"url" => $this->generateItemURL($row),
				);
				$breadcrumbs[] = array(
					"title" => \Lang\Dictionary::get('healthcare'),
				);
				break;


			case 'pharmacies':
				$breadcrumbs[] = array(
					"title" => $title,
					"url" => $this->generateItemURL($row),
				);
				$breadcrumbs[] = array(
					"title" => \Lang\Dictionary::get('pharmacies'),
				);
				break;

			case 'schools':
				$breadcrumbs[] = array(
					"title" => $title,
					"url" => $this->generateItemURL($row),
				);
				$breadcrumbs[] = array(
					"title" => \Lang\Dictionary::get('educational_establishments'),
				);
				break;

			case 'police':
				$breadcrumbs[] = array(
					"title" => $title,
					"url" => $this->generateItemURL($row),
				);
				$breadcrumbs[] = array(
					"title" => \Lang\Dictionary::get('law_enforcement'),
				);
				break;

			case 'firefighters':
				$breadcrumbs[] = array(
					"title" => $title,
					"url" => $this->generateItemURL($row),
				);
				$breadcrumbs[] = array(
					"title" => \Lang\Dictionary::get('firefighters'),
				);
				break;

			case 'beaches':
				$breadcrumbs[] = array(
					"title" => $title,
					"url" => $this->generateItemURL($row),
				);
				$breadcrumbs[] = array(
					"title" => \Lang\Dictionary::get('beaches'),
				);
				break;

			case 'tourism-points':
				$breadcrumbs[] = array(
					"title" => $title,
					"url" => $this->generateItemURL($row),
				);
				$breadcrumbs[] = array(
					"title" => \Lang\Dictionary::get('tourism_points'),
				);
				break;

			case 'events':
				$breadcrumbs[] = array(
					"title" => $title,
					"url" => $this->generateItemURL($row),
				);
				$breadcrumbs[] = array(
					"title" => \Lang\Dictionary::get('events'),
				);
				break;

			case 'map':
				$breadcrumbs[] = array(
					"title" => $title,
					"url" => $this->generateItemURL($row),
				);
				$breadcrumbs[] = array(
					"title" => \Lang\Dictionary::get('map'),
				);
				break;

			case 'contacts':
				$breadcrumbs[] = array(
					"title" => $title,
					"url" => $this->generateItemURL($row),
				);
				$breadcrumbs[] = array(
					"title" => \Lang\Dictionary::get('contacts'),
				);
				break;
			
			default:
				$breadcrumbs[] = array(
					"title" => $title,
				);
				break;
		}


		return $breadcrumbs;
	}

	protected function checkSideMenuItem($item, &$parentActive = false) {
		$active = false;

		if (isset($item['url']) && \Request::path() == $item['url']) {
			$active = true;			
			$item['url'] = "#";
		}

		if (exists($item['items'])) {
			foreach($item['items'] as $menuItemKey => $menuItem) {
				$item['items'][$menuItemKey] = $this->checkSideMenuItem($menuItem, $active);
			}
		}

		if ($active) {
			$parentActive = true;
		}

		$item['active'] = $active;

		return $item;
	}

	public function generateSideMenu($row) {
		$menu = array(
			"overview" => array(
				"label" => \Lang\Dictionary::get('overview'),
				"icon" => "fa-solid fa-house",
				"url" => $row['url'],
			),
			/*"news" => array(
				"label" => \Lang\Dictionary::get('news'),
				"icon" => "fa-solid fa-newspaper",
				"url" => $row['url']."/".\Lang\Dictionary::get('urlparam_news'),
			),*/
			"weather" => array(
				"label" => \Lang\Dictionary::get('weather_forecast'),
				"icon" => "fa-solid fa-cloud-sun",
				"url" => $row['url']."/".\Lang\Dictionary::get('urlparam_weather'),
			),
			"events" => array(
				"label" => \Lang\Dictionary::get('events'),
				"icon" => "fa-regular fa-calendar",
				"url" => $row['url']."/".\Lang\Dictionary::get('urlparam_events'),
			),
			"leisure" => array(
				"label" => \Lang\Dictionary::get('leisure'),
				"icon" => "fa-solid fa-umbrella-beach",
				"items" => array(
					"tourism-points" => array(
						"label" => \Lang\Dictionary::get('tourism_points'),
						"url" => $row['url']."/".\Lang\Dictionary::get('urlparam_tourism_points'),
					),
					"beaches" => array(
						"label" => \Lang\Dictionary::get('beaches'),
						"url" => $row['url']."/".\Lang\Dictionary::get('urlparam_beaches'),
					),					
				),
			),
			"services" => array(
				"label" => \Lang\Dictionary::get('services'),
				"icon" => "fa-solid fa-circle-info",
				"items" => array(
					"healthcare" => array(
						"label" => \Lang\Dictionary::get('healthcare'),
						"url" => $row['url']."/".\Lang\Dictionary::get('urlparam_healthcare'),
					),
					"pharmacies" => array(
						"label" => \Lang\Dictionary::get('pharmacies'),
						"url" => $row['url']."/".\Lang\Dictionary::get('urlparam_pharmacies'),
					),
					"schools" => array(
						"label" => \Lang\Dictionary::get('educational_establishments'),
						"url" => $row['url']."/".\Lang\Dictionary::get('urlparam_schools'),						
					),
					/*"public_entities" => array(
						"label" => \Lang\Dictionary::get('public_entities'),
						"url" => $row['url']."/".\Lang\Dictionary::get('urlparam_public_entities'),						
					),*/
					"police" => array(
						"label" => \Lang\Dictionary::get('law_enforcement'),
						"url" => $row['url']."/".\Lang\Dictionary::get('urlparam_police'),						
					),					
					"firefighters" => array(
						"label" => \Lang\Dictionary::get('firefighters'),
						"url" => $row['url']."/".\Lang\Dictionary::get('urlparam_firefighters'),
					),
				),
			),
			"gallery" => array(
				"label" => \Lang\Dictionary::get('gallery'),
				"icon" => "fa-solid fa-images",
				"url" => $row['url']."/".\Lang\Dictionary::get('urlparam_gallery'),
			),
			"map" => array(
				"label" => \Lang\Dictionary::get('map'),
				"icon" => "fa-solid fa-map",
				"url" => $row['url']."/".\Lang\Dictionary::get('urlparam_map'),
			),
			/*"contacts" => array(
				"label" => \Lang\Dictionary::get('contacts'),
				"icon" => "fa-solid fa-phone",
				"url" => $row['url']."/".\Lang\Dictionary::get('urlparam_contacts'),
			),*/
		);

		foreach($menu as $menuItemKey => $menuItem) {
			$menu[$menuItemKey] = $this->checkSideMenuItem($menuItem);
		}

		return $menu;
	}


	public function itemsBasicInfo($options = null) {
		$sql = "SELECT c.*, c_lang.title, c_lang.subtitle, ST_Y(c.gps) AS gps_lat, ST_X(c.gps) AS gps_lon
				FROM md_localidades AS c
				LEFT JOIN md_localidades_lang AS c_lang
					ON c_lang.parent = c.id
					AND c_lang.id_lang = {$this->lang}
				WHERE 1";
		
		/*
		$sql .= " AND c.active = 1
					AND c.visible = 1
					AND c.dt_delete IS NULL";
		*/
		$sql .= " AND c.id_type = 2";

		if(exists($options['id'])) {
			$sql .= " AND c.id = ". (int) \DB::escape_string($options['id']);
		}

		if(exists($options['parent'])) {
			$sql .= " AND c.parent = ". (int) \DB::escape_string($options['parent']);
		}		

		$rows = \DB::results($sql);

		$output = array();
		foreach($rows as $row) {
			$localidade = array(
				"id" => $row['id'],
				"url" => $this->generateItemURL($row),
				"title" => $row['title'] ? $row['title'] : $row['name'],
				"subtitle" => $row['subtitle'],
				"img" => array(
					"background" => \Data\Str::imgExistsCheck($row['bg_img_src']),
				),
				"gps" => array(
					"lat" => $row['gps_lat'],
					"lon" => $row['gps_lon'],
				),
			);

			$output[$row['id']] = $localidade;
		}

		return $output;		
	}

}