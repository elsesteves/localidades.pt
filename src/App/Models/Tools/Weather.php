<?php 

namespace Models\Tools;

Class Weather {
  
  public static function getData($lat, $lon, $days = 5, $lang = 'en', $ignoreTodayInListing = true) {
    if (!exists($lat) || !exists($lon)) {
      return null;
    }

    $apiKey = SITE_CONFIGS['api']['weatherapi.com']['key'];
    $coord = $lat.','.$lon;
    
    $weatherAPIAddress = 'http://api.weatherapi.com/v1/forecast.json?key='.$apiKey.'&q='.$coord.'&days='.$days.'&lang='.$lang;
    $weatherRequest = file_get_contents($weatherAPIAddress);
    $weatherRequest = json_decode($weatherRequest, true);

    if (!exists($weatherRequest)) {
      return null;
    }

    $response = array(
      'location' => array(
        'name'  => $weatherRequest['location']['name'],
        'region'  => $weatherRequest['location']['region'],
      ),
      'current' => array(
        'temperature' => array(
          'current' => $weatherRequest['current']['temp_c'],
        ),
        'condition' => $weatherRequest['current']['condition'],
        'temp' => $weatherRequest['current']['temp_c'],
        'cond_txt' => $weatherRequest['current']['condition']['text'],
        'humidity'  => $weatherRequest['current']['humidity'],
        'wind' => $weatherRequest['current']['wind_kph'],
      ),
    );  

    $response['forecast'] = array();
    foreach($weatherRequest['forecast']['forecastday'] as $forecastday) {
      $weekdayIndex = date("w", strtotime($forecastday['date'])); //0 Sunday - 6 Saturday

      $forecast = array(
        "date" => $forecastday['date'],
        "weekdays" => array(
          "index" => $weekdayIndex,
          "name" => $forecastday['date']  == date('Y-m-d') ? \Lang\Dictionary::get('today') : \Lang\Dictionary::get("weekday_{$weekdayIndex}"),
        ),
        "temp_c" => array(
          "min" => $forecastday['day']['mintemp_c'],
          "max" => $forecastday['day']['maxtemp_c'],
        ),
        'humidity'  => $forecastday['day']['avghumidity'],
        'condition' => $forecastday['day']['condition'],
      );

      if($forecastday['date'] == date('Y-m-d')) {
        //Forecast for today
        $response['current']['temperature']['min'] = $forecastday['day']['mintemp_c'];
        $response['current']['temperature']['max'] = $forecastday['day']['maxtemp_c'];
      }

      if($forecastday['date'] != date('Y-m-d') || !$ignoreTodayInListing) {
        //Forecast for future days (only include today if $ignoreTodayInListing is set to false)
        $response['forecast'][$forecastday['date']] = $forecast;
      }
    }
    
    return $response;
  }
  
}
