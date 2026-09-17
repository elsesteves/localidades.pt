<?php if (exists($freguesias)) : ?>
	<div class="pb-4">
		<h2 class="section_title"><?= \Lang\Dictionary::get('parishes') ?></h2>
		<div class="row gx-2 gy-2 subregions_list">
		<?php foreach($freguesias as $freguesia) : ?>

		<div class="col-md-6 col-lg-4 col-xxl-3">
			<a href="<?= $freguesia['url'] ?>">
				<div class="subregion_card">
					<?php if (exists($freguesia['img']['background'])) : ?>
					<div class="img_wrap">
						<div class="subregion_img" data-bg="<?= $freguesia['img']['background'] ?>"></div>
					</div>
					<?php else: ?>
					<div class="img_wrap">
						<div class="subregion_img" style="background-image: none;"></div>
					</div>
					<?php endif; ?>
					<div class="info">
						<div class="title"><?= $freguesia['title'] ?></div>
					</div>
				</div>
			</a>
		</div>
	
		<?php endforeach; ?>
		</div>
	</div>
<?php endif; ?>
