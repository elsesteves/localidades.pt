<?php if (exists($healthcare_units['items'])) : ?>
	<div class="pb-4">
		<div id="healthcare_points_list" class="row gx-2 gy-2 points_list" data-pagination-page_limit="12"  data-pagination-start_page="1" data-pagination-margin2edges="2" data-pagination-margin2current="1">

			<?php foreach($healthcare_units['items'] as $healthcare_unit) : ?>
				<div class="col-md-6 col-lg-4 col-xxl-3">
				<a href="<?= $healthcare_unit['url'] ?>">
					<div class="point_card">
						<div class="img_wrap">
							<div class="img" style="background-image: none;"></div>
						</div>
						<div class="info">
							<div class="title"><?= $healthcare_unit['title'] ?></div>
							<div class="address"><?= $healthcare_unit['address'] ?></div>
							
							<?php if(exists($healthcare_unit['freguesia'])) : ?>
							<div class="freguesia"><?= $healthcare_unit['freguesia']['title'] ?></div>
							<?php endif; ?>
						</div>
					</div>
				</a>
			</div>
			<?php endforeach; ?>
			
		</div>
		<div id="healthcare_points_pagination" class="view_more_wrap mt-2"></div>
	</div>

	<script type="text/javascript" src="<?= $site['baseURL'] ?>/assets/themes/localidades/js/pagination.js"></script>
	<script type="text/javascript" defer>
		const healthcarePagination = new Pagination('healthcarePagination', $("#healthcare_points_list"), $("#healthcare_points_pagination"));
	</script>
<?php endif; ?>