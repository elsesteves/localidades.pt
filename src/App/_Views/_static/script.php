<script src="<?= $site['baseURL'] ?>/assets/themes/hyperspace/js/jquery.min.js"></script>
<script src="<?= $site['baseURL'] ?>/assets/themes/hyperspace/js/jquery.scrollex.min.js"></script>
<script src="<?= $site['baseURL'] ?>/assets/themes/hyperspace/js/jquery.scrolly.min.js"></script>
<script src="<?= $site['baseURL'] ?>/assets/themes/hyperspace/js/browser.min.js"></script>
<script src="<?= $site['baseURL'] ?>/assets/themes/hyperspace/js/breakpoints.min.js"></script>
<script src="<?= $site['baseURL'] ?>/assets/themes/hyperspace/js/util.js"></script>
<script src="<?= $site['baseURL'] ?>/assets/themes/hyperspace/js/main.js"></script>

<script src="<?= $site['baseURL'] ?>/assets/themes/agency/js/global.min.js"></script>

<script type="text/javascript">
	function sidebarToggle() {
		var sidebar = document.querySelector("#sidebar");
		if (sidebar.className == 'mobile-show') {
			sidebar.className = '';
		} else {
			sidebar.className = 'mobile-show';
		}
	}
</script>

<?php
	if (file_exists(__DIR__.'/../scripts/'.$page.'.view.php')) {
		require_once __DIR__.'/../scripts/'.$page.'.view.php';
	}
?>