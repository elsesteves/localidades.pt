<?php

namespace DB;

class PDO {

	protected $conn;

	public function connect($configs) {
		$this->conn = new \PDO("mysql:host={$configs['host']};dbname={$configs['database']}", $configs['user'], $configs['password']);
  	}

  	public function run($sql, $preparedStmt = false) {
		$query = $this->conn->execute($sql);
		return $query;
  	}

  	public function runPrepared($query, $toBind) {
  		$stmt = $this->conn->prepare($query);

  		foreach($toBind as $bind) {
  			if (!exists($bind['type'])) {
  				$type = 'PDO::PARAM_NULL';
  			} else {
  				$type = 'PDO::'.$type;
  			}

  			$stmt->bindParam(':'.$bind['name'], $bind['value'], $type);
  		}

  		return $stmt->execute();
  	}

  	public function results($sql, $single=false) {
	    $results = array();

	    foreach($this->conn->query($sql) as $row) {
	    	$row = array_filter($row, 'is_string', ARRAY_FILTER_USE_KEY);
	    	array_push($results, $row);
	    }

	    return $results;
	}

  	public function escape_string($str) { 
		$str = trim($str," \n\r\t\v\x00");
		return $str;
	}
}