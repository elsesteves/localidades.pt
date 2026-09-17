<?php

Router::route("GET", '[/{lang}]/praia/{id_item}/{item_name}', function($id_item) {
	\Controllers\Praia::itemInfoPage($id_item);
});

Router::route("GET", '[/{lang}]/beach/{id_item}/{item_name}', function($id_item) {
	\Controllers\Praia::itemInfoPage($id_item);
});

Router::route("GET", '[/{lang}]/praias', function() {
	\Controllers\Praia::mainPage();
});

Router::route("GET", '[/{lang}]/beaches', function() {
	\Controllers\Praia::mainPage();
});

Router::route("GET", '[/{lang}]/praias/pesquisa', function() {
	\Controllers\Praia::searchResultsPage();
});

Router::route("GET", '[/{lang}]/beaches/search', function() {
	\Controllers\Praia::searchResultsPage();
});