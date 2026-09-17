<?php if(exists($sidebar['weather'])): ?>
<hr>
<div class="widget-content" id="weather_widget">

	<div class="col-12">

	  <div id="weather_main">
	    <div class="row">
	      <div class="col-xs-12 title dayOfWeekTitle"><?= \Lang\Dictionary::get('the_weather_right_now') ?></div>
	      <div class="col-md-3 col-sm-4 col-xs-4">
	        <img src="<?= $sidebar['weather']['current']['condition']['icon'] ?>" title="<?= $sidebar['weather']['current']['condition']['text'] ?>" width="auto" style="max-width: 100%;">
	      </div>
	      <div class="col-md-9 col-sm-8 col-xs-8 curr_weatherdata">
	        <div class="col-xs-12 curr_temp">
	          <?= $sidebar['weather']['current']['temperature']['current'] ?>ºC
	        </div>
	        <div class="row">

	          <div class="col-xs-12 details">
	            <span title="<?= \Lang\Dictionary::get('temp_min') ?>"><?= $sidebar['weather']['current']['temperature']['min'] ?>ºC</span>
	            <span> | </span>
	            <span title="<?= \Lang\Dictionary::get('temp_max') ?>"><?= $sidebar['weather']['current']['temperature']['max'] ?>ºC</span>
	          </div>
	          <div class="col-xs-12 details_other"><?= \Lang\Dictionary::get('humidity') ?>: <?= $sidebar['weather']['current']['humidity'] ?>%</div>
	          <div class="col-xs-12 details_other"><?= \Lang\Dictionary::get('wind') ?>: <?= $sidebar['weather']['current']['wind'] ?>Km/h</div>
	        </div>
	      </div>
	    </div>
	  </div>

	</div>

	<div class="col-12 mt-4">
		<div class="row" id="weather_nextdays">
			<div class="col-12 title"><?= \Lang\Dictionary::get('the_weather_in_the_next_days') ?></div>

			<?php foreach ($sidebar['weather']['forecast'] as $date => $forecast) : ?>
				<div class="col-md-6 col-xs-6 text-center futureday_weatherdata">
		            <div class="col-xs-12 futureday_title"><?= $forecast['weekdays']['name'] ?></div>
					<img src="<?= $forecast['condition']['icon'] ?>" title="<?= $forecast['condition']['text'] ?>">
					<div class="row">
						<div class="col-xs-12 temp"><span title="<?= \Lang\Dictionary::get('temp_min') ?>"><?= $forecast['temp_c']['min'] ?>ºC</span><span> | </span><span title="<?= \Lang\Dictionary::get('temp_max') ?>"><?= $forecast['temp_c']['max'] ?>ºC</span></div>
						<div class="col-xs-12 humidity"><?= \Lang\Dictionary::get('humidity') ?>: <?= $forecast['humidity'] ?>%</div>
					</div>
		        </div>
			<?php endforeach; ?>

		</div>
	</div>
</div>
<?php endif; ?>