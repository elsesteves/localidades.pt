<?php

//This serves to hide te website in the development phase, if required
if (!SITE_CONFIGS['access']['open']) {
	$cookie_name = SITE_CONFIGS['access']['access_token']['cookie_name'];
	$token_name = SITE_CONFIGS['access']['access_token']['token_name'];
	$valid_values = SITE_CONFIGS['access']['access_token']['valid_values'];
	$failure_page = SITE_CONFIGS['access']['failure_page'];

	if (!isset($_COOKIE[$cookie_name])) {
		if (isset($_GET[$token_name]) && in_array($_GET[$token_name], $valid_values)) {
     		setcookie($cookie_name, 1, time() + (86400 * 1), "/");
		} else {
			if (!empty($failure_page)) {
				require_once SITE_ROOT .$failure_page;		      
	      	}
	      	die();
	    }
	} else {
		if ($_COOKIE[$cookie_name] == 0) {
	      	if (!empty($failure_page)) {
				require_once SITE_ROOT .$failure_page;		      
	      	}
	      	die();
	    }
	}
}