<?php

namespace Models;

Class Locations extends \Module {

	public function __construct()
	{
		parent::__construct('locations');
	}

	public function main() {

		$sql = "SELECT {$this->baseTable}.*, {$this->baseTable}_lang.title, {$this->baseTable}_lang.address FROM {$this->baseTable} LEFT JOIN {$this->baseTable}_lang ON {$this->baseTable}_lang.parent = {$this->baseTable}.id AND {$this->baseTable}_lang.fk_lang = {$this->lang} LEFT JOIN {$this->baseTable}_images ON {$this->baseTable}_images.parent = {$this->baseTable}.id AND {$this->baseTable}_images.main = 1 AND (({$this->baseTable}_images.fk_lang = {$this->lang} AND {$this->baseTable}.images_bylang = 1) OR {$this->baseTable}.images_bylang = 0) WHERE {$this->baseTable}.deleted = 0 AND {$this->baseTable}_lang.active = 1 AND {$this->baseTable}_lang.main = 1 ORDER BY -{$this->baseTable}.pos DESC";
		$item = \DB::results($sql, true);

		$output = array();

		if (!empty($item)) {
			$title = $item['title'] ? $item['title'] : $item['name'];
			$output = array(
				"title" => $title,
				"address"	=> $item['address'],
				"phones"	=> $this->phones($item['id']),
				"emails"	=> $this->emails($item['id']),
				"social" 	=> $this->social($item['id']),
			);
		}

		return $output;
	}

	protected function phones($parentID) {
		$sql = "SELECT * FROM {$this->baseTable}_phones WHERE parent = $parentID AND fk_lang = {$this->lang} AND {$this->baseTable}_phones.deleted = 0 AND {$this->baseTable}_phones.active = 1 ORDER BY -{$this->baseTable}_phones.pos DESC";
		$items = \DB::results($sql);

		$phones = array();
		foreach ($items as $item) {
			$phones[$item['id']] = array(
				"name"	=> $item['name'],
				"number" => $item['value'],
				"number_call" => \Data\Str::phoneNumber($item['value']),
			);
		}

		return $phones;
	}

	protected function emails($parentID) {
		$sql = "SELECT * FROM {$this->baseTable}_emails WHERE parent = $parentID AND fk_lang = {$this->lang} AND {$this->baseTable}_emails.deleted = 0 AND {$this->baseTable}_emails.active = 1 ORDER BY -{$this->baseTable}_emails.pos DESC";
		$items = \DB::results($sql);

		$emails = array();
		foreach ($items as $item) {
			$emails[$item['id']] = array(
				"name"	=> $item['name'],
				"address" => $item['value'],
			);
		}

		return $emails;		
	}

	protected function social($parentID) {
		$sql = "SELECT * FROM {$this->baseTable}_social WHERE parent = $parentID AND fk_lang = {$this->lang} AND {$this->baseTable}_social.deleted = 0 AND {$this->baseTable}_social.active = 1 ORDER BY -{$this->baseTable}_social.pos DESC";
		$items = \DB::results($sql);

		$emails = array();
		foreach ($items as $item) {
			$networkInfo = \SocialNetwork::info($item['value']);
			$emails[$item['id']] = array(
				"name"	=> $networkInfo['name'],
				"icon"	=> $networkInfo['icon'],
				"url" => $item['value'],
			);
		}

		return $emails;
		
	}

}