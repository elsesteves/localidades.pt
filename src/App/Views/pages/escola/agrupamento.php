<?php
	include __DIR__."/../inc/breadcrumbs.php";

	function schoolCyclesString(array $cycles) {
		$i = 0;
		$str = '';
		foreach($cycles as $cycle) {
			if ($i > 0) {
				$str .= ', ';
			}

			$str .= $cycle['title'];

			$i++;
		}
		return $str;
	}
?>

<div class="container-fluid mb-3">
	<div class="row">
		<?php include __DIR__."/agrupamento_sidebar.php"; ?>
		<div id="region_main" class="col-lg-9 col-md-7 sticky-col">

			<div class="pb-4">
				<h2 class="section_title"><?= $agrupamento['title'] ?></h2>

				<?php if(exists($agrupamento['coduome'])) : ?>
				<p>
					<b><?= \Lang\Dictionary::get('codigo_agrupamento_coduome') ?>:</b> 
					<span><?= $agrupamento['coduome'] ?></span>
				</p>
				<?php endif; ?>

				<?php if(exists($agrupamento['address'])) : ?>
				<p>
					<b><?= \Lang\Dictionary::get('address') ?>:</b> 
					<span><?= $agrupamento['address'] ?></span>
				</p>
				<?php endif; ?>

				<?php if(exists($agrupamento['zip_code'])) : ?>
				<p>
					<b><?= \Lang\Dictionary::get('zip_code') ?>:</b> 
					<span><?= $agrupamento['zip_code'] ?></span>
				</p>
				<?php endif; ?>

				<?php if(exists($agrupamento['freguesia'])) : ?>
				<p>
					<b><?= \Lang\Dictionary::get('parish') ?>:</b> 
					<span><a href="<?= $agrupamento['freguesia']['url'] ?>"><?= $agrupamento['freguesia']['title'] ?></a></span>
				</p>
				<?php endif; ?>
				

				<?php include __DIR__."/../inc/map.php"; ?>
			</div>

		</div>
	</div>
</div>