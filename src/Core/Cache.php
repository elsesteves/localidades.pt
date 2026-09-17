<?php

class Cache {
	
	protected static $client;

	public static function start() {
		if(self::startRedis()) {		
			//return true;
		} else if(self::startFlatFile()) {		
			//return true;
		} else {
			return false;
		}

		self::checkClear();
		return true;
	}

	protected static function startRedis() {
		try {
			//Try to use Redis
			self::$client = new \Cache\Redis;
			self::$client->start();
		}  catch (\Exception $e) {
			//Redis Unavailable
			self::$client = false;
			return false;
		}
		return true;
	}

	protected static function startFlatFile() {
		try {
			//Try to use FlatFile
			self::$client = new \Cache\FlatFile;
			self::$client->start();
		}  catch (\Exception $e) {
			//FlatFile Unavailable
			self::$client = false;
			return false;
		}
		return true;
	}

	protected static function checkClear() {
		if (exists($_REQUEST['clear-cache'])) {
			self::$client->clear();
		}
	}

	public static function close() {
		if (!self::checkClientExists()) {
			return false;
		}

		self::$client->close();
	}

	protected static function checkClientExists() {
		if (self::$client == false) {
			return false;
		} else {
			return true;
		}
	}

	public static function set($key, $data, $expiresIn = 0) {
		if (!self::checkClientExists()) {
			return false;
		}

		self::$client->set($key, $data, $expiresIn);
	}

	public static function delete($key) {
		if (!self::checkClientExists()) {
			return false;
		}

		self::$client->delete($key);
	}

	public static function exists($key) {
		if (!self::checkClientExists()) {
			return false;
		}

		return self::$client->exists($key);
	}

	public static function get($key) {
		if (!self::checkClientExists()) {
			return false;
		}

		return self::$client->get($key);
	}

}