<div class="container-fluid mt-3 mb-3">
	<div class="row">

		<div id="" class="col-lg-9 col-md-7 sticky-col">

			<?php if (exists($dist_by_region['regions'])) : ?>
				<div class="pb-4">
				<?php foreach($dist_by_region['regions'] as $region) : ?>
					<?php if (exists($region['distritos'])) : ?>
						<div class="pb-4">
							<h2 class="section_title"><?= $region['title'] ?></h2>
							<div class="row gx-2 gy-2 subregions_list">
							<?php foreach($region['distritos'] as $distrito) : ?>

							<div class="col-md-6 col-lg-4 col-xxl-3">
								<a href="<?= $distrito['url'] ?>">
									<div class="subregion_card">
										<?php if (exists($distrito['img']['background'])) : ?>
										<div class="img_wrap">
											<div class="subregion_img" data-bg="<?= $distrito['img']['background'] ?>"></div>
										</div>
										<?php else: ?>
										<div class="img_wrap">
											<div class="subregion_img" style="background-image: none;"></div>
										</div>
										<?php endif; ?>
										<div class="info">
											<div class="title"><?= $distrito['title'] ?></div>
										</div>
									</div>
								</a>
							</div>
						
							<?php endforeach; ?>
							</div>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<div class="home-section pb-4">
				<h2 class="section_title"><?= \Lang\Dictionary::get('events') ?></h2>
				<p><?= \Lang\Dictionary::get('sidebar_highlight_events_description') ?></p>
				<?php include __DIR__."/lists/eventos.php"; ?>

				<div class="view_more_wrap mt-2">
					<a href="<?= \Lang\Lang::fetchCurrentLangRef()."/".\Lang\Dictionary::get('urlparam_events') ?>" class="view_more_btn"><?= \Lang\Dictionary::get('view_more') ?></a>
				</div>
			</div>

			<div class="home-section pb-4">
				<h2 class="section_title"><?= \Lang\Dictionary::get('beaches') ?></h2>
				<p><?= \Lang\Dictionary::get('sidebar_highlight_beaches_description') ?></p>
				<?php include __DIR__."/lists/praias.php"; ?>

				<div class="view_more_wrap mt-2">
					<a href="<?= \Lang\Lang::fetchCurrentLangRef()."/".\Lang\Dictionary::get('urlparam_beaches') ?>" class="view_more_btn"><?= \Lang\Dictionary::get('view_more') ?></a>
				</div>
			</div>


			<div class="home-section pb-4">
				<h2 class="section_title"><?= \Lang\Dictionary::get('tourism_points') ?></h2>
				<p><?= \Lang\Dictionary::get('sidebar_highlight_tourism_description') ?></p>
				<?php include __DIR__."/lists/pontos_turismo.php"; ?>

				<div class="view_more_wrap mt-2">
					<a href="<?= \Lang\Lang::fetchCurrentLangRef()."/".\Lang\Dictionary::get('urlparam_tourism_points') ?>" class="view_more_btn"><?= \Lang\Dictionary::get('view_more') ?></a>
				</div>
			</div>
			
		</div>

		<?php include __DIR__."/../inc/sidebar.php"; ?>
		
	</div>
</div>