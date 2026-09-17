<?php

namespace Data;

Class Number {
  
  public static function isPositive($num) {
    if (is_numeric($num) && $num > 0) {
      return true;
    } else {
      return false;
    }
  }

  public static function euros($value) {
  	return number_format($value, 2, ',', '.') . '€';
  }

  public static function round_euros($value) {
    return round($value, 2);
  }

  public static function DMStoDec($deg,$min,$sec) {
    // Converting DMS ( Degrees / minutes / seconds ) to decimal format
    return $deg+((($min*60)+($sec))/3600);
  }    

  public static function DectoDMS($dec){
    // Converts decimal format to DMS ( Degrees / minutes / seconds ) 
    $vars = explode(".",$dec);
    $deg = $vars[0];
    $tempma = "0.".$vars[1];

    $tempma = $tempma * 3600;
    $min = floor($tempma / 60);
    $sec = $tempma - ($min*60);

    return array("deg"=>$deg,"min"=>$min,"sec"=>$sec);
  }
}