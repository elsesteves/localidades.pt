<?php

class Visit {

	public static function ip() {		
		$ip = '';

		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		return $ip;
	}

	public static function log() {
		$method = Request::method();
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		$ip = self::ip();
		$path = Request::getPath()['shortPath'];
		$payload = json_encode($_REQUEST);
		$user = \User\User::currentUserInfo();		

		$sql = "INSERT INTO users_logs SET 
			user_agent = '". $user_agent ."',
			ip_address = '". $ip ."',
			path = '". $path ."',
			method = '". $method ."',
			payload = '". $payload ."'";

		//dd($user);
		if (exists($user['account']['id'])) {
			$sql .= ", fk_user = ". (int) $user['account']['id'];
		}

		if (DB::run($sql)) {
			return true;
		}
		return false;
	}

}