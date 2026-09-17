<?php

namespace Models\Admin;

Class Menu {

	protected static function isHiddenTab($baseTable, $tabName) {
		//Settings page: module:admin file:edit tab:data
		//However it does not show the other tabs
		if ($baseTable =='account' && !in_array($tabName, array('data'))) {
			return true;
		}

		//Products should only have a shipping tab if shipping by weight is disabled
		if ($baseTable =='products' && $tabName =='shipping' && \Settings::getSetting('shipping_by_weight')) {
			return true;
		}

		if ($baseTable =='shipping_zones' && $tabName =='weights' && !\Settings::getSetting('shipping_by_weight')) {
			return true;
		}

		return false;
	}

	public static function editPageTabs($module, $submodule = '') {
		$baseTable = $submodule ? $module . '_' . $submodule : $module;

		$sql = "SELECT _modules_tabs.*, _modules_tabs_lang.title 
					FROM _modules_tabs 
					INNER JOIN _modules 
						ON _modules_tabs.parent = _modules.id 
					LEFT JOIN _modules_tabs_lang 
						ON _modules_tabs_lang.parent = _modules_tabs.id 
						AND _modules_tabs_lang.fk_lang = 1 
					WHERE _modules.name = '$baseTable' 
						AND _modules_tabs.deleted = 0 
					ORDER BY -_modules_tabs.pos DESC";
		$results = \DB::results($sql);

		$tabs = array();
		foreach($results as $result) {
			if(self::isHiddenTab($baseTable, $result['name'])) {
				continue;
			}

			array_push($tabs, array(
				"module" => $module,
				"submodule" => $submodule,
				"name" => $result['name'],
				"title" => $result['title'],
				"fa_icon" => $result['fa_icon'],
			));
		}

		return $tabs;
	}

	public static function sidebar() {
		$errors = array();

		if (\User\Admin::logIn($email, $password, $errors)) {
			$url = '/admin';

			if (exists($_POST['ref'])) {
				$url = $_POST['ref'];
			}
		} else {
			$url = '/admin/login';
		}

		redirect($url);
	}

	public static function sidebarItems($parentID) {
		$sql = "SELECT admin_menu_items.*, admin_menu_items_lang.title, admin_menu_items_lang.description, admin_permissions.name as permission_name, admin_permission_categories.name as permission_group 
					FROM admin_menu_items 
						LEFT JOIN admin_menu_items_lang 
							ON admin_menu_items_lang.parent = admin_menu_items.id 
								AND admin_menu_items_lang.fk_lang = 1 
						LEFT JOIN admin_permissions 
							ON admin_menu_items.permission_show = admin_permissions.id 
						LEFT JOIN admin_permission_categories 
							ON admin_permissions.parent = admin_permission_categories.id WHERE admin_menu_items.parent = $parentID 
								AND active = 1 
					ORDER BY -admin_menu_items.pos DESC";
		
		$results = \DB::results($sql);

		$items = array();
		$hasAllowedItems = false;

		foreach($results as $result) {
			$allowed = \User\Admin::permissionCheck($result['permission_group'], $result['permission_name']);
			$children = self::sidebarItems($result['id']);

		   	if ($allowed || $children['has_allowed_items']) {
				$hasAllowedItems = true;
			}			

			$items[$result['id']] = array(
				"info" => array(
					"id" => $result['id'],
					"title" => $result['title'],
					//"module" => $result['module'],
					"link" => $result['link'],
				),
				"allowed" => $allowed,
				"items" => $children['items'],
				"has_allowed_items" => $children['has_allowed_items'],
			);
		}

		$output = array(
			"items" => $items,
			"has_allowed_items" => $hasAllowedItems,
		);

		return $output;
	}
	
}