<?php

namespace Models;

Class Products extends \Module {

	public function __construct()
	{
		parent::__construct('products');
	}

	public function brand($brandId) {
		$sql = "SELECT products_brands.*, products_brands_lang.title, products_brands_lang.subtitle, products_brands_lang.description, products_brands_images.image_full, products_brands_images.image_resize, products_brands_images.image_thumb FROM products_brands LEFT JOIN products_brands_lang ON products_brands_lang.parent = products_brands.id AND products_brands_lang.fk_lang = {$this->lang} LEFT JOIN products_brands_images ON products_brands_images.parent = products_brands.id AND products_brands_images.main = 1 AND ((products_brands_images.fk_lang = {$this->lang} AND products_brands.images_bylang = 1) OR products_brands.images_bylang = 0) WHERE products_brands.deleted = 0 AND products_brands_lang.active = 1 AND products_brands.id = $brandId ORDER BY -products_brands.pos DESC";
		$item = \DB::results($sql, true);

		if (!empty($item)) {
			$title = $item['title'] ? $item['title'] : $item['name'];
			$url = '/products/brands/'.$item['id'].'/'.\Data\Str::permalink_clean($title);
			
			$brand = array(
				"id" => $item['id'],
				"title"	=> $title,
				"image_thumb" => $item['image_thumb'] ? '/' . $item['image_thumb'] : '/assets/images/noimage/empty_horizontal_thumb.png',
				"url"	=> $url,
			);
		} else {
			$brand = false;
		}

		return $brand;
	}

	public function brandsList() {
		$sql = "SELECT products_brands.*, products_brands_lang.title, products_brands_lang.subtitle, products_brands_lang.description, products_brands_images.image_full, products_brands_images.image_resize, products_brands_images.image_thumb FROM products_brands LEFT JOIN products_brands_lang ON products_brands_lang.parent = products_brands.id AND products_brands_lang.fk_lang = {$this->lang} LEFT JOIN products_brands_images ON products_brands_images.parent = products_brands.id AND products_brands_images.main = 1 AND ((products_brands_images.fk_lang = {$this->lang} AND products_brands.images_bylang = 1) OR products_brands.images_bylang = 0) WHERE products_brands.deleted = 0 AND products_brands_lang.active = 1 ORDER BY -products_brands.pos DESC";
		$items = \DB::results($sql);

		$output= array();

		foreach ($items as $item) {
			$output[$item['id']] = $this->brandSummary($item);
		}

		return $output;
	}

	public function brandSummary($brand) {
		$title = $brand['title'] ? $brand['title'] : $brand['name'];
		$url = '/products/brands/'.$brand['id'].'/'.\Data\Str::permalink_clean($title);

		$brand = array(
			"id" => $brand['id'],
			"title"	=> $title,
			"image_thumb" => $brand['image_thumb'] ? '/' . $brand['image_thumb'] : '/assets/images/noimage/empty_horizontal_thumb.png',
			"url"	=> $url,
		);

		return $brand;
	}

	public function featuredcategories() {
		$sql = "SELECT {$this->baseTable}_categories.*, {$this->baseTable}_categories_lang.title, {$this->baseTable}_categories_lang.url, {$this->baseTable}_categories_lang.active, {$this->baseTable}_categories_images.image_full, {$this->baseTable}_categories_images.image_resize, {$this->baseTable}_categories_images.image_thumb FROM {$this->baseTable}_categories LEFT JOIN {$this->baseTable}_categories_lang ON {$this->baseTable}_categories_lang.parent = {$this->baseTable}_categories.id AND {$this->baseTable}_categories_lang.fk_lang = {$this->lang} LEFT JOIN {$this->baseTable}_categories_images ON {$this->baseTable}_categories_images.parent = {$this->baseTable}_categories.id AND {$this->baseTable}_categories_images.main = 1 AND (({$this->baseTable}_categories_images.fk_lang = {$this->lang} AND {$this->baseTable}_categories.images_bylang = 1) OR {$this->baseTable}_categories.images_bylang = 0) WHERE {$this->baseTable}_categories.deleted = 0 AND {$this->baseTable}_categories_lang.active = 1 AND {$this->baseTable}_categories_lang.main = 1 ORDER BY -{$this->baseTable}_categories.pos DESC";
		$items = \DB::results($sql);

		$categories = array();

		foreach ($items as $category) {
			$categories[$category['id']] = $this->categorySummary($category);
		}

		return $categories;
	}

	public function categorySummary($category) {
		$title = $category['title'] ? $category['title'] : $category['name'];
		$url = $category['url'] ? $category['url'] : '/products/categories/'.$category['id'].'/'.\Data\Str::permalink_clean($title);

		$category = array(
			"id" => $category['id'],
			"title"	=> $title,
			"image_thumb" => $category['image_thumb'] ? '/' . $category['image_thumb'] : '/assets/images/noimage/empty_horizontal_thumb.png',
			"url"	=> $url,
		);

		return $category;
	}

	public function mainCategories() {
		$items = $this->categories(0);
		$categories = array();

		foreach ($items as $category) {
			$title = $category['title'] ? $category['title'] : $category['name'];
			$categories[$category['id']] = array(
				"title"	=> $title,
				"image_thumb" => $category['image_thumb'] ? '/' . $category['image_thumb'] : '/assets/images/noimage/empty_horizontal_thumb.png',
				"url"	=> '/products/categories/'.\Data\Str::permalink_clean($title),
				"products"	=> $this->prodsByCategory($category['id']),
			);
		}

		return $categories;
	}

	public function prodsByCategory($categoryID) {
		$sql = "SELECT {$this->baseTable}.*, {$this->baseTable}_lang.title, {$this->baseTable}_lang.active, {$this->baseTable}_images.image_full, {$this->baseTable}_images.image_resize, {$this->baseTable}_images.image_thumb FROM $this->baseTable LEFT JOIN {$this->baseTable}_lang ON {$this->baseTable}_lang.parent = $this->baseTable.id AND {$this->baseTable}_lang.fk_lang = {$this->lang} LEFT JOIN {$this->baseTable}_images ON {$this->baseTable}_images.parent = $this->baseTable.id AND {$this->baseTable}_images.main = 1 AND (({$this->baseTable}_images.fk_lang = {$this->lang} AND $this->baseTable.images_bylang = 1) OR $this->baseTable.images_bylang = 0) INNER JOIN {$this->baseTable}_categories_assoc ON {$this->baseTable}_categories_assoc.parent = {$this->baseTable}.id WHERE {$this->baseTable}.deleted = 0 AND {$this->baseTable}_lang.active = 1 AND {$this->baseTable}_categories_assoc.category = $categoryID ORDER BY -{$this->baseTable}_categories_assoc.pos DESC";
		$items = \DB::results($sql);
		
		return $this->prodItemsList($items);
	}

	protected function prodItemsList($items) {
		$products = array();

		foreach ($items as $product) {
			$title = $product['title'] ? $product['title'] : $product['name'];
			$products[$product['id']] = array(
				"id"	=> $product['id'],
				"title"	=> $title,
				"sku"	=> $product['sku'],
				"url"	=> '/products/'.$product['id'].'/'.\Data\Str::permalink_clean($title),
				"image_thumb" => $product['image_thumb'] ? '/' . $product['image_thumb'] : '/assets/images/noimage/empty.png',
				"brand" => $product['fk_brand'] ? $this->brand($product['fk_brand']) : false,
				"flags"	=> $this->productCategories($product['id'], 0, array(4)),
				"vat"	=> $this->productVAT($product['fk_vat']),
			);

			$variants = $this->productVariants($product['id']);
			if (count($variants) == 1 && !\Settings::getSetting('products_multi_variant')) {
				$variant = reset($variants);
				$products[$product['id']]['id4cart'] = $variant['id'];
				$products[$product['id']]['sku'] = $variant['sku'];
				$products[$product['id']]['ean'] = $variant['ean'];
				$products[$product['id']]['price'] = array(
					"value"	=> floatval($variant['price']),
					"has_discount" => $this->hasDicount($variant),
					"discounted"	=> floatval($variant['price_low']),
				);
			} else {
				$products[$product['id']]['price'] = array();
			}
		}

		return $products;
	}

	public function categoriesList($parentID) {
		$items = self::categories($parentID);

		$categories = array();
		foreach ($items as $category) {
			$categories[$category['id']] = $this->categorySummary($category);
		}

		return $categories;
	}

	protected function productCategories($productID, $parentID = null, $excludeCats = null) {

		$parentCatFilter = '';
		if (!is_null($parentID) && is_int($parentID)) {
			$parentCatFilter = "AND {$this->baseTable}_categories.parent = ".$parentID;
			if (is_array($excludeCats) && !empty($excludeCats)) {
				$parentCatFilter .= " AND {$this->baseTable}_categories.id NOT IN (".implode(', ', $excludeCats).")";
			}
		}

		$sql = "SELECT {$this->baseTable}_categories.*, {$this->baseTable}_categories_lang.title, {$this->baseTable}_categories_lang.url, {$this->baseTable}_categories_lang.active, {$this->baseTable}_categories_images.image_full, {$this->baseTable}_categories_images.image_resize, {$this->baseTable}_categories_images.image_thumb, products_categories_assoc.parent as is_assoc FROM {$this->baseTable}_categories LEFT JOIN {$this->baseTable}_categories_lang ON {$this->baseTable}_categories_lang.parent = {$this->baseTable}_categories.id AND {$this->baseTable}_categories_lang.fk_lang = {$this->lang} LEFT JOIN {$this->baseTable}_categories_images ON {$this->baseTable}_categories_images.parent = {$this->baseTable}_categories.id AND {$this->baseTable}_categories_images.main = 1 AND (({$this->baseTable}_categories_images.fk_lang = 1 AND {$this->baseTable}_categories.images_bylang = 1) OR {$this->baseTable}_categories.images_bylang = 0) INNER JOIN products_categories_assoc ON products_categories_assoc.category = products_categories.id AND products_categories_assoc.parent = $productID WHERE {$this->baseTable}_categories.deleted = 0 AND {$this->baseTable}_categories_lang.active = 1 $parentCatFilter ORDER BY -{$this->baseTable}_categories.pos DESC";
		$items = \DB::results($sql);

		$categories = array();
		foreach ($items as $category) {
			$categories[$category['id']] = $this->categorySummary($category);
		}

		return $categories;
	}

	protected function productVAT($vatId) {
		$output = array(
			"multiplier" => 0,
			"tax"	=> 0,
			"title"	=> "",
		);

		if (!empty($vatId)) {
			$sql = "SELECT vat.*, vat_lang.title FROM vat LEFT JOIN vat_lang ON vat_lang.parent = vat.id AND vat_lang.fk_lang = {$this->lang} WHERE vat.id = $vatId";
			$vat = \DB::results($sql, true);

			if (!empty($vat)) {
				$title = $vat['title'] ? $vat['title'] : $vat['name'];

				$output = array(
					"multiplier" => $vat['tax'] / 100,
					"tax"	=> floatval($vat['tax']),
					"title"	=> $title,
				);
			}
		}

		return $output;
	}

	protected function productVariants($productID) {
		$sql = "SELECT * FROM product_variants WHERE parent = $productID";
		$variants = \DB::results($sql);

		return $variants;
	}

	protected function hasDicount($variant) {
		if ($variant['price_low_bool']) {
			if (\Date::todayinBetween($variant['price_low_start'], $variant['price_low_end'])) {
				return true;
			}
		}

		return false;
	}

	public function categories($parentID) {
		$sql = "SELECT {$this->baseTable}_categories.*, {$this->baseTable}_categories_lang.title, {$this->baseTable}_categories_lang.url, {$this->baseTable}_categories_images.image_full, {$this->baseTable}_categories_images.image_resize, {$this->baseTable}_categories_images.image_thumb FROM {$this->baseTable}_categories LEFT JOIN {$this->baseTable}_categories_lang ON {$this->baseTable}_categories_lang.parent = {$this->baseTable}_categories.id AND {$this->baseTable}_categories_lang.fk_lang = {$this->lang} LEFT JOIN {$this->baseTable}_categories_images ON {$this->baseTable}_categories_images.parent = {$this->baseTable}_categories.id AND {$this->baseTable}_categories_images.main = 1 AND (({$this->baseTable}_categories_images.fk_lang = {$this->lang} AND {$this->baseTable}_categories.images_bylang = 1) OR {$this->baseTable}_categories.images_bylang = 0) WHERE {$this->baseTable}_categories.deleted = 0 AND {$this->baseTable}_categories_lang.active = 1 AND {$this->baseTable}_categories.parent = $parentID ORDER BY -{$this->baseTable}_categories.pos DESC";
		$categories = \DB::results($sql);
		return $categories;
	}

	public function getVariantProduct($variantId) {
		$sql = "SELECT {$this->baseTable}.*, {$this->baseTable}_lang.title, {$this->baseTable}_lang.active, {$this->baseTable}_images.image_full, {$this->baseTable}_images.image_resize, {$this->baseTable}_images.image_thumb FROM $this->baseTable LEFT JOIN {$this->baseTable}_lang ON {$this->baseTable}_lang.parent = $this->baseTable.id AND {$this->baseTable}_lang.fk_lang = {$this->lang} LEFT JOIN {$this->baseTable}_images ON {$this->baseTable}_images.parent = $this->baseTable.id AND {$this->baseTable}_images.main = 1 AND (({$this->baseTable}_images.fk_lang = {$this->lang} AND $this->baseTable.images_bylang = 1) OR $this->baseTable.images_bylang = 0) INNER JOIN product_variants ON product_variants.parent = {$this->baseTable}.id WHERE {$this->baseTable}.deleted = 0 AND {$this->baseTable}_lang.active = 1 AND product_variants.id = $variantId";
		$items = \DB::results($sql);

		$product = $this->prodItemsList($items);
		$product = reset($product);

		return $product;
	}

	public function isProductInCategories($productID, $categories) {
		$cats = array();
		foreach ($categories as $categoryID => $category) {
			array_push($cats, $categoryID);
		}

		$parentCatFilter = " AND {$this->baseTable}_categories.id IN (".implode(', ', $cats).")";

		$sql = "SELECT {$this->baseTable}_categories.*, {$this->baseTable}_categories_lang.title, {$this->baseTable}_categories_lang.url, {$this->baseTable}_categories_lang.active, {$this->baseTable}_categories_images.image_full, {$this->baseTable}_categories_images.image_resize, {$this->baseTable}_categories_images.image_thumb, products_categories_assoc.parent as is_assoc FROM {$this->baseTable}_categories LEFT JOIN {$this->baseTable}_categories_lang ON {$this->baseTable}_categories_lang.parent = {$this->baseTable}_categories.id AND {$this->baseTable}_categories_lang.fk_lang = {$this->lang} LEFT JOIN {$this->baseTable}_categories_images ON {$this->baseTable}_categories_images.parent = {$this->baseTable}_categories.id AND {$this->baseTable}_categories_images.main = 1 AND (({$this->baseTable}_categories_images.fk_lang = 1 AND {$this->baseTable}_categories.images_bylang = 1) OR {$this->baseTable}_categories.images_bylang = 0) INNER JOIN products_categories_assoc ON products_categories_assoc.category = products_categories.id AND products_categories_assoc.parent = $productID WHERE {$this->baseTable}_categories.deleted = 0 AND {$this->baseTable}_categories_lang.active = 1 $parentCatFilter ORDER BY -{$this->baseTable}_categories.pos DESC";
		$items = \DB::results($sql);

		return !empty($items);
	}

}