<?php

namespace Cache;

class Redis {

	protected $client;

	public function start() {
		try {
			$redisClient = new \Redis();
			$redisClient->connect('localhost', 6379);

			$this->client = $redisClient;
			return true;
		}  catch (\Exception $e) {
			$this->client = false;
			throw new \Exception("Redis connection could not be established! $e");
			return false;
		}catch (\Throwable $e) {
			$this->client = false;
			throw new \Exception("Redis connection could not be established! $e");
			return false;
		}
	}

	public function close() {
		if (!$this->checkConn()) {
			return false;
		}

		$this->client->close();
	}

	protected function checkConn() {
		if (!exists($this->client)) {
			//throw new \Exception("No Redis connection established!");
			return false;
		} else {
			//return $this->client;
			return true;
		}		
	}

	public function clear() {
		if (!$this->checkConn()) {
			return false;
		}

		$this->client->flushAll();
	}

	public function set($key, $data, $expiresIn = 0) {
		if (!$this->checkConn()) {
			return false;
		}

		$json = json_encode($data);

		if ($expiresIn != 0 && is_numeric($expiresIn)) {	
			$this->client->setex($key, $expiresIn, $json);
		} else {
			$this->client->set($key, $json);
		}	
	}

	public function delete($key) {
		if (!$this->checkConn()) {
			return false;
		}

		$this->client->del($key);
	}

	public function exists($key) {
		if (!$this->checkConn()) {
			return false;
		}

		return $this->client->exists($key);
	}

	public function get($key) {
		if (!$this->checkConn()) {
			return false;
		}

		if(!is_array($key)) {
			$json = $this->client->get($key);
			$data = json_decode($json, true);
		} else {
			//Multiple keys in $key array
			$data = $this->client->mget($key);
		}

		return $data;
	}
}