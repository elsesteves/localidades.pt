<?php

namespace Models;

Class Evento {

	protected $lang;
	protected $langTxt;
	protected $moduleName;
	protected $moduleTypeName;

	public function __construct() {
		$this->lang = \Lang\Lang::getLanguage();
		$this->langTxt = \Lang\Lang::fetchCurrentLangRef();

		switch ($this->langTxt) {
			case 'pt':
				$this->moduleName = 'evento';
				$this->moduleTypeName = 'eventos/tipologia';
		        break;
			case 'en':
				$this->moduleName = 'event';
				$this->moduleTypeName = 'events/type';
		        break;
			default:
				$this->moduleName = 'event';
				$this->moduleTypeName = 'events/type';
		}
	}

	protected function generateItemURL($row) {
		$title = $row['title'] ? $row['title'] : $row['name'];

		$url = SITE_CONFIGS['info']['baseURL']."/".$this->langTxt."/".$this->moduleName."/".$row['id']."/".\Data\Str::permalink_clean($title);

		return $url;
	}

	protected function generateItemTypeURL($row) {
		$title = $row['title'] ? $row['title'] : $row['name'];

		$url = SITE_CONFIGS['info']['baseURL']."/".$this->langTxt."/".$this->moduleTypeName."/".$row['id']."/".\Data\Str::permalink_clean($title);

		return $url;
	}


	public function convertIntoMapPoints($rows) {
		$mapPoints = array();

		foreach($rows as $row) {
			if (!exists($row['gps']['lat']) || !exists($row['gps']['lon'])) {
				continue;
			}

			$icon = 'others.png';
			if (exists($row['types'])) {
				$type = reset($row['types']);

				if (exists($type['icon'])) {
					$icon = $type['icon'];
				}
			}

			$mapPoints[] = array(
				"name" => $row['title'],
				"coords" => array(
					"lat" => $row['gps']['lat'],
					"lng" => $row['gps']['lon'],
				),
				"icon" => array(
					"iconUrl" => SITE_CONFIGS['info']['baseURL'].'/assets/images/map/icons/events/'.$icon,
					"iconSize" => [32, 32],
				),
				"url" => $row['url'],
			);
		}

		return $mapPoints;
	}

	public function getItemTypes($id_item = null) {
		$sql = "SELECT t.id, t.name, t.icon, t_lang.title, t_lang.description
			FROM md_eventos_tipos AS t
			LEFT JOIN md_eventos_tipos_lang AS t_lang
				ON t_lang.parent = t.id
				AND t_lang.id_lang = {$this->lang}";

		if(exists($id_item)) {
			$sql .= " INNER JOIN md_eventos2tipos AS i2t
				ON i2t.id_tipo = t.id
				AND i2t.id_evento = ". (int) $id_item." 
				AND i2t.active = 1 
				AND i2t.visible = 1 
				AND i2t.dt_delete IS NULL";
		}

		$sql .= " WHERE t.active = 1 AND t.visible = 1 AND t.dt_delete IS NULL";

		$sql .= " ORDER BY t_lang.title ASC";

		$rows = \DB::results($sql);

		$output = array();
		foreach($rows as $row) {
			$title = $row['title'] ? $row['title'] : $row['name'];
			$title = mb_ucwords(mb_strtolower($title));

			$item = array(
				"id" => $row['id'],
				"url" => $this->generateItemTypeURL($row),
				"title" => $title,
				"description" => $row['description'],
				"icon" => $row['icon'],
			);

			$output[$row['id']] = $item;
		}

		return $output;
	}

	public function getItemsList($options = null) {
		$sql = "SELECT DISTINCT i.*, i_lang.title, i_lang.subtitle, i_lang.description, ST_Y(i.gps) AS gps_lat, ST_X(i.gps) AS gps_lon";
		$sqlCount = "SELECT COUNT(DISTINCT i.id) AS total";

		$sqlAppend = " FROM md_eventos AS i
				LEFT JOIN md_eventos_lang AS i_lang
					ON i_lang.parent = i.id
					AND i_lang.id_lang = {$this->lang}";

		if (exists($options['id_tipo'])) {
			$sqlAppend .= " INNER JOIN md_eventos2tipos AS i2t";

			if (is_array($options['id_tipo'])) {
				$sqlAppend .= " ON i2t.id_tipo IN(".  \DB::escape_string(implode(', ', $options['id_tipo'])) .")";
			} else {
				$sqlAppend .= " ON i2t.id_tipo = " . (int) \DB::escape_string($options['id_tipo']);
			}

									
			$sqlAppend .= " AND i2t.id_evento = i.id 
							AND i2t.active = 1 
							AND i2t.visible = 1 
							AND i2t.dt_delete IS NULL";
		}

		$sqlAppend .= " WHERE 1 
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

		if (!exists($options['dt_from']) && !exists($options['dt_to'])) {
			$sqlAppend .= " AND ((i.dt_start > '".date("Y-m-d")."' OR (i.dt_start = '".date("Y-m-d")."' 
								AND (i.time_start >= '".date("H:i:s")."' OR i.time_start IS NULL)))
							OR (i.dt_end > '".date("Y-m-d")."' OR (i.dt_end = '".date("Y-m-d")."' 
								AND (i.time_end >= '".date("H:i:s")."' OR i.time_start IS NULL))))";
		} else {
			if (exists($options['dt_from'])) {
				$sqlAppend .= " AND i.dt_start >= '".\DB::escape_string($options['dt_from'])."'";
			} else {
				$sqlAppend .= " AND (i.dt_start > '".date("Y-m-d")."' OR (i.dt_start = '".date("Y-m-d")."' 
								AND (i.time_start >= '".date("H:i:s")."' OR i.time_start IS NULL)))";
			}

			if (exists($options['dt_to'])) {
				$sqlAppend .= " AND i.dt_end <= '".\DB::escape_string($options['dt_to'])."'";
			}
		}

		$sql .= $sqlAppend;
		$sqlCount .= $sqlAppend;

		if (exists($options['order'])) {
			if ($options['order'] == 'rand') {
				$sql .= " ORDER BY RAND()";
			}

			if ($options['order'] == 'dt_start') {
				$sql .= " ORDER BY i.dt_start ASC";
			}	

			if ($options['order'] == 'dt_end') {
				$sql .= " ORDER BY i.dt_end ASC";
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
				//"description" => $row['description'],
				"address" => mb_ucwords(mb_strtolower($row['address'])),
				"zip_code" => $row['zip_code'],				
				"gps" => array(
					"lat" => $row['gps_lat'],
					"lon" => $row['gps_lon'],
				),
				"image" => array(
					"background" => \Data\Str::imgExistsCheck($row['ext_img_url']),
				),
				"dates" => array(
					"start" => array(
						"date" => $row['dt_start'],
						"time" => $row['time_start'],
					),
					"end" => array(
						"date" => $row['dt_end'],
						"time" => $row['time_end'],
						"show" => $row['dt_start'].$row['time_start'] == $row['dt_end'].$row['time_end'] ? false : true,
					),
				),
				"pricing" => $row['pricing'],
				"types" => $this->getItemTypes($row['id']),
			);

			if ($row['time_start']) {
				$item['dates']['start']['formatted'] = \Data\Date::short($row['dt_start'].' '.$row['time_start'], true);
			} else {
				$item['dates']['start']['formatted'] = \Data\Date::short($row['dt_start'], false);
			}

			if ($row['time_end']) {
				$item['dates']['end']['formatted'] = \Data\Date::short($row['dt_end'].' '.$row['time_end'], true);
			} else {
				$item['dates']['end']['formatted'] = \Data\Date::short($row['dt_end'], false);
			}

			\Models\General::getLocalidades($row, $item);			

			$output['items'][$row['id']] = $item;
		}

		return $output;	
	}


	protected function parseDescription($str) {
		$pattern['url'] = '/<a style=\'cursor:pointer;\' rel=\'noopener nofollow\' onclick=\'Navigate\.clickLink\("(.*?)"\);return false;\'>(.*?)<\/a>/m';
		$replace['url'] = '<a style="cursor:pointer;" rel="noopener nofollow" target="_blank" href="${2}">${2}</a>';

		$result = preg_replace($pattern['url'], $replace['url'], $str);

		$result = html_entity_decode($result);

		return $result;
	}

	public function itemPageInfo(int $id) {
		$sql = "SELECT i.*, i_lang.title, i_lang.subtitle, i_lang.description, ST_Y(i.gps) AS gps_lat, ST_X(i.gps) AS gps_lon
				FROM md_eventos AS i
				LEFT JOIN md_eventos_lang AS i_lang
					ON i_lang.parent = i.id
					AND i_lang.id_lang = {$this->lang}
				WHERE 1
				AND i.active = 1
					AND i.visible = 1
					AND i.dt_delete IS NULL
					AND i.id = ". (int) \DB::escape_string($id);
		
		$row = \DB::results($sql, true);

		if(empty($row)) {
			return false;
		}

		$title = $row['title'] ? $row['title'] : $row['name'];
		$title = mb_ucwords(mb_strtolower($title));

		$item = array(
			"id" => $row['id'],
			"url" => $this->generateItemURL($row),
			"scraped_url" => $row['url_scraped'],
			"title" => $title,
			"subtitle" => $row['subtitle'],
			"description" => $this->parseDescription($row['description']),
			"address" => mb_ucwords(mb_strtolower($row['address'])),
			"zip_code" => $row['zip_code'],				
			"gps" => array(
				"lat" => $row['gps_lat'],
				"lon" => $row['gps_lon'],
				"z" => 18,
			),
			"image" => array(
				"background" => $row['ext_img_url'],
			),
			"dates" => array(
				"start" => array(
					"date" => $row['dt_start'],
					"time" => $row['time_start'],
				),
				"end" => array(
					"date" => $row['dt_end'],
					"time" => $row['time_end'],
					"show" => $row['dt_start'].$row['time_start'] == $row['dt_end'].$row['time_end'] ? false : true,
				),
			),
			"pricing" => $row['pricing'],
			"types" => $this->getItemTypes($row['id']),
		);

		if ($row['time_start']) {
			$item['dates']['start']['formatted'] = \Data\Date::long($row['dt_start'].' '.$row['time_start'], true);
		} else {
			$item['dates']['start']['formatted'] = \Data\Date::long($row['dt_start'], false);
		}

		if ($row['time_end']) {
			$item['dates']['end']['formatted'] = \Data\Date::long($row['dt_end'].' '.$row['time_end'], true);
		} else {
			$item['dates']['end']['formatted'] = \Data\Date::long($row['dt_end'], false);
		}

		\Models\General::getLocalidades($row, $item);

		$output = array(
			"item" => $item,
			"sidebar" => array(),
		);

		if (!empty($row['id_freguesia'])) {
			$output['sidebar']['municipality_events'] = $this->getItemsList(array(
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
				"title" => \Lang\Dictionary::get('events'),
				"url" => SITE_CONFIGS['info']['baseURL']."/".$this->langTxt."/".\Lang\Dictionary::get('urlparam_events'),
			)
		);

		return $breadcrumbs;
	}

}