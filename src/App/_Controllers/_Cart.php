<?php

namespace Controllers;

Class Cart {

  public static function showCartPage() {
    \Cart::load();
    
    view('cart', array(
      "cart"  => \Cart::showInfo(),
      "promocode" => \Cart::getCurrPromoCode(),
    ));
  }
  
  public static function apiAdd($itemId, $qty = 1) {
  	\Cart::load();
  	\Cart::add($itemId, $qty);
  	$items = \Cart::showInfo();
  	json_return($items);
  }

  public static function addPromocode() {
    $promoCodeName = \DB::escape_string($_POST['promocode']);

    \Cart::load();
    $promoCode = \Cart::applyPromoCode($promoCodeName);

    self::showCartPage();
  }


  
}