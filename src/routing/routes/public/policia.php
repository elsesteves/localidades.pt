<?php

Router::route("GET", '[/{lang}]/policia/{id_item}/{item_name}', function($id_item) {
	\Controllers\Policia::itemInfoPage($id_item);
});

Router::route("GET", '[/{lang}]/police/{id_item}/{item_name}', function($id_item) {
	\Controllers\Policia::itemInfoPage($id_item);
});

Router::route("GET", '[/{lang}]/policia', function() {
	\Controllers\Policia::mainPage();
});

Router::route("GET", '[/{lang}]/police', function() {
	\Controllers\Policia::mainPage();
});

Router::route("GET", '[/{lang}]/policia/pesquisa', function() {
	\Controllers\Policia::searchResultsPage();
});

Router::route("GET", '[/{lang}]/police/search', function() {
	\Controllers\Policia::searchResultsPage();
});