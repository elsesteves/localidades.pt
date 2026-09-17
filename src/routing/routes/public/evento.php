<?php

Router::route("GET", '[/{lang}]/evento/{id_item}/{item_name}', function($id_item) {
	\Controllers\Evento::itemInfoPage($id_item);
});

Router::route("GET", '[/{lang}]/event/{id_item}/{item_name}', function($id_item) {
	\Controllers\Evento::itemInfoPage($id_item);
});

Router::route("GET", '[/{lang}]/eventos', function() {
	\Controllers\Evento::mainPage();
});

Router::route("GET", '[/{lang}]/events', function() {
	\Controllers\Evento::mainPage();
});

Router::route("GET", '[/{lang}]/eventos/pesquisa', function() {
	\Controllers\Evento::searchResultsPage();
});

Router::route("GET", '[/{lang}]/events/search', function() {
	\Controllers\Evento::searchResultsPage();
});