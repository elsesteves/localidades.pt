<?php

namespace Data;

Class Str {

  public static function permalink_clean($string) {
		$accents_regex = '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i';
		$special_cases = array('&' => 'and');
		$string = mb_strtolower(trim($string), 'UTF-8');
		$string = str_replace(array_keys($special_cases), array_values($special_cases), $string);
		$string = preg_replace($accents_regex, '$1', htmlentities($string, ENT_QUOTES, 'UTF-8'));
		$string = preg_replace("/[^a-z0-9]/u", "-", $string);
		$string = preg_replace("/[-]+/u", "-", $string);
		return $string;
  }

  public static function srcCorrect($txt) {
    $txt = str_replace('="/', '="'.SITE_CONFIGS['info']['baseURL'].'/', $txt);
    return $txt;
  }

  public static function mediaSrcCorrect($txt) {
    $txt = str_replace('="media/', '="'.SITE_CONFIGS['info']['baseURL'].'/media/', $txt);
    return $txt;
  }

  public static function imgExistsCheck($imgSrc) {
    if (empty($imgSrc)) {
      $imgSrc = SITE_CONFIGS['info']['baseURL'].'/assets/images/noimage/noimage_'.\Lang\Lang::fetchCurrentLangRef().'.jpg';
    } else {
      $imgSrc = self::fileSrcCorrect($imgSrc);
    }

    return $imgSrc;
  }

  public static function fileSrcCorrect($fileName) {
    if (strpos($fileName, '/media') === 0 || strpos($fileName, '/assets') ) {
      $fileName = SITE_CONFIGS['info']['baseURL'].$fileName;
    }

    return $fileName;
  }

  public static function replaceMulti($str, $array) {
    foreach ($array as $search => $replace) {
      $str = str_replace($search, $replace, $str);
    }
    return $str;
  }

  public static function isValidUrl($url) {
    $url = parse_url($url);
    if (!isset($url["host"])) return false;
    return !(gethostbyname($url["host"]) == $url["host"]);
  }

  public static function fixUrl($url) {  
    //If $url doesn't exist, it should be a local partial url
    if (self::isValidUrl($url) || empty($url)) {
      return $url;
    } else {
      if(strlen($url) > 1 && substr($url, 0, 1) == '#') {
        return $url;
      }
      return SITE_CONFIGS['info']['baseURL'].$url;
    }
  }

  public static function replaceIfEmpty($initial, $replacement) {
    if (!empty($initial)) {
      return $initial;
    } else {
      return $replacement;
    }
  }

  public static function num2alpha($num) {
    $numeric = $num % 26;
    $letter = chr(65 + $numeric);
    $num2 = intval($num / 26);
    if ($num2 > 0) {
        return self::num2alpha($num2 - 1) . $letter;
    } else {
        return $letter;
    }
  }

  public static function convertModule2ClassName($str) {
    return ucfirst(self::snake2Camel($str));
  }

  public static function snake2Camel($str) {
    return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $str))));
  }

  public function camel2Snake($str) {
    return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $str));
  }

  public static function phoneNumber($str) {
    $str = str_replace(array('(', ')', ' '), array(), $str);
    return $str;
  }

  public static function random_str($length, $keyspace= '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
    $pieces = [];
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i=0; $i < $length; $i++) { 
      $pieces[] = $keyspace[random_int(0, $max)];
    }
    return implode('', $pieces);
  }

}

