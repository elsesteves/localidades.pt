<script type="text/javascript" src="<?= $site['baseURL'] ?>/assets/plugins/bootstrap-5.3.0-alpha1-dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="<?= $site['baseURL'] ?>/assets/plugins/slick-1.8.1/slick/slick.min.js"></script>

<script src="<?= $site['baseURL'] ?>/assets/plugins/lazyloadxt/jquery.lazyloadxt.min.js"></script>
<script src="<?= $site['baseURL'] ?>/assets/plugins/lazyloadxt/addons/jquery.lazyloadxt.bg.min.js"></script>

<script type="text/javascript" src="<?= $site['baseURL'] ?>/assets/themes/localidades/js/global.js"></script>

<?php
	if (file_exists(__DIR__.'/../scripts/'.$page.'.php')) {
		require_once __DIR__.'/../scripts/'.$page.'.php';
	}
?>

<script type="text/javascript">
	$(window).lazyLoadXT();
</script>