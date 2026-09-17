<?php

namespace Models;

Class Slider extends \Module {

	public function __construct()
	{
		parent::__construct('slider');
	}

	public function item($parentID=0, $excludeIDs = null) {
		$idFilter = '';
		if (is_array($excludeIDs) && !empty($excludeIDs)) {
			$idFilter .= " AND {$this->baseTable}.id NOT IN (".implode(', ', $excludeIDs).")";
		}

		$sql = "SELECT {$this->baseTable}.*, {$this->baseTable}_lang.title, {$this->baseTable}_lang.subtitle, {$this->baseTable}_lang.btn_label, {$this->baseTable}_lang.btn_url, {$this->baseTable}_lang.active, {$this->baseTable}_images.image_full, {$this->baseTable}_images.image_resize, {$this->baseTable}_images.image_thumb, {$this->baseTable}_lang.cms_banner, {$this->baseTable}_lang.cms_banner_mobile FROM {$this->baseTable} LEFT JOIN {$this->baseTable}_lang ON {$this->baseTable}_lang.parent = {$this->baseTable}.id AND {$this->baseTable}_lang.fk_lang = {$this->lang} LEFT JOIN {$this->baseTable}_images ON {$this->baseTable}_images.parent = {$this->baseTable}.id AND {$this->baseTable}_images.main = 1 AND (({$this->baseTable}_images.fk_lang = {$this->lang} AND {$this->baseTable}.images_bylang = 1) OR {$this->baseTable}.images_bylang = 0) WHERE {$this->baseTable}.deleted = 0 AND {$this->baseTable}_lang.active = 1 AND {$this->baseTable}.parent = $parentID $idFilter ORDER BY -{$this->baseTable}.pos DESC LIMIT 0, 1";
		$item = \DB::results($sql, true);

		$slider = array(
			"title"	=> $item['title'] ? $item['title'] : $item['name'],
			"subtitle"	=> $item['subtitle'],
			"button" => array(
				"label"	=> $item['btn_label'] ? $item['btn_label'] : \Lang\Dictionary::get('learn more'),
				"url"	=> \Data\Str::fixUrl($item['btn_url']),
			),
			/*"slider" => array(
				"desktop" => array(
					"ratio"	=> $item['cms_banner_ratio'],
					"content"	=> \Data\Str::mediaSrcCorrect($item['cms_banner']),
				),
				"mobile" => array(
					"ratio"	=> $item['cms_banner_mobile_ratio'],
					"content"	=> \Data\Str::mediaSrcCorrect($item['cms_banner_mobile']),
				),
			)*/
		);

		return $slider;
	}

	public function items($parentID=0, $excludeIDs = null, $limit = null) {
		$idFilter = '';
		if (is_array($excludeIDs) && !empty($excludeIDs)) {
			$idFilter .= " AND {$this->baseTable}.id NOT IN (".implode(', ', $excludeIDs).")";
		}

		$sql = "SELECT {$this->baseTable}.*, {$this->baseTable}_lang.title, {$this->baseTable}_lang.subtitle, {$this->baseTable}_lang.btn_label, {$this->baseTable}_lang.btn_url, {$this->baseTable}_lang.active, {$this->baseTable}_images.image_full, {$this->baseTable}_images.image_resize, {$this->baseTable}_images.image_thumb, {$this->baseTable}_lang.cms_banner, {$this->baseTable}_lang.cms_banner_mobile FROM {$this->baseTable} LEFT JOIN {$this->baseTable}_lang ON {$this->baseTable}_lang.parent = {$this->baseTable}.id AND {$this->baseTable}_lang.fk_lang = {$this->lang} LEFT JOIN {$this->baseTable}_images ON {$this->baseTable}_images.parent = {$this->baseTable}.id AND {$this->baseTable}_images.main = 1 AND (({$this->baseTable}_images.fk_lang = {$this->lang} AND {$this->baseTable}.images_bylang = 1) OR {$this->baseTable}.images_bylang = 0) WHERE {$this->baseTable}.deleted = 0 AND {$this->baseTable}_lang.active = 1 AND {$this->baseTable}.parent = $parentID $idFilter ORDER BY -{$this->baseTable}.pos DESC";
		$items = DB::results($sql);

		$sliders = array();
		foreach ($items as $item) {
			$sliders[$item['id']] = array(
				"title"	=> $item['title'] ? $item['title'] : $item['name'],
				"subtitle"	=> $item['subtitle'],
				"button" => array(
					"label"	=> $item['btn_label'] ? $item['btn_label'] : \Lang\Dictionary::get('learn more'),
					"url"	=> \Data\Str::fixUrl($item['btn_url']),
				),
				/*"slider" => array(
					"desktop" => array(
						"ratio"	=> $item['cms_banner_ratio'],
						"content"	=> \Data\Str::mediaSrcCorrect($item['cms_banner']),
					),
					"mobile" => array(
						"ratio"	=> $item['cms_banner_mobile_ratio'],
						"content"	=> \Data\Str::mediaSrcCorrect($item['cms_banner_mobile']),
					),
				)*/
			);
		}

		return $sliders;
	}
	
}