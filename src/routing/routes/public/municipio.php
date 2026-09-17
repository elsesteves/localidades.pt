<?php

Router::route("GET", '[/{lang}]/municipio/{id_concelho}/{concelho_name}', function($id_concelho) {
	\Controllers\Concelho::overviewPage($id_concelho);
});

Router::route("GET", '[/{lang}]/municipality/{id_concelho}/{concelho_name}', function($id_concelho) {
	\Controllers\Concelho::overviewPage($id_concelho);
});

Router::route("GET", '[/{lang}]/municipio/{id_concelho}/{concelho_name}/tempo', function($id_concelho) {
	\Controllers\Concelho::weatherPage($id_concelho);
});

Router::route("GET", '[/{lang}]/municipality/{id_concelho}/{concelho_name}/weather', function($id_concelho) {
	\Controllers\Concelho::weatherPage($id_concelho);
});

Router::route("GET", '[/{lang}]/municipio/{id_concelho}/{concelho_name}/galeria', function($id_concelho) {
	\Controllers\Concelho::galleryPage($id_concelho);
});

Router::route("GET", '[/{lang}]/municipality/{id_concelho}/{concelho_name}/gallery', function($id_concelho) {
	\Controllers\Concelho::galleryPage($id_concelho);
});

Router::route("GET", '[/{lang}]/municipio/{id_concelho}/{concelho_name}/mapa', function($id_concelho) {
	\Controllers\Concelho::mapPage($id_concelho);
});

Router::route("GET", '[/{lang}]/municipality/{id_concelho}/{concelho_name}/map', function($id_concelho) {
	\Controllers\Concelho::mapPage($id_concelho);
});

Router::route("GET", '[/{lang}]/municipio/{id_concelho}/{concelho_name}/farmacias', function($id_concelho) {
	\Controllers\Concelho::pharmaciesListPage($id_concelho);
});

Router::route("GET", '[/{lang}]/municipality/{id_concelho}/{concelho_name}/pharmacies', function($id_concelho) {
	\Controllers\Concelho::pharmaciesListPage($id_concelho);
});


Router::route("GET", '[/{lang}]/municipio/{id_concelho}/{concelho_name}/escolas', function($id_concelho) {
	\Controllers\Concelho::schoolsListPage($id_concelho);
});

Router::route("GET", '[/{lang}]/municipality/{id_concelho}/{concelho_name}/schools', function($id_concelho) {
	\Controllers\Concelho::schoolsListPage($id_concelho);
});


Router::route("GET", '[/{lang}]/municipio/{id_concelho}/{concelho_name}/saude', function($id_concelho) {
	\Controllers\Concelho::healthCareUnitsListPage($id_concelho);
});

Router::route("GET", '[/{lang}]/municipality/{id_concelho}/{concelho_name}/healthcare', function($id_concelho) {
	\Controllers\Concelho::healthCareUnitsListPage($id_concelho);
});


Router::route("GET", '[/{lang}]/municipio/{id_concelho}/{concelho_name}/policia', function($id_concelho) {
	\Controllers\Concelho::policePrecintsListPage($id_concelho);
});

Router::route("GET", '[/{lang}]/municipality/{id_concelho}/{concelho_name}/police', function($id_concelho) {
	\Controllers\Concelho::policePrecintsListPage($id_concelho);
});


Router::route("GET", '[/{lang}]/municipio/{id_concelho}/{concelho_name}/bombeiros', function($id_concelho) {
	\Controllers\Concelho::firefightersListPage($id_concelho);
});

Router::route("GET", '[/{lang}]/municipality/{id_concelho}/{concelho_name}/firefighters', function($id_concelho) {
	\Controllers\Concelho::firefightersListPage($id_concelho);
});


Router::route("GET", '[/{lang}]/municipio/{id_concelho}/{concelho_name}/praias', function($id_concelho) {
	\Controllers\Concelho::beachesListPage($id_concelho);
});

Router::route("GET", '[/{lang}]/municipality/{id_concelho}/{concelho_name}/beaches', function($id_concelho) {
	\Controllers\Concelho::beachesListPage($id_concelho);
});

Router::route("GET", '[/{lang}]/municipio/{id_concelho}/{concelho_name}/pontos-turisticos', function($id_concelho) {
	\Controllers\Concelho::tourismPointsListPage($id_concelho);
});

Router::route("GET", '[/{lang}]/municipality/{id_concelho}/{concelho_name}/tourism-points', function($id_concelho) {
	\Controllers\Concelho::tourismPointsListPage($id_concelho);
});

Router::route("GET", '[/{lang}]/municipio/{id_concelho}/{concelho_name}/eventos', function($id_concelho) {
	\Controllers\Concelho::eventsListPage($id_concelho);
});

Router::route("GET", '[/{lang}]/municipality/{id_concelho}/{concelho_name}/events', function($id_concelho) {
	\Controllers\Concelho::eventsListPage($id_concelho);
});