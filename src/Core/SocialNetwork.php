<?php

Class SocialNetwork {

   public static $networks = array(
      "facebook" => array(
         "name"   => "Facebook",
         "icon"   => "facebook-f",
         "share_url" => "//facebook.com/sharer/sharer.php?u=#share_url#",
      ),
      "instagram" => array(
         "name"   => "Instagram",
         "icon"   => "instagram",
      ),
      "youtube" => array(
         "name"   => "YouTube",
         "icon"   => "youtube",
      ),
      "linkedin" => array(
         "name"   => "LinkedIn",
         "icon"   => "linkedin",
         "share_url" => "https://www.linkedin.com/shareArticle?mini=true&url=#share_url#"
      ),
      "google" => array(
         "name"   => "Google",
         "icon"   => "google",
      ),
      "twitter" => array(
         "name"   => "Twitter",
         "icon"   => "twitter",
         "share_url" => "//twitter.com/intent/tweet?text=#share_url#",
      ),
      "pinterest" => array(
         "name"   => "Pinterest",
         "icon"   => "pinterest",
      ),
      "whatsapp"  => array(
         "name"   => "WhatsApp",
         "icon"   => "whatsapp",
         "share_url" => "whatsapp://send?text=#share_url#",
      )
   );

   public static function shareLinks($share_url = null){
      if (is_null($share_url)) {
         $share_url = \Request::fullPath();
      }

      $share_url = urlencode($share_url);
      $output = array();

      foreach (self::$networks as $networkKey => $network) {
         if (isset($network['share_url']) && is_string($network['share_url'])) {
            $output[$networkKey] = str_replace('#share_url#', $share_url, $network['share_url']);
         }
      }

      return $output;
   }

   public static function youtubeID($link){
      parse_str(parse_url($link, PHP_URL_QUERY), $gets);
      return $gets['v'];
   }

   public static function info($link){
      foreach (self::$networks as $networkKey => $network) {
         if (stripos($link, $networkKey) !== false) {
            return $network;
         }
      }
   }

   public static function name($link){
      $info = self::info($link);

      if (!exists($info)) {
         return false;
      }

      return $info['name'];
   }

}
