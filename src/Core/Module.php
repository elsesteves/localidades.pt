<?php

class Module {

	protected $baseTable;
	protected $lang;

	public function __construct($baseTable)
	{
		$this->baseTable = $baseTable;
		$this->lang = \Lang\Lang::getLanguage();
	}

	public function images($itemId) {
		$sql = "SELECT {$this->baseTable}_images.id, {$this->baseTable}_images.image_full, {$this->baseTable}_images.image_resize, {$this->baseTable}_images.image_thumb, {$this->baseTable}_images_lang.caption FROM {$this->baseTable} INNER JOIN {$this->baseTable}_images ON {$this->baseTable}_images.parent = {$this->baseTable}.id LEFT JOIN {$this->baseTable}_images_lang ON {$this->baseTable}_images_lang.parent = {$this->baseTable}_images.id AND {$this->baseTable}_images_lang.fk_lang = {$this->lang} WHERE {$this->baseTable}_images.parent = $itemId AND (({$this->baseTable}.images_bylang = 1 AND {$this->baseTable}_images.fk_lang = {$this->lang}) OR {$this->baseTable}.images_bylang = 0) AND {$this->baseTable}_images.active = 1 AND {$this->baseTable}_images.deleted = 0 ORDER BY -{$this->baseTable}_images.pos DESC, {$this->baseTable}_images.id ASC";
		$images = DB::results($sql);
		return $images;
	}

	public function image_opengraph($itemId) {
		$sql = "SELECT {$this->baseTable}_images.id, {$this->baseTable}_images.image_full, {$this->baseTable}_images.image_resize, {$this->baseTable}_images.image_thumb FROM {$this->baseTable} INNER JOIN {$this->baseTable}_images ON {$this->baseTable}_images.parent = {$this->baseTable}.id WHERE {$this->baseTable}_images.parent = $itemId AND (({$this->baseTable}.images_bylang = 1 AND {$this->baseTable}_images.fk_lang = {$this->lang}) OR {$this->baseTable}.images_bylang = 0) AND {$this->baseTable}_images.deleted = 0 AND {$this->baseTable}_images.opengraph = 1";

		$image = DB::results($sql, true);
		return $image;
	}

	public function docs($itemId) {
		$sql = "SELECT {$this->baseTable}_docs.* FROM {$this->baseTable}_docs LEFT JOIN {$this->baseTable} ON {$this->baseTable}_docs.parent = {$this->baseTable}.id WHERE {$this->baseTable}_docs.parent = $itemId AND (({$this->baseTable}.docs_bylang = 1 AND {$this->baseTable}_docs.fk_lang = {$this->lang}) OR {$this->baseTable}.docs_bylang = 0) AND {$this->baseTable}_docs.deleted = 0 AND {$this->baseTable}_docs.active = 1 ORDER BY -{$this->baseTable}_docs.pos DESC, {$this->baseTable}_docs.id ASC";
		$docs = DB::results($sql);
		return $docs;
	}

	public function videos($itemId) {
		$sql = "SELECT * FROM {$this->baseTable}_videos LEFT JOIN {$this->baseTable} ON {$this->baseTable}_videos.parent = {$this->baseTable}.id WHERE {$this->baseTable}_videos.parent = $itemId AND (({$this->baseTable}.videos_bylang = 1 AND {$this->baseTable}_videos.fk_lang = {$this->lang}) OR {$this->baseTable}.videos_bylang = 0) AND {$this->baseTable}_videos.deleted = 0 AND {$this->baseTable}_videos.active = 1 ORDER BY -{$this->baseTable}_videos.pos DESC";
		$videos = DB::results($sql);
		return $videos;
	}

	public function features($itemId) {
		$sql = "SELECT * FROM {$this->baseTable}_features WHERE parent = $itemId AND fk_lang = {$this->lang} AND {$this->baseTable}_features.deleted = 0 AND {$this->baseTable}_features.active = 1 ORDER BY -{$this->baseTable}_features.pos DESC";
		$features = DB::results($sql);
		return $features;
	}

	public function keywords($itemId) {
		$sql = "SELECT keyword FROM {$this->baseTable}_keywords WHERE parent = $itemId AND fk_lang = {$this->lang} AND {$this->baseTable}_keywords.deleted = 0 AND {$this->baseTable}_keywords.active = 1 ORDER BY -{$this->baseTable}_keywords.pos DESC";
		$keywords = DB::results($sql);
		return $keywords;
	}

