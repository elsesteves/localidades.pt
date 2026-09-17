<?php
	include __DIR__."/../inc/breadcrumbs.php";
?>

<div class="container-fluid mb-3">
	<div class="row">
		<div id="region_main" class="col-lg-9 col-md-7 sticky-col">
			<div class="pb-4">
				<?php include __DIR__."/search_form.php"; ?>
				<h2 class="section_title main"><?= \Lang\Dictionary::get('firefighters_that_may_interest_you')  ?></h2>
				<?php include __DIR__."/lists/bombeiros.php"; ?>
			</div>
		</div>
		<?php include __DIR__."/../inc/sidebar.php" ?>
	</div>
</div>
