<?php
	include __DIR__."/../inc/breadcrumbs.php";
?>
<div class="container-fluid mb-3">
	<div class="row">
		<?php include __DIR__."/sidebar.php"; ?>
		<div id="region_main" class="col-lg-9 col-md-7 sticky-col">

			<h2 class="section_title"><?= \Lang\Dictionary::get('pharmacies') ?></h2>

			<ul class="nav nav-tabs" role="tablist">
			  <li class="nav-item" role="presentation">
			    <button class="nav-link active" id="map_section-tab" data-bs-toggle="tab" data-bs-target="#map_section" type="button" role="tab" aria-controls="map_section" aria-selected="true">Mapa</button>
			  </li>
			  <li class="nav-item" role="presentation">
			    <button class="nav-link" id="pharmacies_section-tab" data-bs-toggle="tab" data-bs-target="#pharmacies_section" type="button" role="tab" aria-controls="pharmacies_section" aria-selected="false">Lista</button>
			  </li>
			</ul>
			<div class="tab-content pt-4">
			  <div class="tab-pane fade show active" id="map_section" role="tabpanel" aria-labelledby="map_section-tab">
			  	<?php include __DIR__."/../inc/map.php"; ?>
			  </div>
			  <div class="tab-pane fade" id="pharmacies_section" role="tabpanel" aria-labelledby="pharmacies_section-tab">
			  	<?php include __DIR__."/lists/pharmacies.php"; ?>
			  </div>
			</div>

		</div>
	</div>
</div>