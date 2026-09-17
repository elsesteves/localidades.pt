<?php
	include __DIR__."/../inc/breadcrumbs.php";
?>
<div class="container-fluid mb-3">
	<div class="row">
		<?php include __DIR__."/sidebar.php"; ?>
		<div id="region_main" class="col-lg-9 col-md-7 sticky-col">

		<?php if (exists($gallery['items'])) : ?>
			<div class="pb-4">
				<h2 class="section_title"><?= \Lang\Dictionary::get('gallery') ?></h2>
				<div id="region_photo_gallery" class="row gx-2 gy-2">
					
					<?php foreach($gallery['items'] as $galleryItem) : ?>
						<div class="col-md-6 col-lg-4 col-xl-3">
							<a class="popup-img-slide" href="<?= $galleryItem['src'] ?>" data-popup_caption="<?= $galleryItem['caption'] ?>">
								<div class="region_photo_gallery_item">
									<div class="gallery_item_inner">
										<img src="<?= $galleryItem['src'] ?>">
									</div>
								</div>
							</a>	
						</div>
					<?php endforeach; ?>

				</div>

				<div class="view_more_wrap mt-2">
					
					<?php 
						$pageBaseLink =  $distrito['url']."/".\Lang\Dictionary::get('urlparam_gallery');
						$margin2Edges = 2;
						$margin2Current = 1;
					?>
					<?php if($gallery['pagination']['current_page'] > 1) : ?>
						<a href="<?= $pageBaseLink .'?page='. $gallery['pagination']['current_page'] - 1 ?>" class="view_more_btn"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
					<?php endif; ?>

					<?php 
					$prevNoShow = false;
					for ($i=1; $i <= $gallery['pagination']['last_page']; $i++) : ?>
						<?php if(($i < 1 + $margin2Edges) || ($i > $gallery['pagination']['last_page'] - $margin2Edges) || (abs($gallery['pagination']['current_page'] - $i) <= $margin2Current)) : ?>
							<?php $prevNoShow = false;
							if($i == $gallery['pagination']['current_page']) : ?>
								<span class="view_more_btn current"><?= $i ?></span>
							<?php else : ?>
								<a href="<?= $pageBaseLink .'?page='. $i ?>" class="view_more_btn"><?= $i ?></a>
							<?php endif; ?>
						<?php else: ?>
							<?php 
							if (!$prevNoShow) {
								?>
								<span class="ellipsis">...</span>
								<?php
								$prevNoShow = true; 
							}
							?>
						<?php endif; ?>
					<?php endfor; ?>


					<?php if($gallery['pagination']['current_page'] < $gallery['pagination']['last_page']) : ?>
						<a href="<?= $pageBaseLink .'?page='. $gallery['pagination']['current_page'] + 1 ?>" class="view_more_btn"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
					<?php endif; ?>

				</div>
			</div>
		<?php endif; ?>

		</div>
	</div>
</div>


