<?php

namespace Controllers;

Class Blog {

	public static function page($id) {
		$pagesModel = new \Models\Pages();
		$blogModel = new \Models\Blog();
		$blogPage = $blogModel->page($id);

		if (!exists($blogPage)) {
			Error::pageNotFound();
			return false;
		}

		view('blogpage', array(
			"seo" => $blogModel->item_seo($id),
			"blog" => array(
				"page" => $blogPage,
				"images" => $blogModel->images($id),
			),
			"contacts" => array(
			"page" => $pagesModel->item(7),
			),
	    ));
	}

}