	public function categories($parentID) {
		$sql = "SELECT {$this->baseTable}_categories.*, {$this->baseTable}_categories_lang.title, {$this->baseTable}_categories_images.image_full, {$this->baseTable}_categories_images.image_resize, {$this->baseTable}_categories_images.image_thumb FROM {$this->baseTable}_categories LEFT JOIN {$this->baseTable}_categories_lang ON {$this->baseTable}_categories_lang.parent = {$this->baseTable}_categories.id AND {$this->baseTable}_categories_lang.fk_lang = {$this->lang} LEFT JOIN {$this->baseTable}_categories_images ON {$this->baseTable}_categories_images.parent = {$this->baseTable}_categories.id AND {$this->baseTable}_categories_images.main = 1 AND (({$this->baseTable}_categories_images.fk_lang = {$this->lang} AND {$this->baseTable}_categories.images_bylang = 1) OR {$this->baseTable}_categories.images_bylang = 0) WHERE {$this->baseTable}_categories.deleted = 0 AND {$this->baseTable}_categories_lang.active = 1 AND {$this->baseTable}_categories.parent = $parentID ORDER BY -{$this->baseTable}_categories.pos DESC";
		$categories = DB::results($sql);
		return $categories;
	}

	public function item($id) {
		$lang_id = $this->lang;

		$sql = "SELECT {$this->baseTable}.*, {$this->baseTable}_lang.*, {$this->baseTable}.id, {$this->baseTable}_images.image_full, {$this->baseTable}_images.image_resize, {$this->baseTable}_images.image_thumb FROM {$this->baseTable} LEFT JOIN {$this->baseTable}_lang ON {$this->baseTable}_lang.parent = {$this->baseTable}.id AND {$this->baseTable}_lang.fk_lang = {$lang_id} LEFT JOIN {$this->baseTable}_images ON {$this->baseTable}_images.parent = {$this->baseTable}.id AND {$this->baseTable}_images.main = 1 AND (({$this->baseTable}_images.fk_lang = {$this->lang} AND {$this->baseTable}.images_bylang = 1) OR {$this->baseTable}.images_bylang = 0) WHERE {$this->baseTable}.deleted = 0 AND {$this->baseTable}_lang.active = 1 AND {$this->baseTable}.id = $id";

		$item = DB::results($sql, true);

		if (empty($item)) {
			return false;
		}

		return $item;
	}

	public function items($parentID=null, $options=null) {
		$lang_id = $this->lang;
		if (exists($options['lang_id'])) {
			$lang_id = (int) $options['lang_id'];
		}

		$parentFilter = '';
		if (exists($parentID)) {
			$parentFilter = " AND {$this->baseTable}.parent = $parentID";
		}

		if (exists($options['exclude_parents'])  && is_array($options['exclude_parents'])) {
			$parentFilter .= " AND {$this->baseTable}.parent NOT IN (".implode(', ', $options['exclude_parents']).")";
		}

		$idFilter = '';
		if (exists($options['exclude_ids']) && is_array($options['exclude_ids'])) {
			$idFilter .= " AND {$this->baseTable}.id NOT IN (".implode(', ', $options['exclude_ids']).")";
		}

		$sql = "SELECT {$this->baseTable}.*, {$this->baseTable}_lang.*, {$this->baseTable}.id, {$this->baseTable}_images.image_full, {$this->baseTable}_images.image_resize, {$this->baseTable}_images.image_thumb FROM {$this->baseTable} LEFT JOIN {$this->baseTable}_lang ON {$this->baseTable}_lang.parent = {$this->baseTable}.id AND {$this->baseTable}_lang.fk_lang = {$lang_id} LEFT JOIN {$this->baseTable}_images ON {$this->baseTable}_images.parent = {$this->baseTable}.id AND {$this->baseTable}_images.main = 1 AND (({$this->baseTable}_images.fk_lang = {$this->lang} AND {$this->baseTable}.images_bylang = 1) OR {$this->baseTable}.images_bylang = 0) WHERE {$this->baseTable}.deleted = 0 AND {$this->baseTable}_lang.active = 1 $parentFilter $idFilter ORDER BY -{$this->baseTable}.pos DESC";

		if (exists($options['limit'])) {
			$sql .= " LIMIT ";
			if (exists($options['offset'])) {
				$sql .= (int) $options['offset'] . ', ';
			}
			$sql .= (int) $options['limit'];
		}

		$items = DB::results($sql);
		return $items;
	}

}