<?php

class Cart {

	protected static $cart;
	protected static $cartProds;
	protected static $lang;
	protected static $productsModel;
	protected static $promoCode;

	public static function load() {
		if(session_status() !== PHP_SESSION_ACTIVE) {
	      session_start();
	    }

	    if (exists($_SESSION['shopCart'])) {
	    	self::$cart = $_SESSION['shopCart'];
	    } else {
	    	self::$cart = array();
	    }

	    if (!exists(self::$lang)) {
	    	self::$lang = \Lang\Lang::getLanguage();
	    }

	    if (!exists(self::$productsModel)) {
	    	self::$productsModel = new Models\Products();
	    }
	}

	protected static function save() {
		$_SESSION['shopCart'] = self::$cart;
	}

	public static function add($itemId, $qty = 1) {
		if (exists(self::$cart[$itemId]['qty'])) {
			if (is_int($qty)) {
				self::$cart[$itemId]['qty'] += $qty;
				self::calcSubtotal($itemId);
				self::save();
			}			
		} else {
			self::set($itemId, $qty);
		}
	}

	public static function reduce($itemId, $qty = 1) {
		if (exists(self::$cart[$itemId]['qty'])) {
			if (is_int($qty)) {
				if (self::$cart[$itemId]['qty'] > 0) {
					self::$cart[$itemId]['qty'] -= $qty;
				}				
				self::calcSubtotal($itemId);
				self::save();
			}			
		} else {
			self::set($itemId, $qty);
		}
	}

	public static function remove($itemId) {
		if (exists(self::$cart[$itemId]['qty'])) {
			unset(self::$cart[$itemId]);
			self::calcSubtotal($itemId);
			self::save();
		}
	}

	public static function set($itemId, $qty = 1) {
		if (is_int($qty)) {
			self::$cart[$itemId]['qty'] = $qty;
			self::calcSubtotal($itemId);
			self::save();
		}
	}

	protected static function calcSubtotal($itemId) {
		if (!isset(self::$cart[$itemId]['price']['applicable'])) {
			$itemInfo = self::$productsModel->getVariantProduct($itemId);
			self::$cart[$itemId]['price']['applicable']['value'] = self::itemDiscountCalc($itemInfo, $itemId);
		}
		
		$subtotal = self::$cart[$itemId]['qty'] * self::$cart[$itemId]['price']['applicable']['value'];
		$subtotal = \Data\Number::round_euros($subtotal);
		self::$cart[$itemId]['subtotal'] = $subtotal;
		self::save();

		return $subtotal;
	}

	public static function showInfo() {
		$output = array(
			"products" => self::showProdsInfo(),
			"totals" => self::totals(),
		);

		return $output;
	}

	public static function showProdsInfo() {
		$output = array();

		foreach (self::$cart as $itemId => $product) {
			$itemInfo = self::$productsModel->getVariantProduct($itemId);

			$applicable = self::itemDiscountCalc($itemInfo, $itemId);
			$subtotal = self::calcSubtotal($itemId);

			$qty = $product['qty'];
			$output[$itemId] = $itemInfo;
			$output[$itemId]['qty'] = $qty;
			$output[$itemId]['price']['applicable'] = array(
				"value"	=> $applicable,
				"currency" => \Data\Number::euros($applicable),
			);
			if (!isset(self::$cartProds[$itemId]['promocode'])) {
				$output[$itemId]['promocode'] = false;
			} else {
				$output[$itemId]['promocode'] = self::$cartProds[$itemId]['promocode'];
			}
			$output[$itemId]['subtotal'] = array(
				"value"	=> $subtotal,
				"currency" => \Data\Number::euros($subtotal),
			);
		}

		self::$cartProds = $output;
		return $output;
	}

	protected static function itemDiscountCalc($itemInfo, $itemId) {
		if (isset(self::$cartProds[$itemId]['promocode']) && self::$cartProds[$itemId]['promocode']) {

			$promoCodeDiscount = self::$promoCode['discount'] / 100;

			if (Settings::getSetting('promocode_on_top_of_discount') && $itemInfo['price']['has_discount']) {
				$basePrice = $itemInfo['price']['discounted'];
			} else {
				$basePrice = $itemInfo['price']['value'];
			}
			$price = (1 - $promoCodeDiscount) * $basePrice;
			$price = \Data\Number::round_euros($price);
		} else {
			if ($itemInfo['price']['has_discount']) {
				$price = $itemInfo['price']['discounted'];
			} else {
				$price = $itemInfo['price']['value'];
			}
		}

		return $price;
	}

	public static function applyPromoCode($promoCodeName) {
		$lang = self::$lang;
		$sql = "SELECT promocodes.*, promocodes_lang.title, promocodes_lang.subtitle, promocodes_lang.description, promocodes_lang.cms_page, promocodes_lang.cms_banner, promocodes.cms_banner_ratio, promocodes_lang.cms_banner_mobile, promocodes.cms_banner_mobile_ratio, promocodes_lang.seo_title, promocodes_lang.seo_description, promocodes_lang.active FROM promocodes LEFT JOIN promocodes_lang ON promocodes_lang.parent = promocodes.id AND promocodes_lang.fk_lang = {$lang} WHERE promocodes.deleted = 0 AND promocodes_lang.active = 1 AND promocodes_lang.title = '$promoCodeName'";
		$promoCode = DB::results($sql, true);

		if (empty($promoCode)) {
			return false;
		}

		self::$promoCode = $promoCode;
		$categories = self::promoCodeProdCategories($promoCode['id']);

		$itemsWithPromo = self::prodsInPromoCodeCategories($categories);
		self::applyPromo2Items($itemsWithPromo);

		return self::$promoCode;
	}

