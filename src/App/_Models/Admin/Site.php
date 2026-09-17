<?php

namespace Models\Admin;

Class Site extends \Module {

	public function __construct() {
		parent::__construct('site');
		$this->lang = \Lang\Lang::getLanguage('admin');
	}

	public function item($id = null) {
		$sql = "SELECT {$this->baseTable}.*, {$this->baseTable}_lang.title, {$this->baseTable}_lang.subtitle, {$this->baseTable}_lang.description, {$this->baseTable}_images.image_full, {$this->baseTable}_images.image_resize, {$this->baseTable}_images.image_thumb FROM {$this->baseTable} LEFT JOIN {$this->baseTable}_lang ON {$this->baseTable}_lang.parent = {$this->baseTable}.id AND {$this->baseTable}_lang.fk_lang = {$this->lang} LEFT JOIN {$this->baseTable}_images ON {$this->baseTable}_images.parent = {$this->baseTable}.id AND {$this->baseTable}_images.main = 1 AND (({$this->baseTable}_images.fk_lang = {$this->lang} AND {$this->baseTable}.images_bylang = 1) OR {$this->baseTable}.images_bylang = 0) WHERE {$this->baseTable}.deleted = 0";

		if(!empty($id)) {
			$sql .= " AND {$this->baseTable}.id = $id";
		} else {
			$sql .= " ORDER BY -{$this->baseTable}.pos DESC LIMIT 1";
		}

		//dd($sql);

		$item = \DB::results($sql, true);

		$info = array();
		if (exists($item)) {
			$info = array(
				"id" => $item['id'],
				"title" => $item['title'] ? $item['title'] : $item['name'],
				"description" => $item['description'], //address
			);
		}

		return $info;
	}

}