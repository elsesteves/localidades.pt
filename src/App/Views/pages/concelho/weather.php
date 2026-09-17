<?php
	include __DIR__."/../inc/breadcrumbs.php";
?>
<div class="container-fluid mb-3">
	<div class="row">
		<?php include __DIR__."/sidebar.php"; ?>
		<div id="region_main" class="col-lg-9 col-md-7 sticky-col">

			<h2 class="section_title"><?= \Lang\Dictionary::get('the_weather_in_the_next_days') ?></h2>

			<div class="row">
			<?php if(exists($weather['forecast'])) : ?>
				<?php foreach ($weather['forecast'] as $date => $forecast) : ?>
					<div class="col-lg-2 col-md-3 col-xs-4 col-6 text-center futureday_weatherdata">
						<div class="col-xs-12 futureday_title"><?= $forecast['weekdays']['name'] ?></div>
						<img src="<?= $forecast['condition']['icon'] ?>" title="<?= $forecast['condition']['text'] ?>">
						<div class="row">
							<div class="col-xs-12 temp"><span title="<?= \Lang\Dictionary::get('temp_min') ?>"><?= $forecast['temp_c']['min'] ?>ºC</span><span> | </span><span title="<?= \Lang\Dictionary::get('temp_max') ?>"><?= $forecast['temp_c']['max'] ?>ºC</span></div>
							<div class="col-xs-12 humidity"><?= \Lang\Dictionary::get('humidity') ?>: <?= $forecast['humidity'] ?>%</div>
						</div>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
			</div>

		</div>
	</div>
</div>