	public static function getCurrPromoCode() {
		if (!exists(self::$promoCode)) {
			return array();
		} else {
			$promocode = array(
				"title" => self::$promoCode['title'],
				"dates" => array(
					"start" => self::$promoCode['discount_start'],
					"end" => self::$promoCode['discount_end'],
				),
			);

			return $promocode;
		}
	}

	public static function removePromoCode() {
		self::$promoCode = array();
		foreach (self::$cartProds as $itemId => $item) {
			self::$cartProds[$itemId] = false;
		}
		self::showInfo();
	}

	protected static function applyPromo2Items($itemsWithPromo) {
		if (!exists(self::$cartProds)) {
			Cart::showInfo();
		}

		$promoCodeDiscount = self::$promoCode['discount'] / 100;

		foreach (self::$cartProds as $itemKey => $item) {
			if (in_array($itemKey, $itemsWithPromo)) {
				self::$cartProds[$itemKey]['promocode'] = true;
			
				if(Settings::getSetting('promocode_on_top_of_discount') && self::$cartProds[$itemKey]['price']['has_discount']) {
					$basePrice = self::$cartProds[$itemKey]['price']['discounted'];
				} else {
					$basePrice = self::$cartProds[$itemKey]['price']['value'];
				}

				$newPrice = (1 - $promoCodeDiscount) * $basePrice;
				$newPrice = \Data\Number::round_euros($newPrice);
				self::$cartProds[$itemKey]['price']['applicable'] = $newPrice;
				self::$cartProds[$itemKey]['price']['applicable_currency'] = \Data\Number::euros($newPrice);

			} else {
				self::$cartProds[$itemKey]['promocode'] = false;
			}
		}
	}

	protected static function promoCodeProdCategories($promoCodeId) {
		$lang = self::$lang;
		$sql = "SELECT products_categories.*, products_categories_lang.title, products_categories_lang.active, products_categories_lang.url, products_categories_images.image_full, products_categories_images.image_resize, products_categories_images.image_thumb, promocodes_products_categories_assoc.parent as is_assoc FROM products_categories LEFT JOIN products_categories_lang ON products_categories_lang.parent = products_categories.id AND products_categories_lang.fk_lang = $lang LEFT JOIN products_categories_images ON products_categories_images.parent = products_categories.id AND products_categories_images.main = 1 AND ((products_categories_images.fk_lang = 1 AND products_categories.images_bylang = 1) OR products_categories.images_bylang = 0) LEFT JOIN promocodes_products_categories_assoc ON promocodes_products_categories_assoc.category = products_categories.id AND promocodes_products_categories_assoc.parent = $promoCodeId WHERE products_categories.deleted = 0 AND products_categories.parent != 0 AND promocodes_products_categories_assoc.parent IS NOT NULL ORDER BY -products_categories.pos DESC";
		$prodCategories = DB::results($sql);

		$output = array();
		foreach ($prodCategories as $key => $category) {
			$output[$category['id']] = self::$productsModel->categorySummary($category);
		}

		return $output;
	}

	protected static function prodsInPromoCodeCategories($categories) {

		if (!exists(self::$cartProds)) {
			Cart::showInfo();
		}

		$output = array();
		if (!empty($categories)) {
			foreach (self::$cartProds as $itemKey => $product) {
				$isInPromoCats = self::$productsModel->isProductInCategories($product['id'], $categories);
				if ($isInPromoCats) {
					array_push($output, $itemKey);
				}
			}
		}

		return $output;
	}

	public static function totals() {

		if (!exists(self::$cartProds)) {
			Cart::showProdsInfo();
		}

		$totals = array(
			"total"	=> 0,
			"total_vat"	=> 0,
			"total_novat" => 0,
		);

		foreach (self::$cartProds as $itemKey => $product) {
			$subtotal = $product['qty'] * $product['price']['applicable']['value'];

			$totals['total'] += $subtotal;
			if (Settings::getSetting('vat_included')) {
				$totals['total_vat'] += $subtotal * ($product['vat']['multiplier'] / (1 + $product['vat']['multiplier']));
				$totals["total_novat"] += $subtotal * (1 / (1 + $product['vat']['multiplier']));
			} else {
				$totals['total_vat'] += $subtotal * $product['vat']['multiplier'];
				$totals['total_novat'] += $subtotal;
			}
		}

		$output = array(
			"total"	=> \Data\Number::euros($totals['total']),
			"total_vat"	=> \Data\Number::euros($totals['total_vat']),
			"total_novat" => \Data\Number::euros($totals['total_novat']),
		);

		return $output;

	}

}