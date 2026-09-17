<?php

class Settings {

	protected static $values = array();
	protected static $module_setting = array();

	protected static function fetchModuleSetting($moduleName) {
		$moduleName = DB::escape_string($moduleName);

		$sql = "SELECT ms.name, ms2m.value
					FROM sys_md_settings AS ms
					INNER JOIN sys_md_settings2modules AS ms2m
						ON ms2m.id_md_setting = ms.id_md_setting
					INNER JOIN sys_modules AS m
						ON ms2m.id_module = m.id_module
					WHERE m.dt_delete IS NULL AND m.visible = 1
						AND ms2m.dt_delete IS NULL AND ms2m.visible = 1
						AND ms.dt_delete IS NULL AND ms.visible = 1
						AND m.name ='$moduleName'";

		$moduleSettings = DB::results("$sql", true);

		foreach($moduleSettings as $moduleSetting) {
			self::$module_setting[$moduleName][$moduleSetting['name']] = $moduleSetting['value'];
		}		
	}

	public static function getModuleSetting($moduleName, $settingName) {
		$moduleName = DB::escape_string($moduleName);
		$settingName = DB::escape_string($settingName);

		if (!isset(self::$module_setting[$moduleName][$settingName])) {
			self::fetchmoduleSetting($moduleName);
		}
		if (isset(self::$module_setting[$moduleName][$settingName])) {
			return self::$module_setting[$moduleName][$settingName];
		} else {
			return null;
		}
	}

	protected static function fetchSetting($settingName) {
		$settingName = DB::escape_string($settingName);
		$setting = DB::results("SELECT * FROM sys_settings WHERE name='$settingName'", true);
		if (!empty($setting)) {
			self::$values[$settingName] = $setting['value'];
		} else {
			self::$values[$settingName] = '';
		}
	}

	public static function getSetting($settingName) {
		if (!isset(self::$values[$settingName])) {
			self::fetchSetting($settingName);
		}
		return self::$values[$settingName];
	}


}