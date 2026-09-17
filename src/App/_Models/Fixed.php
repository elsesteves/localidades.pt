<?php

namespace Models;

Class Fixed {

	public function headerMenu() {

		$productsModel = new Products();
		$productCats = array_merge($productsModel->categoriesList(0), $productsModel->categoriesList(1));

		$output = array(
			array(
				"name" => \Lang\Dictionary::get('home'),
				"url"	=> \Data\Str::fixUrl("/"),
				"submenu"	=> array(),
			),
			array(
				"name" => \Lang\Dictionary::get('products'),
				"url"	=> \Data\Str::fixUrl("/products"),
				"submenu"	=> $productCats,
			),
			array(
				"name" => \Lang\Dictionary::get('about us'),
				"url"	=> \Data\Str::fixUrl("/about-us"),
				"submenu"	=> array(),
			),
			array(
				"name" => \Lang\Dictionary::get('contact us'),
				"url"	=> \Data\Str::fixUrl("/contacts"),
				"submenu"	=> array(),
			),
		);

		return $output;
	}

	public function footer() {
		$pagesModel = new Pages();
		$locationsModel = new Locations();

		$infoPages = $pagesModel->category(2);
		$mainLocation = $locationsModel->main();

		array_push($infoPages['pages'], array(
			"title" => \Lang\Dictionary::get('complaints_book'),
			"url" => 'https://www.livroreclamacoes.pt/inicio'
		));

		$output = array(
			"main_pages" => array(
				"name" => SITE_CONFIGS['info']['name'],
				"pages" => $pagesModel->mainPages(),
			),
			"user_pages" => array(
				"name"	=> \Lang\Dictionary::get('customer_area'),
				"pages" => array(
					array(
						"title" => \Lang\Dictionary::get('purchase_history'),
						"url" => \Data\Str::fixUrl('/customer/purchases')
					),
					array(
						"title" => \Lang\Dictionary::get('account_data'),
						"url" => \Data\Str::fixUrl('/customer/account')
					),
					array(
						"title" => \Lang\Dictionary::get('shipping_data'),
						"url" => \Data\Str::fixUrl('/customer/shipping')
					),
					array(
						"title" => \Lang\Dictionary::get('invoicing_data'),
						"url" => \Data\Str::fixUrl('/customer/invoicing')
					),
				),
			),
			"info_pages" => array(
				"name"	=> $infoPages['title'],
				"pages"	=> $infoPages['pages'],
			),
			"location" => array(
				"name" => \Lang\Dictionary::get('contact us'),
				"address" => $mainLocation ? $mainLocation['address'] : '',
				"phones" => $mainLocation ? $mainLocation['phones'] : '',
				"emails" => $mainLocation ? $mainLocation['emails'] : '',
				"social" => $mainLocation ? $mainLocation['social'] : '',
			),
		);

		return $output;
	}
}