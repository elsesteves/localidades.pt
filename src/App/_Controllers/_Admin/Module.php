<?php

namespace Controllers\Admin;

Class Module {

	protected $module = '';
	protected $submodule = '';

	public static function construct(string $module, string $submodule = '') {
		$this->module = $module;
		$this->submodule = $submodule;
	}

	public static function index($id = null) {
		
	}

	public static function list($id = null) {
		
	}

	public static function dataTab($id = null, $tab = '') {
		$this->module = $module;
		$className = \Data\Str::convertModule2ClassName($this->module);

		var_dump($this->module);
		var_dump($this->submodule);
		die();

		if (class_exists('\Models\Admin\\'.$className)) {
			$className = '\Models\Admin\\'.$className;
			$moduleModel = new $className();
		} else {
			$moduleModel = new \Models\Admin\Module($this->module);
		}
		
		$info = $moduleModel->item();

		if (\User\Admin::isActionAllowed($this->module, 'edit', 'data_show', $info['id'])) {
			$file = array(
				"folder" => $this->module,
				"file" => 'edit',
				"tab" => 'data',
			);

			$data = array(
				"tabs" => \Models\Admin\Menu::editPageTabs($this->module),
				"info" => $info,
				"base_table" => $this->module,
			);

			adminView($file, $data);
		} else {
			$file = array(
				"folder" => 'errors',
				"file" => '403',
			);
			$data = array();

			adminView($file, $data, 403);
		}

	}

}