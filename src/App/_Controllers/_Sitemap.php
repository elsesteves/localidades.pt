<?php

namespace Controllers;

Class Sitemap {

	public static function show() {
		$links = \Models\Sitemap::getLinks();

		view('sitemap/sitemap', array(
			"links" => $links,
		), true);
	}

}