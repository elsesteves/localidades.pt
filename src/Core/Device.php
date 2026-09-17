<?php

class Device {

	public static function isMobile($user_agent = null) {
		if (is_null($user_agent)) {
			$user_agent = $_SERVER["HTTP_USER_AGENT"];
		}

	    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $user_agent);
	}

	public static function getInfo($user_agent = null) {
		if (is_null($user_agent)) {
			$user_agent = $_SERVER["HTTP_USER_AGENT"];
		}

		try {
			$info = get_browser($user_agent, true);
		} catch (Exception $e) {
			$info = array(
				"platform" => '',
				"browser" => ''
			);
		}
		
		$infoArr = array('platform', 'browser');

		foreach($infoArr as $infoKey) {
			if(!exists($info[$infoKey])) {
				$info[$infoKey] = '';
			}
		}		

		return array(
			"mobile"	=> self::isMobile($user_agent),
			"platform"	=> $info['platform'],
			"browser"	=> $info['browser']
		);
	}

}