<?php

namespace Lang;

Class Lang {

	protected static $langId;
	protected static $langURLParameter = 'lang';

	protected static $lang = array(
		"site" => array(
			"url_parameter" => 'lang',
			"id" => null,
			"ref" => null,
		),
		"admin" => array(
			"url_parameter" => 'admin_lang',
			"id" => null,
			"ref" => null,
		), 
	);

	public static function index() {
		dd(self::$lang);
	}

	protected static function getDefaultLang() {
		$sql = "SELECT ref_short 
				FROM sys_languages 
				WHERE active = 1 
					AND visible = 1 
					AND dt_delete IS NULL 
					AND main = 1";
		$lang = \DB::results($sql, true);

		if (!empty($lang)) {
			return $lang['id'];
		} else {
			return '1';
		}
	}

	protected static function getBrowserLang() {
		if (exists($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
			$langs = array();

			$langsLong = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
			foreach($langsLong as $lang) {
				$langShort = substr($lang, 0, 2);
				array_push($langs, $langShort);
			}

			$langs = array_unique($langs);

			foreach($langs as $lang) {
				$lang_id = self::fetchLanguage($lang);
				if ($lang_id !== false) {
					return $lang_id;
				}
			}
		}

		return false;
	}

	public static function checkInURL($key = '') {
		if (empty($key)) {
			$key = 'site';
		}

		if (isset($_REQUEST[self::$lang[$key]['url_parameter']])) {
			if(self::setLanguage($_REQUEST[self::$lang[$key]['url_parameter']], $key)) {
				return true;
			}
			return false;
		}

		self::default($key);
		return true;
	}

	public static function default($key = '') {
		if(empty($key)) {
			$key = 'site';
		}

		if (self::getStoredLanguage($key)) {

		} else {
			$browserLang = self::getBrowserLang();

			if ($browserLang !== false) {
				self::$lang[$key]['id'] = $browserLang;
			} else {
				self::$lang[$key]['id'] = self::getDefaultLang();
			}						
		}

		self::$lang[$key]['ref'] = self::fetchCurrentLangRef($key);
	}

	public static function fetchLanguage($lang, $key = '') {
		if(!empty($key)) {
			self::$lang[$key]['ref'] = $lang;	
		}

		$lang = \DB::escape_string($lang);
		
		$sql = "SELECT * FROM sys_languages WHERE active = 1 
					AND visible = 1 
					AND dt_delete IS NULL 
					AND ref_short = '$lang'";
		$langRes = \DB::results($sql, true);

		if (!empty($langRes)) {		
			return $langRes['id'];
		} else {
			return false;
		}
	}

	public static function fetchCurrentLangRef($key = '') {
		if (empty($key)) {
			$key = 'site';
		}

		$sql = "SELECT ref_short 
					FROM sys_languages 
					WHERE active = 1 
					AND visible = 1 
					AND dt_delete IS NULL 
					AND id = ".self::$lang[$key]['id'];
		$lang = \DB::results($sql, true);

		if (!empty($lang)) {
			self::$lang[$key]['ref'] = $lang['ref_short'];
			return $lang['ref_short'];
		} else {
			return false;
		}
	}

	public static function setLanguage($lang, $key = '') {
		if (empty($key)) {
			$key = 'site';
		}

		$langId = self::fetchLanguage($lang, $key);
		if ($langId != false) {
			self::$lang[$key]['id'] = $langId;
			self::storeLanguage($key);
			return true;
		}
		return false;
	}

	protected static function getStoredLanguage($key = '', &$lang_id = null) {
		if (empty($key)) {
			$key = 'site';
		}

		$lang_id = null;

		switch ($key) {
			case 'site':
				if (exists($_SESSION['lang_id'])) {
					$lang_id = $_SESSION['lang_id'];
				}				
				break;

			case 'admin':
				if (exists($_SESSION['admin']['lang']['id'])) {
					$lang_id = $_SESSION['admin']['lang']['id'];
				}				
				break;
			
			default:
				if (exists($_SESSION['lang_id'])) {
					$lang_id = $_SESSION['lang_id'];
				}				
				break;
		}

		if (!empty($lang_id)) {
			self::$lang[$key]['id'] = $lang_id;
			return true;
		} else {
			return false;
		}
	}

	protected static function storeLanguage($key = '') {
		if (empty($key)) {
			$key = 'site';
		}

		$langId = self::$lang[$key]['id'];

		switch ($key) {
			case 'site':
				$_SESSION['lang_id'] = $langId;
				break;

			case 'admin':
				$_SESSION['admin']['lang']['id'] = $langId;
				break;
			
			default:
				$_SESSION['lang_id'] = $langId;
				break;
		}
	}

	public static function getLanguage($key = '') {
		if (empty($key)) {
			$key = 'site';
		}

		return self::$lang[$key]['id'];
	}

	public static function getList() {
		$sql = "SELECT * 
				FROM sys_languages 
				WHERE active = 1 
				AND visible = 1 
				AND dt_delete IS NULL";
		$langs = \DB::results($sql);

		return $langs;
	}

}