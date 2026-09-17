<?php

class DB {

  protected static $conn;
  private static $useDB = true;

  public static function connect() {
    if (!exists(SITE_CONFIGS['database'])) {
      self::$useDB = false;
      return;
    }

    $db = SITE_CONFIGS['database'];
    self::$conn = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);
    mysqli_set_charset(self::$conn, "utf8");
  }

  public static function run($sql) {
    if (!self::$useDB) {
      return;
    }

    $query = mysqli_query(self::$conn, $sql);
    return $query;
  }

  public static function last_insert_id() {
    if (!self::$useDB) {
      return;
    }

    return self::$conn->insert_id;
  }

  public static function results($sql, $single=false, $cache = null) {
    /*
      * $cache format array("use_cache":bool, "expires_in":int, "key":string)
    */

    if (!self::$useDB) {
      return;
    }

    $useCache = false;
    $cacheKey = "queryRes:".$sql;
    $cacheExpiresIn = 0;

    if (exists($cache['use_cache'])) {
      $useCache = (bool) $cache['use_cache'];
    }

    if (exists($cache['key'])) {
      $cacheKey = (string) $cache['key'];
    }

    if (exists($cache['expires_in'])) {
      $cacheExpiresIn = (int) $cache['expires_in'];
    }
    
    if($useCache && \Cache::exists($cacheKey)) {

      $queryRes = \Cache::get($cacheKey);
    } else {
    
      $query = self::run($sql);
      if ($single) {
        $queryRes = mysqli_fetch_assoc($query);
      } else {
        $queryRes = mysqli_fetch_all($query, MYSQLI_ASSOC);
      }
      mysqli_free_result($query);
      
      if($useCache) {
        \Cache::set($cacheKey, $queryRes, $cacheExpiresIn);
      }
    }    
    
    return $queryRes;
  }

  public static function count($sql) {
    if (!self::$useDB) {
      return;
    }

    $query = self::run($sql);
    $count = mysqli_num_rows($query);
    mysqli_free_result($query);

    return $count;
  }

  public static function table_exists($table) {
    if (!self::$useDB) {
      return;
    }

    return self::run("DESCRIBE {$table}");
  }
  
  public static function escape_string($str) { 
    $str = trim($str," \n\r\t\v\x00");

    if (self::$useDB) {
      $str = mysqli_real_escape_string(self::$conn, $str); 
    }
       
    return $str;
  }

}
