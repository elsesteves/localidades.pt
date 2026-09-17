<?php

namespace DB;

class MySQLi {

  protected $conn;

  public function connect($configs) {
    $this->conn = mysqli_connect($configs['host'], $configs['user'], $configs['password'], $configs['database']);
    mysqli_set_charset($this->conn, "utf8");
  }

  public function run($sql) {
    $query = mysqli_query($this->conn, $sql);
    return $query;
  }

  public function last_insert_id() {
    return $this->conn->insert_id;
  }

  public function results($sql, $single=false) {
    $query = $this->run($sql);

    if ($single) {
      $queryRes = mysqli_fetch_assoc($query);
    } else {
      $queryRes = mysqli_fetch_all($query, MYSQLI_ASSOC);
    }

    mysqli_free_result($query);

    return $queryRes;
  }

  public function count($sql) {
    $query = $this->run($sql);
    $count = mysqli_num_rows($query);
    mysqli_free_result($query);

    return $count;
  }
  
  public function escape_string($str) { 
    $str = trim($str," \n\r\t\v\x00");
    $str = mysqli_real_escape_string(self::$conn, $str);    
    return $str;
  }

}
