<?php

Router::route("GET", '[/{lang}]/unidade-saude/{id_unit}/{unit_name}', function($id_unit) {
	\Controllers\Saude::unitInfoPage($id_unit);
});

Router::route("GET", '[/{lang}]/health-unit/{id_unit}/{unit_name}', function($id_unit) {
	\Controllers\Saude::unitInfoPage($id_unit);
});

Router::route("GET", '[/{lang}]/agrupamento-saude/{id_agrupamento}/{agrupamento_name}', function($id_agrupamento) {
	\Controllers\Saude::groupingInfoPage($id_agrupamento);
});

Router::route("GET", '[/{lang}]/healthcare-grouping/{id_agrupamento}/{agrupamento_name}', function($id_agrupamento) {
	\Controllers\Saude::groupingInfoPage($id_agrupamento);
});

Router::route("GET", '[/{lang}]/saude', function() {
	\Controllers\Saude::mainPage();
});

Router::route("GET", '[/{lang}]/healthcare', function() {
	\Controllers\Saude::mainPage();
});

Router::route("GET", '[/{lang}]/saude/pesquisa', function() {
	\Controllers\Saude::searchResultsPage();
});

Router::route("GET", '[/{lang}]/healthcare/search', function() {
	\Controllers\Saude::searchResultsPage();
});