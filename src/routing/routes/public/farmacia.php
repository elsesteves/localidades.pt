<?php

Router::route("GET", '[/{lang}]/farmacia/{id_item}/{item_name}', function($id_item) {
	\Controllers\Farmacia::itemInfoPage($id_item);
});

Router::route("GET", '[/{lang}]/pharmacy/{id_item}/{item_name}', function($id_item) {
	\Controllers\Farmacia::itemInfoPage($id_item);
});

Router::route("GET", '[/{lang}]/farmacias', function() {
	\Controllers\Farmacia::mainPage();
});

Router::route("GET", '[/{lang}]/pharmacies', function() {
	\Controllers\Farmacia::mainPage();
});

Router::route("GET", '[/{lang}]/farmacias/pesquisa', function() {
	\Controllers\Farmacia::searchResultsPage();
});

Router::route("GET", '[/{lang}]/pharmacies/search', function() {
	\Controllers\Farmacia::searchResultsPage();
});