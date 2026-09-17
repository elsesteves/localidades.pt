<?php

Router::route("GET", '/api[/{lang}]/district/{id_distrito}/municipalities', function($id_distrito) {
	\Controllers\Concelho::getListFromDistrict($id_distrito);
});

Router::route("GET", '/api[/{lang}]/municipality/{id_concelho}/parishes', function($id_concelho) {
	\Controllers\Freguesia::getListFromMunicipaliy($id_concelho);
});