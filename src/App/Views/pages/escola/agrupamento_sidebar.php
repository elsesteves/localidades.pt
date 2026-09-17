<div class="col-lg-3 col-md-5 sticky-col bs-component">
	<div id="region-sidebar" class="card sidebar-relevant">
		<h6 class="card-header"><?= \Lang\Dictionary::get('schools_from_grouping') ?></h6>

		<div class="card-body">
			<div id="sidebar_grouping_schools_list" data-pagination-page_limit="8" data-pagination-start_page="1" data-pagination-margin2edges="2" data-pagination-margin2current="1">
			<?php foreach($sidebar['grouping_schools']['items'] as $school) : ?>
				<div class="col-12">
					<a href="<?= $school['url'] ?>">
						<div class="relevant_card">
							<div class="img_wrap">
								<div class="img" style="background-image: none;"></div>
							</div>
							<div class="info">
								<div class="title"><?= $school['title'] ?></div>
								<div class="address"><?= $school['address'] ?></div>
								<div class="cycles"><?= schoolCyclesString($school['cycles']) ?></div>
								<?php if(exists($school['freguesia'])) : ?>										
								<div class="freguesia"><?= $school['freguesia']['title'] ?></div>
								<?php endif; ?>
							</div>
						</div>
					</a>
				</div>
			<?php endforeach; ?>
			</div>
			<div id="sidebar_grouping_schools_pagination" class="view_more_wrap"></div>
		</div>

	</div>

</div>

<script type="text/javascript" src="<?= $site['baseURL'] ?>/assets/themes/localidades/js/pagination.js"></script>
<script type="text/javascript" defer>	
	<?php if(exists($sidebar['grouping_schools']['items'])) : ?>
	const groupingSchools = new Pagination('groupingSchools', $("#sidebar_grouping_schools_list"), $("#sidebar_grouping_schools_pagination"));
	<?php endif; ?>
</script>