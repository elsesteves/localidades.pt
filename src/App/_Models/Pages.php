<?php

namespace Models;

Class Pages extends \Module {

	public function __construct()
	{
		parent::__construct('pages');
	}

	public function category($id) {
		$sql = "SELECT {$this->baseTable}_categories.*, {$this->baseTable}_categories_lang.title, {$this->baseTable}_categories_lang.active, {$this->baseTable}_categories_images.image_full, {$this->baseTable}_categories_images.image_resize, {$this->baseTable}_categories_images.image_thumb FROM {$this->baseTable}_categories LEFT JOIN {$this->baseTable}_categories_lang ON {$this->baseTable}_categories_lang.parent = {$this->baseTable}_categories.id AND {$this->baseTable}_categories_lang.fk_lang = {$this->lang} LEFT JOIN {$this->baseTable}_categories_images ON {$this->baseTable}_categories_images.parent = {$this->baseTable}_categories.id AND {$this->baseTable}_categories_images.main = 1 AND (({$this->baseTable}_categories_images.fk_lang = {$this->lang} AND {$this->baseTable}_categories.images_bylang = 1) OR {$this->baseTable}_categories.images_bylang = 0) WHERE {$this->baseTable}_categories.deleted = 0 AND {$this->baseTable}_categories.id = $id ORDER BY -{$this->baseTable}_categories.pos DESC";
		$categories = \DB::results($sql);
		$output = array();

		foreach ($categories as $category) {
			$title = $category['title'] ? $category['title'] : $category['name'];
			$output = array(
				"title"	=> $title,
				"pages"	=> $this->itemsList($category['id']),
			);
		}

		return $output;
	}

	public function mainPages() {
		return $this->itemsList(1, array(6));
	}

	public function itemsList($parentID, $excludeIds = null) {

		$items = $this->items($parentID, $excludeIds);

		$list = array();
		foreach ($items as $item) {
			$title = $item['title'] ? $item['title'] : $item['name'];

			$list[$item['id']] = array(
				"title"	=> $title,
				"url" => $item['url'] ? \Data\Str::fixUrl($item['url']) : \Data\Str::fixUrl('/pages/'.$item['id'].'/'.\Data\Str::permalink_clean($title)),
			);
		}

		return $list;
	}

	public function item($id) {
		$sql = "SELECT {$this->baseTable}.*, {$this->baseTable}_lang.title, {$this->baseTable}_lang.subtitle, {$this->baseTable}_lang.description, {$this->baseTable}_lang.url, {$this->baseTable}_images.image_full, {$this->baseTable}_images.image_resize, {$this->baseTable}_images.image_thumb FROM {$this->baseTable} LEFT JOIN {$this->baseTable}_lang ON {$this->baseTable}_lang.parent = {$this->baseTable}.id AND {$this->baseTable}_lang.fk_lang = {$this->lang} LEFT JOIN {$this->baseTable}_images ON {$this->baseTable}_images.parent = {$this->baseTable}.id AND {$this->baseTable}_images.main = 1 AND (({$this->baseTable}_images.fk_lang = {$this->lang} AND {$this->baseTable}.images_bylang = 1) OR {$this->baseTable}.images_bylang = 0) WHERE {$this->baseTable}.deleted = 0 AND {$this->baseTable}_lang.active = 1 AND {$this->baseTable}.id = $id ORDER BY -{$this->baseTable}.pos DESC";
		$item = \DB::results($sql, true);

		$page = array();
		if (exists($item)) {
			$page = array(
				"id" => $item['id'],
				"title" => $item['title'] ? $item['title'] : $item['name'],
				"description" => $item['description'],
			);
		}

		return $page;
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

}