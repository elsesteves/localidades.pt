<?php

class Site {

	protected static $baseTable;
	protected static $lang;

	protected static function start() {
		self::$baseTable = 'site';
		self::$lang = \Lang\Lang::getLanguage();
	}

	public static function phones($id) {
		if (!exists(self::$baseTable) || !exists(self::$lang)) {
			self::start(); 
		}
		$baseTable = self::$baseTable;
		$lang = self::$lang;

		$sql = "SELECT * FROM {$baseTable}_phones WHERE parent = $id AND fk_lang = $lang AND {$baseTable}_phones.deleted = 0 AND {$baseTable}_phones.active = 1 ORDER BY -{$baseTable}_phones.pos DESC";
		$items = DB::results($sql);

		$phones = array();

		foreach ($items as $item) {
			array_push($phones, array(
				"id" => $item['id'],
				"label" => $item['name'],
				"number" => array(
					"unformatted" => $item['value'],
					"formatted" => \Data\Str::phoneNumber($item['value']),
				),
			));
		}

		return $phones;
	}

	public static function emails($id) {
		if (!exists(self::$baseTable) || !exists(self::$lang)) {
			self::start(); 
		}
		$baseTable = self::$baseTable;
		$lang = self::$lang;

		$sql = "SELECT * FROM {$baseTable}_emails WHERE parent = $id AND fk_lang = $lang AND {$baseTable}_emails.deleted = 0 AND {$baseTable}_emails.active = 1 ORDER BY -{$baseTable}_emails.pos DESC";
		$items = DB::results($sql);

		$emails = array();

		foreach ($items as $item) {
			array_push($emails, array(
				"id" => $item['id'],
				"label" => $item['name'],
				"email" => $item['value'],
			));
		}

		return $emails;
	}

	public static function social($id) {
		if (!exists(self::$baseTable) || !exists(self::$lang)) {
			self::start(); 
		}
		$baseTable = self::$baseTable;
		$lang = self::$lang;

		$sql = "SELECT * FROM {$baseTable}_social WHERE parent = $id AND fk_lang = $lang AND {$baseTable}_social.deleted = 0 AND {$baseTable}_social.active = 1 ORDER BY -{$baseTable}_social.pos DESC";
		$items = DB::results($sql);

		$social = array();

		foreach ($items as $item) {
			array_push($social, array(
				"id" => $item['id'],
				"network" => SocialNetwork::info($item['value']),
				"url" => $item['value'],
			));
		}

		return $social;
	}

	public static function info() {
		/*
		if (!exists(self::$baseTable) || !exists(self::$lang)) {
			self::start(); 
		}

		$baseTable = self::$baseTable;
		$lang = self::$lang;
		$module = new Module($baseTable);

		$sql = "SELECT {$baseTable}.id, {$baseTable}.name, {$baseTable}_lang.title, {$baseTable}_lang.description AS address, {$baseTable}_lang.seo_description, {$baseTable}_lang.seo_title, {$baseTable}_lang.gps_lat, {$baseTable}_lang.gps_lng FROM {$baseTable} LEFT JOIN {$baseTable}_lang ON {$baseTable}_lang.parent = {$baseTable}.id AND {$baseTable}_lang.fk_lang = {$lang} WHERE {$baseTable}.deleted = 0 AND {$baseTable}_lang.active = 1 LIMIT 1";
		$item = DB::results($sql, true);

		$keywords = array();
		if (exists($item)) {
			foreach ($module->keywords($item['id']) as $key => $keyword) {
				array_push($keywords, $keyword['keyword']);
			}

			$info = array(
				"title" => $item['title'] ? $item['title'] : $item['name'],
				"address" => $item['address'],
				"coords" => array(
					"lat" => $item['gps_lat'],
					"lng" => $item['gps_lng'],
				),
				"seo" => array(
					"title" => $item['seo_title'],
					"description" => $item['seo_description'],
					"keywords" => implode(', ', $keywords),
					"opengraph" => array(
						"image" => $module->image_opengraph($item['id']),
					),
				),				
				"phones" => self::phones($item['id']),
				"emails" => self::emails($item['id']),
				"social" => self::social($item['id']),
			);
		} else {
			$info = array(
				"title" => '',
				"address" => '',
				"seo" => array(
					"title" => '',
					"description" => '',
					"keywords" => '',
					"opengraph" => array(
						"image" => $module->image_opengraph($id),
					),
				),
				"opengraph" => array(
					"image" => '',
				),
			);
		}

		*/

		$info = array();

		return $info;
	}

}