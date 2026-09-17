<?php

Router::route("GET", '[/{lang}]/ponto-turistico/{id_item}/{item_name}', function($id_item) {
	\Controllers\PontoTuristico::itemInfoPage($id_item);
});

Router::route("GET", '[/{lang}]/tourism-point/{id_item}/{item_name}', function($id_item) {
	\Controllers\PontoTuristico::itemInfoPage($id_item);
});

Router::route("GET", '[/{lang}]/pontos-turisticos', function() {
	\Controllers\PontoTuristico::mainPage();
});

Router::route("GET", '[/{lang}]/tourism-points', function() {
	\Controllers\PontoTuristico::mainPage();
});

Router::route("GET", '[/{lang}]/pontos-turisticos/pesquisa', function() {
	\Controllers\PontoTuristico::searchResultsPage();
});

Router::route("GET", '[/{lang}]/tourism-points/search', function() {
	\Controllers\PontoTuristico::searchResultsPage();
});