<?php

namespace Models;

Class Projects extends \Module {

	public function __construct()
	{
		parent::__construct('projects');
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

	public function item($id) {
		$sql = "SELECT {$this->baseTable}.*, {$this->baseTable}_lang.title, {$this->baseTable}_lang.subtitle, {$this->baseTable}_lang.description, {$this->baseTable}_lang.url, {$this->baseTable}_images.image_full, {$this->baseTable}_images.image_resize, {$this->baseTable}_images.image_thumb FROM {$this->baseTable} LEFT JOIN {$this->baseTable}_lang ON {$this->baseTable}_lang.parent = {$this->baseTable}.id AND {$this->baseTable}_lang.fk_lang = {$this->lang} LEFT JOIN {$this->baseTable}_images ON {$this->baseTable}_images.parent = {$this->baseTable}.id AND {$this->baseTable}_images.main = 1 AND (({$this->baseTable}_images.fk_lang = {$this->lang} AND {$this->baseTable}.images_bylang = 1) OR {$this->baseTable}.images_bylang = 0) WHERE {$this->baseTable}.deleted = 0 AND {$this->baseTable}_lang.active = 1 AND {$this->baseTable}.id = $id";
		$item = \DB::results($sql, true);

		if (!exists($item)) {
			return false;
		}

		$info = array(
			"title" => $item['title'] ? $item['title'] : $item['name'],
			"description" => $item['description'],
			"url" => $item['url'],
			"image" => array(
				"original" => $item['image_full'],
				"resize" => $item['image_resize'],
				"thumb" => $item['image_thumb'],
			),
		);

		return $item;
	}

	public function itemTotalCount(int $parentID, array $excludeIDs = null) {
		$sql = "SELECT {$this->baseTable}.*, {$this->baseTable}_lang.title, {$this->baseTable}_lang.subtitle, {$this->baseTable}_lang.description, {$this->baseTable}_lang.url, {$this->baseTable}_images.image_full, {$this->baseTable}_images.image_resize, {$this->baseTable}_images.image_thumb FROM {$this->baseTable} LEFT JOIN {$this->baseTable}_lang ON {$this->baseTable}_lang.parent = {$this->baseTable}.id AND {$this->baseTable}_lang.fk_lang = {$this->lang} LEFT JOIN {$this->baseTable}_images ON {$this->baseTable}_images.parent = {$this->baseTable}.id AND {$this->baseTable}_images.main = 1 AND (({$this->baseTable}_images.fk_lang = {$this->lang} AND {$this->baseTable}.images_bylang = 1) OR {$this->baseTable}.images_bylang = 0) WHERE {$this->baseTable}.deleted = 0 AND {$this->baseTable}_lang.active = 1 AND {$this->baseTable}.parent = $parentID";

		if (is_array($excludeIDs) && !empty($excludeIDs)) {
			$sql .= " AND {$this->baseTable}.id NOT IN (".implode(', ', $excludeIDs).")";
		}

		$count = \DB::count($sql);
		return $count;
	}

	public function itemsList(int $parentID, array $excludeIDs = null, int $limit = null, int $offset = 0, bool $rand = false) {

		$sql = "SELECT {$this->baseTable}.*, {$this->baseTable}_lang.title, {$this->baseTable}_lang.subtitle, {$this->baseTable}_lang.description, {$this->baseTable}_lang.url, {$this->baseTable}_images.image_full, {$this->baseTable}_images.image_resize, {$this->baseTable}_images.image_thumb FROM {$this->baseTable} LEFT JOIN {$this->baseTable}_lang ON {$this->baseTable}_lang.parent = {$this->baseTable}.id AND {$this->baseTable}_lang.fk_lang = {$this->lang} LEFT JOIN {$this->baseTable}_images ON {$this->baseTable}_images.parent = {$this->baseTable}.id AND {$this->baseTable}_images.main = 1 AND (({$this->baseTable}_images.fk_lang = {$this->lang} AND {$this->baseTable}.images_bylang = 1) OR {$this->baseTable}.images_bylang = 0) WHERE {$this->baseTable}.deleted = 0 AND {$this->baseTable}_lang.active = 1 AND {$this->baseTable}.parent = $parentID";

		if (is_array($excludeIDs) && !empty($excludeIDs)) {
			$sql .= " AND {$this->baseTable}.id NOT IN (".implode(', ', $excludeIDs).")";
		}

		if ($rand) {
			$sql .= " ORDER BY RAND()";
		} else {
			$sql .= " ORDER BY -{$this->baseTable}.pos DESC";
		}

		if (exists($limit)) {
			$sql .= " LIMIT ".(int) $limit;
		}

		if (exists($offset)) {
			$sql .= " OFFSET ".(int) $offset;
		}

		$items = \DB::results($sql);

		$list = array();
		foreach ($items as $item) {
			$title = $item['title'] ? $item['title'] : $item['name'];

			$list[$item['id']] = array(
				"title"	=> $title,
				//"url" => $item['url'],
				"url" => 'projects/' . $item['id'] . '/'. \Data\Str::permalink_clean($title),
				"image" => array(
					"full" => $item['image_full'],
					"resize" => $item['image_resize'],
					"thumb" => $item['image_thumb'],
				),
			);
		}

		return $list;
	}
}