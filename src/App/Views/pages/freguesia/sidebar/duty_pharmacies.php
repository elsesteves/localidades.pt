<!-- Scrape //farmaciasdeservico.net/widget/?localidade=lisboa%7Csintra&cor_fundo=%23ffffff&cor_titulo=%23000000&cor_texto=%23333333&margem=16&v=1 -->
<hr>
<div class="widget-content" id="pharmacies_widget">
	<div class="col-12 title"><?= \Lang\Dictionary::get('pharma_duty') ?></div>

	<?php foreach($sidebar['duty_pharmacies'] as $duty_pharmacy) : ?>
	<div class="row mt-1 pharmacy_row">
		<div class="col-3 text-center">
			<img src="https://www.medd-design.com/wp-content/uploads/2022/09/icones_farmacia-09.png">
		</div>
	    <div class="col-9 pharmacy_txt">
	    	<div class="farmacia"><?= $duty_pharmacy ?></div>
	    </div>
	</div>
	<?php endforeach; ?>

</div>