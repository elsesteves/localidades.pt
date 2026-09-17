<?php

namespace Cache;

class FlatFile {
	//This class is an alternative to Redis
	//Will store and retrieve the data to/from a json file

	protected $fileName = '/src/cache.json';
	protected $filePath = '';
	protected $data = array();
	protected $hasChanged = false;

	public function __construct($fileName = null) {
        if (exists($fileName)) {
        	$this->fileName = $fileName;
        }
        $this->filePath = __PROJECT_ROOT__ . $this->fileName;
    }

	public function start() {
		$error = '';
		if(!$this->read($error)) {
			throw new \Exception("Could not read from FlatFile! $error");
			return false;
		}
		return true;
	}

	public function close() {
		if ($this->hasChanged) {

			$error = '';
			if(!$this->write($error)) {
				throw new \Exception("Could not write to FlatFile! $error");
				return false;
			}
		}
		
		return true;
	}

	public function read(&$error = '') {
		try {
			$json = file_get_contents($this->filePath);
			$data = json_decode($json, true);
			
			if(exists($data['data'])) {
				$this->data = $data['data'];
			}

			return true;
		} catch(\Exception $e) {
			return false;
		}
	}

	public function write(&$error = '') {
		try {
			$data = array(
				"metadata" => $this->generateMetadata(),
				"data" => $this->data,
			);
			$json = json_encode($data);
			file_put_contents($this->filePath, $json);

			return true;
		} catch(\Exception $e) {
			return false;
		}
	}

	public function generateMetadata() {
		$metadata = array(
			"flatfile" => array(
				"version" => "v1.0",
			),
			"lastchange" => date("YmdHis"),
		);

		return $metadata;
	}

	public function clear() {
		$this->data = array();
		$this->hasChanged = true;
	}

	public function set($key, $data, $expiresIn = 0) {
		/*
			* $expiresIn is expressed in seconds
			* if null, then it does not expire
		*/

		if ($expiresIn != 0 && is_numeric($expiresIn)) {
			$expirationTime = date("YmdHis", strtotime("+$expiresIn sec"));

			$this->data[$key] = array(
				"key" => $key,
				"value" => $data,
				"expires_at" => $expirationTime,
			);

		} else {
			$this->data[$key] = array(
				"key" => $key,
				"value" => $data,
				"expires_at" => null,
			);
		}

		$this->hasChanged = true;
	}

	public function delete($key) {
		unset($this->data[$key]);

		$this->hasChanged = true;
	}

	public function exists($key) {
		if (!exists($this->data[$key])) {
			return false;
		}

		if ($this->data[$key]['expires_at'] < date("YmdHis") && !empty($this->data[$key]['expires_at'])) {
			//Remove this data from the file, since it has already expired
			$this->delete($key);
			return false;
		}

		return true;
	}

	public function get($key) {
		if(!is_array($key)) {
			$data = $this->data[$key]['value'];
		} else {
			//Multiple keys in $key array
			$data = array();
			foreach($key as $singleKey) {
				$data[$key] = $this->data[$key]['value'];
			}
		}

		return $data;
	}

}