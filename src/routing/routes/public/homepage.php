<?php

Router::route("GET", '[/{lang}]', function() {
	\Controllers\Homepage::homepage();
});