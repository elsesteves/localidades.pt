<?php

namespace Controllers;

Class Error {

	public static function pageNotFound() {
		dd('Page Not Found');	
	}

	public static function apiMethodNotFound() {
		dd('API Method Not Found');	
	}
}