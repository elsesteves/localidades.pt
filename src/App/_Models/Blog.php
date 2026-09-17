<?php

namespace Models;

Class Blog extends \Module {

	public function __construct()
	{
		parent::__construct('blog');
	}

	public function item_seo($id) {
		$sql = "SELECT {$this->baseTable}_lang.seo_title, {$this->baseTable}_lang.seo_description FROM {$this->baseTable} LEFT JOIN {$this->baseTable}_lang ON {$this->baseTable}_lang.parent = {$this->baseTable}.id AND {$this->baseTable}_lang.fk_lang = {$this->lang} LEFT JOIN {$this->baseTable}_images ON {$this->baseTable}_images.parent = {$this->baseTable}.id AND {$this->baseTable}_images.main = 1 AND (({$this->baseTable}_images.fk_lang = {$this->lang} AND {$this->baseTable}.images_bylang = 1) OR {$this->baseTable}.images_bylang = 0) WHERE {$this->baseTable}.deleted = 0 AND {$this->baseTable}_lang.active = 1 AND {$this->baseTable}.id = $id";
		$item = \DB::results($sql, true);

		$seo = array(
			"title" => $item['seo_title'],
			"description" => $item['seo_description'],
			"keywords" => $this->keywords($id),
			"opengraph" => array(
				"image" => $this->image_opengraph($id),
			),
		);

		return $seo;
	}

	public function list($parentID=null, $options=null) {
		$items = $this->items($parentID, $options);

		$output = array();

		foreach($items as $item) {
			$title = $item['title'] ? $item['title'] : $item['name'];

			array_push($output, array(
				"id" => $item['id'],
				"title" => $title,
				"description" => $item['description'],
				"url" => '/blog/'.$item['id'].'/'.\Data\Str::permalink_clean($title),
				"image" => array(
					"full" => $item['image_full'],
					"resize" => $item['image_resize'],
					"thumb" => $item['image_thumb'],
				),
				"page" => $item['cms_page'],
				"time_lastmod" => $item['time_lastmod'],
			));
		}

		return $output;
	}

	public function page($id) {
		$item = $this->item($id);

		if ($item === false) {
			return false;
		}

		$title = $item['title'] ? $item['title'] : $item['name'];

		$output = array(
			"id" => $item['id'],
			"title" => $title,
			"description" => $item['description'],
			"url" => '/blog/'.$item['id'].'/'.\Data\Str::permalink_clean($title),
			"image" => array(
				"full" => $item['image_full'],
				"resize" => $item['image_resize'],
				"thumb" => $item['image_thumb'],
			),
			"page" => $item['cms_page'],
		);

		return $output;
	}

}