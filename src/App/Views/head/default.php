	<meta charset="utf-8">
	<meta name="distribution" content="Global">
	<meta name="rating" content="General">
	<meta name="expires" content="Never">
	<meta name="robots" content="Index, Follow">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<!--<link rel="shortcut icon" href="/assets/images/logo/logo.png">-->
	<title>Localidades</title>

	<link href="<?= $site['baseURL'] ?>/assets/plugins/bootstrap-5.3.0-alpha1-dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" crossorigin="anonymous"></script>

	<?php if (file_exists(SITE_ROOT.'/assets/themes/localidades/css/'.$page.'.css')) { ?>
		<link href="<?= $site['baseURL'] ?>/assets/themes/localidades/css/<?= $page ?>.css" rel="stylesheet">
	<?php } else { ?>
		<link href="<?= $site['baseURL'] ?>/assets/themes/localidades/css/regions.css" rel="stylesheet">		
	<?php } ?>
	


	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;600&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;600&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;600&display=swap" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="<?= $site['baseURL'] ?>/assets/plugins/slick-1.8.1/slick/slick.css"/>
	<link rel="stylesheet" type="text/css" href="<?= $site['baseURL'] ?>/assets/plugins/slick-1.8.1/slick/slick-theme.css"/>

	<link rel="stylesheet" href="<?= $site['baseURL'] ?>/assets/plugins/magnific-popup/magnific-popup.css">

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript">var $jquery_maginific_popup = $.noConflict(true);</script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>