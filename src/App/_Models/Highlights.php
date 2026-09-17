<?php

namespace Models;

Class Highlights extends \Module {

	public function __construct()
	{
		parent::__construct('highlights');
	}

	public function items($parentID, $excludeIDs = null, $limit = null) {

		$idFilter = '';
		if (is_array($excludeIDs) && !empty($excludeIDs)) {
			$idFilter .= " AND {$this->baseTable}.id NOT IN (".implode(', ', $excludeIDs).")";
		}

		$sql = "SELECT {$this->baseTable}.*, {$this->baseTable}_lang.title, {$this->baseTable}_lang.description, {$this->baseTable}_lang.label, {$this->baseTable}_lang.url, {$this->baseTable}_lang.target_blank, {$this->baseTable}_lang.active, {$this->baseTable}_images.image_full, {$this->baseTable}_images.image_resize, {$this->baseTable}_images.image_thumb, {$this->baseTable}_lang.cms_banner, {$this->baseTable}_lang.cms_banner_mobile FROM {$this->baseTable} LEFT JOIN {$this->baseTable}_lang ON {$this->baseTable}_lang.parent = {$this->baseTable}.id AND {$this->baseTable}_lang.fk_lang = {$this->lang} LEFT JOIN {$this->baseTable}_images ON {$this->baseTable}_images.parent = {$this->baseTable}.id AND {$this->baseTable}_images.main = 1 AND (({$this->baseTable}_images.fk_lang = {$this->lang} AND {$this->baseTable}.images_bylang = 1) OR {$this->baseTable}.images_bylang = 0) WHERE {$this->baseTable}.deleted = 0 AND {$this->baseTable}.parent = $parentID $idFilter ORDER BY -{$this->baseTable}.pos DESC";
		$items = \DB::results($sql);

		$highlights = array();
		foreach ($items as $item) {
			$highlights[$item['id']] = array(
				"title"	=> $item['title'] ? $item['title'] : $item['name'],		
				"description" => strip_tags($item['description']),
				"label"	=> $item['label'] ? $item['label'] : \Lang\Dictionary::get('learn more'),
				"url"	=> \Data\Str::fixUrl($item['url']),
				"target_blank"	=> $item['target_blank'],
				"image"	=> $item['image_thumb'] ? '/'. $item['image_thumb'] : '/assets/images/noimage/empty_horizontal_thumb.png',
			);
		}

		return $highlights;
	}
	
}