<?php

Router::route("GET", '[/{lang}]/freguesia/{id_freguesia}/{freguesia_name}', function($id_freguesia) {
	\Controllers\Freguesia::overviewPage($id_freguesia);
});

Router::route("GET", '[/{lang}]/parish/{id_freguesia}/{freguesia_name}', function($id_freguesia) {
	\Controllers\Freguesia::overviewPage($id_freguesia);
});

Router::route("GET", '[/{lang}]/freguesia/{id_freguesia}/{freguesia_name}/tempo', function($id_freguesia) {
	\Controllers\Freguesia::weatherPage($id_freguesia);
});

Router::route("GET", '[/{lang}]/parish/{id_freguesia}/{freguesia_name}/weather', function($id_freguesia) {
	\Controllers\Freguesia::weatherPage($id_freguesia);
});

Router::route("GET", '[/{lang}]/freguesia/{id_freguesia}/{freguesia_name}/galeria', function($id_freguesia) {
	\Controllers\Freguesia::galleryPage($id_freguesia);
});

Router::route("GET", '[/{lang}]/parish/{id_freguesia}/{freguesia_name}/gallery', function($id_freguesia) {
	\Controllers\Freguesia::galleryPage($id_freguesia);
});

Router::route("GET", '[/{lang}]/freguesia/{id_freguesia}/{freguesia_name}/mapa', function($id_freguesia) {
	\Controllers\Freguesia::mapPage($id_freguesia);
});

Router::route("GET", '[/{lang}]/parish/{id_freguesia}/{freguesia_name}/map', function($id_freguesia) {
	\Controllers\Freguesia::mapPage($id_freguesia);
});

Router::route("GET", '[/{lang}]/freguesia/{id_freguesia}/{freguesia_name}/farmacias', function($id_freguesia) {
	\Controllers\Freguesia::pharmaciesListPage($id_freguesia);
});

Router::route("GET", '[/{lang}]/parish/{id_freguesia}/{freguesia_name}/pharmacies', function($id_freguesia) {
	\Controllers\Freguesia::pharmaciesListPage($id_freguesia);
});


Router::route("GET", '[/{lang}]/freguesia/{id_freguesia}/{freguesia_name}/escolas', function($id_freguesia) {
	\Controllers\Freguesia::schoolsListPage($id_freguesia);
});

Router::route("GET", '[/{lang}]/parish/{id_freguesia}/{freguesia_name}/schools', function($id_freguesia) {
	\Controllers\Freguesia::schoolsListPage($id_freguesia);
});


Router::route("GET", '[/{lang}]/freguesia/{id_freguesia}/{freguesia_name}/saude', function($id_freguesia) {
	\Controllers\Freguesia::healthCareUnitsListPage($id_freguesia);
});

Router::route("GET", '[/{lang}]/parish/{id_freguesia}/{freguesia_name}/healthcare', function($id_freguesia) {
	\Controllers\Freguesia::healthCareUnitsListPage($id_freguesia);
});


Router::route("GET", '[/{lang}]/freguesia/{id_freguesia}/{freguesia_name}/policia', function($id_freguesia) {
	\Controllers\Freguesia::policePrecintsListPage($id_freguesia);
});

Router::route("GET", '[/{lang}]/parish/{id_freguesia}/{freguesia_name}/police', function($id_freguesia) {
	\Controllers\Freguesia::policePrecintsListPage($id_freguesia);
});


Router::route("GET", '[/{lang}]/freguesia/{id_freguesia}/{freguesia_name}/bombeiros', function($id_freguesia) {
	\Controllers\Freguesia::firefightersListPage($id_freguesia);
});

Router::route("GET", '[/{lang}]/parish/{id_freguesia}/{freguesia_name}/firefighters', function($id_freguesia) {
	\Controllers\Freguesia::firefightersListPage($id_freguesia);
});


Router::route("GET", '[/{lang}]/freguesia/{id_freguesia}/{freguesia_name}/praias', function($id_freguesia) {
	\Controllers\Freguesia::beachesListPage($id_freguesia);
});

Router::route("GET", '[/{lang}]/parish/{id_freguesia}/{freguesia_name}/beaches', function($id_freguesia) {
	\Controllers\Freguesia::beachesListPage($id_freguesia);
});

Router::route("GET", '[/{lang}]/freguesia/{id_freguesia}/{freguesia_name}/pontos-turisticos', function($id_freguesia) {
	\Controllers\Freguesia::tourismPointsListPage($id_freguesia);
});

Router::route("GET", '[/{lang}]/parish/{id_freguesia}/{freguesia_name}/tourism-points', function($id_freguesia) {
	\Controllers\Freguesia::tourismPointsListPage($id_freguesia);
});

Router::route("GET", '[/{lang}]/freguesia/{id_freguesia}/{freguesia_name}/eventos', function($id_freguesia) {
	\Controllers\Freguesia::eventsListPage($id_freguesia);
});

Router::route("GET", '[/{lang}]/parish/{id_freguesia}/{freguesia_name}/events', function($id_freguesia) {
	\Controllers\Freguesia::eventsListPage($id_freguesia);
});