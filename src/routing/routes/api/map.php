<?php

Router::route("GET", '/api/map/directions', 'Tools\Map.directions()');

Router::route("GET", '/api[/{lang}]/district/{id_distrito}/{distrito_name}/map/points', function($id_distrito) {
	\Controllers\Distrito::mapPoints($id_distrito);
});

Router::route("GET", '/api[/{lang}]/municipality/{id_concelho}/{concelho_name}/map/points', function($id_concelho) {
	\Controllers\Concelho::mapPoints($id_concelho);
});

Router::route("GET", '/api[/{lang}]/parish/{id_freguesia}/{freguesia_name}/map/points', function($id_freguesia) {
	\Controllers\Freguesia::mapPoints($id_freguesia);
});