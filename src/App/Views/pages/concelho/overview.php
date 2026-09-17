<?php
	include __DIR__."/../inc/breadcrumbs.php";
?>
<div class="container-fluid mb-3">
	<div class="row">
		<?php include __DIR__."/sidebar.php"; ?>
		<div id="region_main" class="col-lg-9 col-md-7 sticky-col">
		<?php
			include __DIR__."/freguesias_list.php";
			//include __DIR__."/news_list_short.php";
			include __DIR__."/eventos_list.php";
			include __DIR__."/gallery.php";
			

			$showMapTitle = true;
			include __DIR__."/../inc/map.php";
		?>
		</div>
	</div>
</div>
