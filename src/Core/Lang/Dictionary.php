<?php

namespace Lang;

Class Dictionary {

	protected static $dictionary = array();

	public static function getReplaced($name, $options=array(), $lang=null) {
		$str = self::get($name, $lang);


		if (!empty($options)) {
			foreach($options as $optionKey => $optionValue) {
				$str = str_replace("#".$optionKey."#", $optionValue, $str);
			}
		}

		return $str;
	}

	public static function get($name, $lang=null) {

		if (is_null($lang)) {
			$langId = Lang::getLanguage();
		} else {
			$langId = Lang::fetchLanguage($lang);
		}

		if (!isset(self::$dictionary[$name][$langId])) {
			$result = self::fetch($name, $langId);

			if(empty($result)) {
				$result = $name;
			}

			self::$dictionary[$name][$langId] = $result;
		} else {
			$result = self::$dictionary[$name][$langId];
		}

		return $result;
	}

	protected static function fetch($name, $langId) {
		$sql = "SELECT dl.title
					FROM sys_dictionary_lang AS dl
					INNER JOIN sys_dictionary AS d 
						ON dl.parent = d.id
					WHERE d.name = '$name'
						AND dl.id_lang = $langId
						AND d.active = 1 AND d.visible = 1 AND d.dt_delete IS NULL
						AND dl.active = 1 AND dl.visible = 1 AND dl.dt_delete IS NULL";

		$result = \DB::results($sql, true);

		if (!empty($result)) {
			return $result['title'];
		} else {
			return false;
		}
	}

}