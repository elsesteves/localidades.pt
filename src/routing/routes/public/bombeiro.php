<?php

Router::route("GET", '[/{lang}]/bombeiros/{id_item}/{item_name}', function($id_item) {
	\Controllers\Bombeiro::itemInfoPage($id_item);
});

Router::route("GET", '[/{lang}]/firefighters/{id_item}/{item_name}', function($id_item) {
	\Controllers\Bombeiro::itemInfoPage($id_item);
});

Router::route("GET", '[/{lang}]/bombeiros', function() {
	\Controllers\Bombeiro::mainPage();
});

Router::route("GET", '[/{lang}]/firefighters', function() {
	\Controllers\Bombeiro::mainPage();
});

Router::route("GET", '[/{lang}]/bombeiros/pesquisa', function() {
	\Controllers\Bombeiro::searchResultsPage();
});

Router::route("GET", '[/{lang}]/firefighters/search', function() {
	\Controllers\Bombeiro::searchResultsPage();
});