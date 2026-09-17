<?php if (exists($gallery['items'])) : ?>
	<div class="pb-4">
		<h2 class="section_title"><?= \Lang\Dictionary::get('gallery') ?></h2>
		<div id="region_photo_gallery" class="row gx-2 gy-2">
			
			<?php foreach($gallery['items'] as $galleryItem) : ?>
				<a class="popup-img-slide" href="<?= $galleryItem['src'] ?>" data-popup_caption="<?= $galleryItem['caption'] ?>">
					<div class="region_photo_gallery_item">
						<div class="gallery_item_inner">
							<img src="<?= $galleryItem['src'] ?>" loading="lazy">
						</div>
					</div>
				</a>		
			<?php endforeach; ?>

		</div>

		<div class="view_more_wrap mt-2">
			<a href="<?= $concelho['url']."/".\Lang\Dictionary::get('urlparam_gallery') ?>" class="view_more_btn"><?= \Lang\Dictionary::get('view_more') ?></a>
		</div>
	</div>
<?php endif; ?>