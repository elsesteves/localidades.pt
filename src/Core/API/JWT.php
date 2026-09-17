<?php

namespace API;

Class JWT {

	public static function getAuthorizationHeader() {
		$headers = null;
		if(isset($_SERVER['Authorization'])) {
			$headers = trim($_SERVER['Authorization']);
		}
		return $headers;
	}

	public static function getBearerToken() {
		$headers = self::getAuthorizationHeader();

		if(!empty($headers)) {
			if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
				return $matches[1];
			}
		}
	}

}