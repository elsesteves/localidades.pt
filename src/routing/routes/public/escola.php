<?php

Router::route("GET", '[/{lang}]/escola/{id_escola}/{escola_name}', function($id_escola) {
	\Controllers\Escola::schoolInfoPage($id_escola);
});

Router::route("GET", '[/{lang}]/school/{id_escola}/{escola_name}', function($id_escola) {
	\Controllers\Escola::schoolInfoPage($id_escola);
});

Router::route("GET", '[/{lang}]/agrupamento-escolar/{id_agrupamento}/{agrupamento_name}', function($id_agrupamento) {
	\Controllers\Escola::groupingInfoPage($id_agrupamento);
});

Router::route("GET", '[/{lang}]/school-grouping/{id_agrupamento}/{agrupamento_name}', function($id_agrupamento) {
	\Controllers\Escola::groupingInfoPage($id_agrupamento);
});

Router::route("GET", '[/{lang}]/escolas', function() {
	\Controllers\Escola::mainPage();
});

Router::route("GET", '[/{lang}]/schools', function() {
	\Controllers\Escola::mainPage();
});

Router::route("GET", '[/{lang}]/escolas/pesquisa', function() {
	\Controllers\Escola::searchResultsPage();
});

Router::route("GET", '[/{lang}]/schools/search', function() {
	\Controllers\Escola::searchResultsPage();
});