<?php

Router::route("GET", '[/{lang}]/distrito/{id_distrito}/{distrito_name}', function($id_distrito) {
	\Controllers\Distrito::overviewPage($id_distrito);
});

Router::route("GET", '[/{lang}]/district/{id_distrito}/{distrito_name}', function($id_distrito) {
	\Controllers\Distrito::overviewPage($id_distrito);
});

Router::route("GET", '[/{lang}]/distrito/{id_distrito}/{distrito_name}/tempo', function($id_distrito) {
	\Controllers\Distrito::weatherPage($id_distrito);
});

Router::route("GET", '[/{lang}]/district/{id_distrito}/{distrito_name}/weather', function($id_distrito) {
	\Controllers\Distrito::weatherPage($id_distrito);
});

Router::route("GET", '[/{lang}]/distrito/{id_distrito}/{distrito_name}/galeria', function($id_distrito) {
	\Controllers\Distrito::galleryPage($id_distrito);
});

Router::route("GET", '[/{lang}]/district/{id_distrito}/{distrito_name}/gallery', function($id_distrito) {
	\Controllers\Distrito::galleryPage($id_distrito);
});

Router::route("GET", '[/{lang}]/distrito/{id_distrito}/{distrito_name}/mapa', function($id_distrito) {
	\Controllers\Distrito::mapPage($id_distrito);
});

Router::route("GET", '[/{lang}]/district/{id_distrito}/{distrito_name}/map', function($id_distrito) {
	\Controllers\Distrito::mapPage($id_distrito);
});

Router::route("GET", '[/{lang}]/distrito/{id_distrito}/{distrito_name}/farmacias', function($id_distrito) {
	\Controllers\Distrito::pharmaciesListPage($id_distrito);
});

Router::route("GET", '[/{lang}]/district/{id_distrito}/{distrito_name}/pharmacies', function($id_distrito) {
	\Controllers\Distrito::pharmaciesListPage($id_distrito);
});


Router::route("GET", '[/{lang}]/distrito/{id_distrito}/{distrito_name}/escolas', function($id_distrito) {
	\Controllers\Distrito::schoolsListPage($id_distrito);
});

Router::route("GET", '[/{lang}]/district/{id_distrito}/{distrito_name}/schools', function($id_distrito) {
	\Controllers\Distrito::schoolsListPage($id_distrito);
});


Router::route("GET", '[/{lang}]/distrito/{id_distrito}/{distrito_name}/saude', function($id_distrito) {
	\Controllers\Distrito::healthCareUnitsListPage($id_distrito);
});

Router::route("GET", '[/{lang}]/district/{id_distrito}/{distrito_name}/healthcare', function($id_distrito) {
	\Controllers\Distrito::healthCareUnitsListPage($id_distrito);
});


Router::route("GET", '[/{lang}]/distrito/{id_distrito}/{distrito_name}/policia', function($id_distrito) {
	\Controllers\Distrito::policePrecintsListPage($id_distrito);
});

Router::route("GET", '[/{lang}]/district/{id_distrito}/{distrito_name}/police', function($id_distrito) {
	\Controllers\Distrito::policePrecintsListPage($id_distrito);
});


Router::route("GET", '[/{lang}]/distrito/{id_distrito}/{distrito_name}/bombeiros', function($id_distrito) {
	\Controllers\Distrito::firefightersListPage($id_distrito);
});

Router::route("GET", '[/{lang}]/district/{id_distrito}/{distrito_name}/firefighters', function($id_distrito) {
	\Controllers\Distrito::firefightersListPage($id_distrito);
});


Router::route("GET", '[/{lang}]/distrito/{id_distrito}/{distrito_name}/praias', function($id_distrito) {
	\Controllers\Distrito::beachesListPage($id_distrito);
});

Router::route("GET", '[/{lang}]/district/{id_distrito}/{distrito_name}/beaches', function($id_distrito) {
	\Controllers\Distrito::beachesListPage($id_distrito);
});

Router::route("GET", '[/{lang}]/distrito/{id_distrito}/{distrito_name}/pontos-turisticos', function($id_distrito) {
	\Controllers\Distrito::tourismPointsListPage($id_distrito);
});

Router::route("GET", '[/{lang}]/district/{id_distrito}/{distrito_name}/tourism-points', function($id_distrito) {
	\Controllers\Distrito::tourismPointsListPage($id_distrito);
});

Router::route("GET", '[/{lang}]/distrito/{id_distrito}/{distrito_name}/eventos', function($id_distrito) {
	\Controllers\Distrito::eventsListPage($id_distrito);
});

Router::route("GET", '[/{lang}]/district/{id_distrito}/{distrito_name}/events', function($id_distrito) {
	\Controllers\Distrito::eventsListPage($id_distrito);
});