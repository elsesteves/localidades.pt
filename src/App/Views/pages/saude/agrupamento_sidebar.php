<div class="col-lg-3 col-md-5 sticky-col bs-component">
	<div id="region-sidebar" class="card sidebar-relevant">
		<h6 class="card-header"><?= \Lang\Dictionary::get('healthcare_units_from_grouping') ?></h6>

		<div class="card-body">

			<div id="sidebar_grouping_units_list" data-pagination-page_limit="8" data-pagination-start_page="1" data-pagination-margin2edges="2" data-pagination-margin2current="1">
			<?php foreach($sidebar['grouping_units']['items'] as $unit) : ?>
				<div class="col-12">
					<a href="<?= $unit['url'] ?>">
						<div class="relevant_card">
							<div class="img_wrap">
								<div class="img" style="background-image: none;"></div>
							</div>
							<div class="info">
								<div class="title"><?= $unit['title'] ?></div>
								<div class="address"><?= $unit['address'] ?></div>
								<?php if(exists($unit['freguesia'])) : ?>										
								<div class="freguesia"><?= $unit['freguesia']['title'] ?></div>
								<?php endif; ?>
							</div>
						</div>
					</a>
				</div>
			<?php endforeach; ?>
			</div>
			<div id="sidebar_grouping_units_pagination" class="view_more_wrap"></div>

		</div>
	</div>

</div>

<script type="text/javascript" src="<?= $site['baseURL'] ?>/assets/themes/localidades/js/pagination.js"></script>
<script type="text/javascript" defer>
	const groupingUnits = new Pagination('groupingUnits', $("#sidebar_grouping_units_list"), $("#sidebar_grouping_units_pagination"));
</script>