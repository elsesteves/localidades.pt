<?php if (exists($police_precints['items'])) : ?>
	<div class="pb-4">
		<div id="precints_points_list" class="row gx-2 gy-2 points_list" data-pagination-page_limit="12"  data-pagination-start_page="1" data-pagination-margin2edges="2" data-pagination-margin2current="1">
			
			<?php foreach($police_precints['items'] as $precint) : ?>
			<div class="col-md-6 col-lg-4 col-xxl-3">
				<a href="<?= $precint['url'] ?>">
					<div class="point_card">
						<div class="img_wrap">
							<div class="img" style="background-image: none;"></div>
						</div>
						<div class="info">
							<div class="title"><?= $precint['title'] ?></div>
							<div class="address"><?= $precint['address'] ?></div>
							
							<?php if(exists($precint['freguesia'])) : ?>
							<div class="freguesia"><?= $precint['freguesia']['title'] ?></div>
							<?php endif; ?>
						</div>
					</div>
				</a>
			</div>
			<?php endforeach; ?>

		</div>
		<div id="precints_points_pagination" class="view_more_wrap mt-2"></div>
	</div>

	<script type="text/javascript" src="<?= $site['baseURL'] ?>/assets/themes/localidades/js/pagination.js"></script>
	<script type="text/javascript" defer>
		const precintsPagination = new Pagination('precintsPagination', $("#precints_points_list"), $("#precints_points_pagination"));
	</script>
<?php endif; ?>