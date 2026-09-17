<?php

namespace Controllers\Admin;

Class Site {

	protected static $module = 'site';

	public static function dataTab($id = null) {

		$siteModel = new \Models\Admin\Site();
		$siteInfo = $siteModel->item();

		if (\User\Admin::isActionAllowed(self::$module, 'edit', 'data_show', $siteInfo['id'])) {
			$file = array(
				"folder" => self::$module,
				"file" => 'edit',
				"tab" => 'data',
			);

			$data = array(
				"tabs" => \Models\Admin\Menu::editPageTabs(self::$module),
				"info" => $siteInfo,
				"base_table" => self::$module,
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