<?php

$noCache = '';

/*
if (isset($_GET['module'])) {
	$module = $_GET['module'];
} else {
	$module = 'stats';
}

if (isset($_GET['submodule'])) {
	$submodule = $_GET['submodule'];
} else {
  $submodule = '';
}

if (!empty($submodule)) {
  $baseTable = $module.'_'.$submodule;
} else {
  $baseTable = $module;
}

if (isset($_GET['file'])) {
	$file = $_GET['file'];
} else {
	$file = 'index';
}

if (isset($_GET['id'])) {
	$id = (int) $_GET['id'];
} else {
	$id = 0;
}


if (isset($_GET['page'])) {
  $page = intval(DB::escape_string($_GET['page']));
} else {
  $page = 1;
}
*/

//Use this variable for pagination
$listPageLink = '';

$listPageLinkNotIn = array('page', 'lang');
foreach ($_GET as $get_key =>$get_val) {
  if (!in_array($get_key, $listPageLinkNotIn)) {
    if ($listPageLink == '') {
      $listPageLink = '?'.$get_key.'='.$get_val;
    } else {
      $listPageLink .= '&'.$get_key.'='.$get_val;
    }
  }
}


?>
<!DOCTYPE html>
<html lang="pt" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="author" content="<?= SITE_CONFIGS['info']['author']['name'] ?>">
    <title>Backoffice | <?= SITE_CONFIGS['info']['name'] ?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <!--
    <link rel="shortcut icon" href="<?= $site['baseURL'] ?>/assets/themes/admin/img/logos/favicon-3d.png">
    -->

    <!-- Magnific Popup - Lightbox Plugin -->
    <!-- Magnific Popup core CSS file -->
    <link rel="stylesheet" href="<?= $site['baseURL'] ?>/assets/themes/admin/plugins/magnific-popup/magnific-popup.css">
    <!-- Magnific Popup core JS file -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript">var $jquery_maginific_popup = $.noConflict(true);</script>

    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/zepto/1.2.0/zepto.min.js"></script>-->
    <!--<script src="<?= $site['baseURL'] ?>/assets/themes/admin/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>-->

    <script src="<?= $site['baseURL'] ?>/assets/themes/admin/plugins/magnific-popup/jquery.magnific-popup.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!--JQuery UI -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>

    <link rel="stylesheet" type="text/css" href="<?= $site['baseURL'] ?>/assets/themes/admin/css/settings.css<?= $noCache; ?>">
    <link rel="stylesheet" type="text/css" href="<?= $site['baseURL'] ?>/assets/themes/admin/css/main.css<?= $noCache; ?>">
    <link rel="stylesheet" type="text/css" href="<?= $site['baseURL'] ?>/assets/themes/admin/css/mobile.css<?= $noCache; ?>">
		
  </head>
  <body>

  <?php
    require_once __DIR__.'/header.view.php';
    require_once __DIR__.'/sidebar.view.php';
  ?>

  <div id="bo_main_area">
    <?php
      $page = fileTryLoop(array(
        __DIR__.'/../'.$file['folder'].'/'.$file['file'].'.view.php',
        __DIR__.'/../_global/'.$file['file'].'.view.php'
      ));

      if ($page !== false) {
        require_once $page;
      } else {
        require_once __DIR__.'/../errors/404.view.php';
      }
    ?>
  </div>

  <?php
    require_once __DIR__.'/footer.view.php';
    require_once __DIR__.'/alerts.view.php';
    require_once __DIR__.'/script.view.php';
  ?>

  </body>
</html>