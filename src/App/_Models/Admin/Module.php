<?php

namespace Models\Admin;

Class Module extends \Module {

	public function __construct($module) {
		parent::__construct($module);
		$this->lang = \Lang\Lang::getLanguage('admin');
	}

}