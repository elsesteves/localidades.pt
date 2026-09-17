<?php

namespace Data;

Class Date {

  protected static $monthsShort = array();
  protected static $monthsLong = array();

  protected static function checkMonths() {
    if (empty(self::$monthsLong) || empty(self::$monthsShort)) {
      return false;
    }
    return true;
  }

  protected static function generateMonths() {
    self::$monthsShort = array();
    self::$monthsLong = array();

    for ($i = 1; $i <= 12; $i++) {
      $index = $i;
      if ($i < 10) {
        $index = '0'.$index;
      }      

      array_push(self::$monthsShort, \Lang\Dictionary::get('month'.$index.'_short'));
      array_push(self::$monthsLong, \Lang\Dictionary::get('month'.$index.'_long'));
    }
  }

  protected static function format($hour, $seconds, $numerical) {
    if ($hour) {
      if ($seconds) {
        $dt_format = 'Y H:i:s';
      } else {
        $dt_format = 'Y H:i';
      }      
    } else {
      $dt_format = 'Y';
    }

    if($numerical) {
      $dt_format = 'd/m/'.$dt_format;
    }

    return $dt_format;
  }

  public static function short($date, $hour = true, $seconds = false, $numerical = false) {
    if ($numerical) {
      $dt_format = self::format($hour, $seconds, $numerical);
      $output = date($dt_format, strtotime($date));
    } else {
      if (!self::checkMonths()) {
        self::generateMonths();
      }

      $dt_format = self::format($hour, $seconds, $numerical);
      $monthIndex = intval(date("m", strtotime($date))) - 1;
      $month = self::$monthsShort[$monthIndex];

      $output = date("d", strtotime($date)) . ' ' . $month. ' ' . date($dt_format, strtotime($date));
    }
    
    return $output;
  }

  public static function long($date, $hour = true, $seconds = false) {
    if (!self::checkMonths()) {
      self::generateMonths();
    }

    $dt_format = self::format($hour, $seconds, false);
    $monthIndex = intval(date("m", strtotime($date))) - 1;

    $month = self::$monthsLong[$monthIndex];

    return date("d", strtotime($date)) . ' ' . $month. ' ' . date($dt_format, strtotime($date));
  }
  
  public static function todayinBetween($startDate, $endDate) {
    $now = new DateTime();
    return self::inBetween($now, $startDate, $endDate);
  }
  
  public static function inBetween($currDate, $startDate, $endDate) {
    $startDate = new DateTime($startDate);
    $endDate = new DateTime($endDate);
    $endDate->modify('+1 day');
    
    if($currDate >= $startDate && $currDate < $endDate) {
      return true;
		} else {
      return false;
		}
    
  }

  public static function currentTimeStamp() {
    return date("Y-m-d H:i:s");
  }

}
