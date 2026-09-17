<?php

session_start();

set_time_limit(0);

error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('display_errors', 1);

define("SITE_ROOT", __DIR__);

require_once SITE_ROOT.'/src/Libs/vendor/autoload.php';
require_once SITE_ROOT.'/src/autoloader.php';
require_once SITE_ROOT.'/src/functions.php';

define("SITE_CONFIGS", requireJSONFolder(SITE_ROOT.'/configs/env'));


$baseURL = SITE_CONFIGS['info']['baseURL'];

//Establishing Cache connection for further use
Cache::start();

//Establishing Database connection for further use
DB::connect();

//Prevent cache
$noCache = "?nc=".date("YmdHis");

//Routing
require_once SITE_ROOT.'/src/App/routes/routes.php';
Router::index();