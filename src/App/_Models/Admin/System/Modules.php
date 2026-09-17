<?php

namespace Models\Admin\System;

Class Modules {

	protected static $modulePrefix = 'md_';

	protected static function createModuleTables($moduleName) {
		$tables = array(
			"CREATE TABLE `".self::$modulePrefix."{$moduleName}` (
			  `id` int(11) NOT NULL,
			  `parent` int(11) NOT NULL,
			  `name` text NOT NULL,
			  `active` int(11) NOT NULL DEFAULT 0,
			  `visible` int(11) NOT NULL DEFAULT 1,
			  `pos` int(11) DEFAULT NULL,
			  `dt_intro` datetime DEFAULT NULL,
			  `dt_lastmod` datetime DEFAULT NULL,
			  `dt_delete` datetime DEFAULT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
			"ALTER TABLE `".self::$modulePrefix."{$moduleName}`
			  ADD PRIMARY KEY (`id`)",
			"ALTER TABLE `".self::$modulePrefix."{$moduleName}`
			  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT",

			"CREATE TABLE `".self::$modulePrefix."{$moduleName}_lang` (
			  `id` int(11) NOT NULL,
			  `parent` int(11) NOT NULL,
			  `id_lang` int(11) DEFAULT NULL,
			  `title` text DEFAULT NULL,
			  `subtitle` text DEFAULT NULL,
			  `description` longtext DEFAULT NULL,
			  `seo_title` text NOT NULL,
			  `seo_description` longtext NOT NULL,
			  `cms_page` longtext NOT NULL,
			  `cms_banner` longtext NOT NULL,
			  `cms_banner_mobile` longtext NOT NULL,
			  `active` int(11) NOT NULL DEFAULT 0,
			  `visible` int(11) NOT NULL DEFAULT 1,
			  `pos` int(11) DEFAULT NULL,
			  `dt_intro` datetime DEFAULT NULL,
			  `dt_lastmod` datetime DEFAULT NULL,
			  `dt_delete` datetime DEFAULT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
			"ALTER TABLE `".self::$modulePrefix."{$moduleName}_lang`
			  ADD PRIMARY KEY (`id`)",
			"ALTER TABLE `".self::$modulePrefix."{$moduleName}_lang`
			  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT",
		);

		foreach ($tables as $table) {
			\DB::run($table);
		}
	}

	protected static function generateModulePermissions($id_module, $id_tab = null) {
		$sql = "SELECT p.*
					FROM sys_permissions AS p
					WHERE p.active = 1";

		if (exists($id_tab)) {
			$sql .= " AND p.id_tab = ". (int) $id_tab;
		} else {
			$sql .= " AND p.id_tab IS NULL";
		}

		$rows = \DB::results($sql);

		foreach($rows as $row) {
			$id_permission = $row['id'];

			$sql = "INSERT INTO sys_md_permissions SET
						id_module = ". (int) $id_module .",
						id_permission = ". (int) $id_permission .",
						visible = ". (int) $row['visible'];
			\DB::run($sql);
		}
	}


	protected static function generateModuleSettings($id_module, $id_tab = null) {
		$sql = "SELECT s.*
					FROM sys_md_settings AS s
					WHERE s.active = 1";

		if (exists($id_tab)) {
			$sql .= " AND s.id_tab = ". (int) $id_tab;
		} else {
			$sql .= " AND s.id_tab IS NULL";
		}

		$rows = \DB::results($sql);

		foreach($rows as $row) {
			$id_setting = $row['id'];

			$sql = "INSERT INTO sys_md_settings2modules SET
						id_module = ". (int) $id_module .",
						id_md_setting = ". (int) $id_setting .",
						visible = ". (int) $row['visible'];
			\DB::run($sql);
		}
	}

	protected static function generateModuleTabs($moduleName, $id_module, $data) {
		$tabs = self::availableTabs();

		foreach($data['tabs'] as $id_tab => $tab) {
			$sql = "INSERT INTO sys_md_tabs SET
						id_module = ". (int) $id_module.",
						id_tab = ". (int) $id_tab;

			\DB::run($sql);

			self::generateModulePermissions($id_module, $id_tab);
			self::generateModuleSettings($id_module, $id_tab);

			$tabName = $tabs[$id_tab]['name'];

			switch ($tabName) {
				case 'seo':
					self::generateKeywordsTable($moduleName);
					break;

				case 'images':
					self::generateImagesTable($moduleName);
					break;

				case 'documents':
					self::generateDocumentsTable($moduleName);
					break;

				case 'videos':
					self::generateVideosTable($moduleName);
					break;

				case 'features':
					self::generateFeaturesTable($moduleName);
					break;
				
				default:
					// code...
					break;
			}
		}
	}

	protected static function generateKeywordsTable($moduleName) {
		$tables = array(
			"CREATE TABLE `".self::$modulePrefix."{$moduleName}_keywords` (
			  `id` int(11) NOT NULL,
			  `parent` int(11) NOT NULL,
			  `id_lang` int(11) DEFAULT NULL,
			  `keyword` text NOT NULL,
			  `active` int(11) NOT NULL DEFAULT 1,
			  `visible` int(11) NOT NULL DEFAULT 1,
			  `pos` int(11) DEFAULT NULL,
			  `dt_intro` datetime DEFAULT NULL,
			  `dt_lastmod` datetime DEFAULT NULL,
			  `dt_delete` datetime DEFAULT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
			"ALTER TABLE `".self::$modulePrefix."{$moduleName}_keywords`
			  ADD PRIMARY KEY (`id`)",
			"ALTER TABLE `".self::$modulePrefix."{$moduleName}_keywords`
			  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT",
		);

		foreach ($tables as $table) {
			\DB::run($table);
		}
	}

	protected static function generateImagesTable($moduleName) {
		//IF id_parent_image NOT NULL => it's a resize, and the id_parent_image is the original pic ID

		$tables = array(
			"CREATE TABLE `".self::$modulePrefix."{$moduleName}_images` (
			  `id` int(11) NOT NULL,
			  `parent` int(11) NOT NULL,
			  `id_parent_image` int(11) DEFAULT NULL,
			  `id_lang` int(11) DEFAULT NULL,
			  `name` text NOT NULL,
			  `main` int(11) DEFAULT NULL,
			  `opengraph` int(11) DEFAULT NULL,
			  `active` int(11) NOT NULL DEFAULT 1,
			  `visible` int(11) NOT NULL DEFAULT 1,
			  `pos` int(11) DEFAULT NULL,			  
			  `dt_intro` datetime DEFAULT NULL,
			  `dt_lastmod` datetime DEFAULT NULL,
			  `dt_delete` datetime DEFAULT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
			"ALTER TABLE `".self::$modulePrefix."{$moduleName}_images`
			  ADD PRIMARY KEY (`id`)",
			"ALTER TABLE `".self::$modulePrefix."{$moduleName}_images`
			  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT",

			"CREATE TABLE `".self::$modulePrefix."{$moduleName}_images_lang` (
			  `id` int(11) NOT NULL,
			  `parent` int(11) NOT NULL,
			  `id_lang` int(11) NOT NULL,
			  `caption` text DEFAULT NULL,
			  `dt_intro` datetime DEFAULT NULL,
			  `dt_lastmod` datetime DEFAULT NULL,
			  `dt_delete` datetime DEFAULT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",		
			"ALTER TABLE `".self::$modulePrefix."{$moduleName}_images_lang`
			  ADD PRIMARY KEY (`id`)",	  	
			"ALTER TABLE `".self::$modulePrefix."{$moduleName}_images_lang`
			  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT",
		);

		foreach ($tables as $table) {
			\DB::run($table);
		}
	}

	protected static function generateDocumentsTable($moduleName) {
		$tables = array(
			"CREATE TABLE `".self::$modulePrefix."{$moduleName}_docs` (
			  `id` int(11) NOT NULL,
			  `parent` int(11) NOT NULL,
			  `id_lang` int(11) DEFAULT NULL,
			  `name` text NOT NULL,
			  `url` text DEFAULT NULL,
			  `active` int(11) NOT NULL DEFAULT 1,
			  `visible` int(11) NOT NULL DEFAULT 1,
			  `pos` int(11) DEFAULT NULL,
			  `dt_intro` datetime DEFAULT NULL,
			  `dt_lastmod` datetime DEFAULT NULL,
			  `dt_delete` datetime DEFAULT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
			"ALTER TABLE `".self::$modulePrefix."{$moduleName}_docs`
			  ADD PRIMARY KEY (`id`)",
			"ALTER TABLE `".self::$modulePrefix."{$moduleName}_docs`
			  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT",
		);

		foreach ($tables as $table) {
			\DB::run($table);
		}
	}

	protected static function generateVideosTable($moduleName) {
		$tables = array(
			"CREATE TABLE `".self::$modulePrefix."{$moduleName}_videos` (
			  `id` int(11) NOT NULL,
			  `parent` int(11) NOT NULL,
			  `id_lang` int(11) DEFAULT NULL,
			  `name` text NOT NULL,
			  `url` text NOT NULL,
			  `native_id` int(11) DEFAULT NULL,
			  `youtube_id` text DEFAULT NULL,
			  `vimeo_id` text DEFAULT NULL,
			  `active` int(11) NOT NULL DEFAULT 1,
			  `visible` int(11) NOT NULL DEFAULT 1,
			  `pos` int(11) DEFAULT NULL,
			  `dt_intro` datetime DEFAULT NULL,
			  `dt_lastmod` datetime DEFAULT NULL,
			  `dt_delete` datetime DEFAULT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
			"ALTER TABLE `".self::$modulePrefix."{$moduleName}_videos`
			  ADD PRIMARY KEY (`id`)",
			"ALTER TABLE `".self::$modulePrefix."{$moduleName}_videos`
			  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT",
		);

		foreach ($tables as $table) {
			\DB::run($table);
		}
	}

	protected static function generateFeaturesTable($moduleName) {
		$tables = array(
			"CREATE TABLE `".self::$modulePrefix."{$moduleName}_features` (
			  `id` int(11) NOT NULL,
			  `parent` int(11) NOT NULL,
			  `id_lang` int(11) DEFAULT NULL,
			  `name` text NOT NULL,
			  `value` text DEFAULT NULL,
			  `active` int(11) NOT NULL DEFAULT 1,
			  `visible` int(11) NOT NULL DEFAULT 1,
			  `pos` int(11) DEFAULT NULL,
			  `dt_intro` datetime DEFAULT NULL,
			  `dt_lastmod` datetime DEFAULT NULL,
			  `dt_delete` datetime DEFAULT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
			"ALTER TABLE `".self::$modulePrefix."{$moduleName}_features`
			  ADD PRIMARY KEY (`id`)",
			"ALTER TABLE `".self::$modulePrefix."{$moduleName}_features`
			  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT",
		);

		foreach ($tables as $table) {
			\DB::run($table);
		}
	}

	public static function generateModule($data, $id_parent = null) {
		//dd($data);

		$name = \DB::escape_string($_POST['name']);
		$title = \DB::escape_string($_POST['title']);
		$single = \DB::escape_string($_POST['single']);
		$plural = \DB::escape_string($_POST['plural']);

		$sql = "INSERT INTO sys_modules SET 
					name ='$name',
					dt_intro = '".\Data\Date::currentTimeStamp()."',
					dt_lastmod = '".\Data\Date::currentTimeStamp()."'";

		if (exists($id_parent)) {
			$sql .= ", parent = ". (int) $id_parent;
		}

		if(\DB::run($sql)) {
			$id_module = \DB::last_insert_id();

			$sql_lang = "INSERT INTO sys_modules_lang SET
							parent = $id_module,
							id_lang = 1,
							title = '$title',
							single = '$single',
							plural = '$plural',
							dt_intro = '".\Data\Date::currentTimeStamp()."',
							dt_lastmod = '".\Data\Date::currentTimeStamp()."'";
			\DB::run($sql_lang);
		}

		self::createModuleTables($name, $data);
		self::generateModulePermissions($id_module, null);
		self::generateModuleSettings($id_module, null);
		self::generateModuleTabs($name, $id_module, $data);
	}

	public static function list($id = null) {
		$sql = "SELECT md.*, md_lang.title, md_lang.single, md_lang.plural 
				FROM sys_modules AS md 
					LEFT JOIN sys_modules_lang AS md_lang
						ON md_lang.parent = md.id 
						AND md_lang.dt_delete IS NULL AND md_lang.active = 1 
						AND md_lang.id_lang = 1 
				WHERE md.dt_delete IS NULL AND md.visible = 1";

		if(exists($id)) {
			$sql .= " AND md.parent = $id";
		} else {
			$sql .= " AND md.parent IS NULL";
		}

		$sql .= " ORDER BY -md.pos DESC";
		$rows = \DB::results($sql);

		$modules = array();
		foreach($rows as $row) {
			$modules[$row['id']] = array(
				"id" => $row['id'],
				"name" => $row['name'],
				"title" => $row['title'],
				"items" => array(
					"single" => $row['single'],
					"plural" => $row['plural'],
				),
				"deleted" => $row['dt_delete'] ? 1 : 0,
			);
		}

		return $modules;
	}

	public static function availableTabs() {
		$sql = "SELECT t.*, t_lang.title, t_lang.single, t_lang.plural 
				FROM sys_tabs AS t 
					LEFT JOIN sys_tabs_lang AS t_lang
						ON t_lang.parent = t.id 
						AND t_lang.dt_delete IS NULL AND t_lang.active = 1 
						AND t_lang.id_lang = 1 
				WHERE t.dt_delete IS NULL AND t.visible = 1 
				ORDER BY -t.pos DESC";
		$rows = \DB::results($sql);

		$tabs = array();
		foreach($rows as $row) {
			$tabs[$row['id']] = array(
				"id" => $row['id'],
				"name" => $row['name'],
				"title" => $row['title'],
				"items" => array(
					"single" => $row['single'],
					"plural" => $row['plural'],
				),
				"settings" => self::availableTabSettings($row['id']),
				"permissions" => self::availablePermissionsSettings($row['id']),
				"deleted" => $row['dt_delete'] ? 1 : 0,
			);
		}

		return $tabs;
	}

	public static function availableTabSettings($id_tab = null) {
		$sql = "SELECT s.*, s_lang.title 
				FROM sys_md_settings AS s 
					LEFT JOIN sys_md_settings_lang AS s_lang
						ON s_lang.parent = s.id 
						AND s_lang.dt_delete IS NULL AND s_lang.active = 1 
						AND s_lang.id_lang = 1 
				WHERE s.dt_delete IS NULL AND s.visible = 1";
		
		if(exists($id_tab)) {
			$sql .= " AND s.id_tab = ". (int) $id_tab;
		}	else {
			$sql .= " AND s.id_tab IS NULL";
		}

		$sql .= " ORDER BY -s.pos DESC";
		$rows = \DB::results($sql);

		$settings = array();
		foreach($rows as $row) {
			$settings[$row['id']] = array(
				"id" => $row['id'],
				"name" => $row['name'],
				"title" => $row['title'],
				"deleted" => $row['dt_delete'] ? 1 : 0,
			);
		}

		return $settings;
	}

	public static function availablePermissionsSettings($id_tab = null) {
		$sql = "SELECT p.*, p_lang.title 
				FROM sys_permissions AS p 
					LEFT JOIN sys_permissions_lang AS p_lang
						ON p_lang.parent = p.id 
						AND p_lang.dt_delete IS NULL AND p_lang.active = 1 
						AND p_lang.id_lang = 1 
				WHERE p.dt_delete IS NULL AND p.visible = 1";
		
		if(exists($id_tab)) {
			$sql .= " AND p.id_tab = ". (int) $id_tab;
		}	else {
			$sql .= " AND p.id_tab IS NULL";
		}

		$sql .= " ORDER BY -p.pos DESC";
		$rows = \DB::results($sql);

		$permissions = array();
		foreach($rows as $row) {
			$permissions[$row['id']] = array(
				"id" => $row['id'],
				"name" => $row['name'],
				"title" => $row['title'],
				"deleted" => $row['dt_delete'] ? 1 : 0,
			);
		}

		return $permissions;
	}

	public static function moduleInfo(int $id) {
		$module = array();

		$sql = "SELECT md.*, md_lang.title
				FROM sys_modules as md
				LEFT JOIN sys_modules_lang AS md_lang
					ON md_lang.parent = md.id
					AND md_lang.dt_delete IS NULL AND md_lang.active = 1 
					AND md_lang.id_lang = 1 
				WHERE md.dt_delete IS NULL AND md.visible = 1
					AND md.id = ". (int) $id;

		$module = \DB::results($sql, true); 

		return $module;
	}

}