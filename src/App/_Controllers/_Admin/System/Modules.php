<?php

namespace Controllers\Admin\System;

Class Modules {

	public static function addModuleForm($id = null) {
		\Models\Admin\System\Modules::generateModule($_POST, $id_parent = null);
	}

	public static function posForm($id = null) {
		dd($_POST);
	}

	public static function index($id = null) {
		/*
		if (!\User\Admin::isLoggedIn()) {
			redirect('/admin/login');
		}
		*/

		$file = array(
			"folder" => 'system/modules',
			"file" => 'index',
		);

		$modules = \Models\Admin\System\Modules::list($id);
		$tabs = \Models\Admin\System\Modules::availableTabs($id);

		$data = array(
			"display" => array(
				"title" => 'Listagem de Módulos',
				"top_actions" => array(
					"add" => array(
						'button' => 'Adicionar Módulo',
						"title" => 'Adicionar Módulo',
						"subtitle" => 'Dados do Módulo',
						"save_button" => 'Gravar',
					),
				),
			),		
			"rows" => $modules,
			"addform_options" => array(
				"settings" => \Models\Admin\System\Modules::availableTabSettings(),
				"permissions" => \Models\Admin\System\Modules::availablePermissionsSettings(),
				"tabs" => $tabs,
			),
			"id" => $id,
		);

		if (exists($id)) {
			$item = \Models\Admin\System\Modules::moduleInfo($id);
			$data["display"]["item"] = \Models\Admin\System\Modules::moduleInfo($id);

			$data["display"]["breadcrumbs"] = array(
				array(
					"label" => "Sistema",
					"link" => projectLink("/admin/index?module=system"),
				),
				array(
					"label" => "Módulos",
					"link" => projectLink("/admin/index?module=system&submodule=module"),
				),
				array(
					"label" => $item["title"] ? $item["title"] : $item["name"],
					"link" => "",
				),
			);
		} else {
			$data["display"]["breadcrumbs"] = array(
				array(
					"label" => "Sistema",
					"link" => projectLink("/admin/index?module=system"),
				),
				array(
					"label" => "Módulos",
					"link" => "",
				),
			);
		}

		adminView($file, $data);
	}


	public static function list($id = null) {
		/*
		if (!\User\Admin::isLoggedIn()) {
			redirect('/admin/login');
		}
		*/

		$file = array(
			"folder" => null,
			"file" => 'list',
		);

		$data = array(
			"title" => 'Listagem de Módulos',
			"breadcrumbs" => array(
				array(
					"label" => "Sistema",
					"link" => "",
				),
				array(
					"label" => "Módulos",
					"link" => "",
				),
			),
		);
		adminView($file, $data);
	}

}