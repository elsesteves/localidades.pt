<?php if (exists($praias['items'])) : ?>
	<div class="pb-4">
		<div id="beaches_points_list" class="row gx-2 gy-2 points_list" data-pagination-page_limit="12"  data-pagination-start_page="1" data-pagination-margin2edges="2" data-pagination-margin2current="1">
			
			<?php foreach($praias['items'] as $item) : ?>
			<div class="col-md-6 col-lg-4 col-xxl-3">
				<a href="<?= $item['url'] ?>">
					<div class="point_card">
						<?php if (exists($item['image']['background'])) : ?>
							<div class="img_wrap show">
								<div class="img" data-bg="<?= $item['image']['background'] ?>"></div>
								<?php /*
								<div class="img" style="background-image: url(<?= $item['image']['background'] ?>);"></div>
								*/ ?>
							</div>
						<?php else: ?>
							<div class="img_wrap">
								<div class="img" style="background-image: none;"></div>
							</div>
						<?php endif; ?>
						<div class="info">
							<div class="title"><?= $item['title'] ?></div>
							<?php if(exists($item['address'])) : ?>
							<div class="address"><?= $item['address'] ?></div>
							<?php endif; ?>

							<?php if(exists($item['freguesia'])) : ?>
							<div class="freguesia"><?= $item['freguesia']['title'] ?></div>
							<?php endif; ?>
						</div>
					</div>
				</a>
			</div>
			<?php endforeach; ?>

		</div>
		<div id="beaches_points_pagination" class="view_more_wrap mt-2"></div>
	</div>

	<script type="text/javascript" src="<?= $site['baseURL'] ?>/assets/themes/localidades/js/pagination.js"></script>
	<script type="text/javascript" defer>
		const beachesPagination = new Pagination('beachesPagination', $("#beaches_points_list"), $("#beaches_points_pagination"));
	</script>
<?php endif; ?>