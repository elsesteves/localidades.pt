<div class="col-lg-3 col-md-5 sticky-col bs-component">
	<div id="region-sidebar" class="card sidebar-relevant">
		<h6 class="card-header"><?= \Lang\Dictionary::get('other_schools_that_may_interest_you') ?></h6>

		<div class="card-body">

			<div class="accordion" id="relevant-sidebar-sections-wrap">

			<?php if(exists($sidebar['grouping_schools']['items'])) : ?>
				<?php $groupingShowed = true; ?>
			  <div class="accordion-item">
			    <h6 class="accordion-header" id="relevant-sidebar-section-groupingHeader">
			      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#relevant-sidebar-section-groupingCollapse" aria-expanded="true" aria-controls="relevant-sidebar-section-groupingCollapse">
			        <div><?= \Lang\Dictionary::get('schools_from_grouping') ?></div>
			      </button>
			    </h6>
			    <div id="relevant-sidebar-section-groupingCollapse" class="accordion-collapse collapse show" aria-labelledby="relevant-sidebar-section-groupingHeader">

			      <div class="accordion-body">
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
			<?php endif; ?>

			<?php if(exists($sidebar['grouping_schools']['items'])) : ?>
			  <div class="accordion-item">
			    <h6 class="accordion-header" id="relevant-sidebar-section-parishHeader">
			      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#relevant-sidebar-section-parishCollapse" aria-expanded="<?= $groupingShowed ? 'false' : 'true' ?>" aria-controls="relevant-sidebar-section-parishCollapse">
			        <div>
				        <?= \Lang\Dictionary::get('schools_from') . ' ' . $escola['freguesia']['title'] ?>
				        <?php if(exists($escola['cycles'])) : ?>
				        <br><small>(<?= schoolCyclesString($escola['cycles']) ?>)</small>
				        <?php endif; ?>
			        </div>
					
			      </button>
			    </h6>
			    <div id="relevant-sidebar-section-parishCollapse" class="accordion-collapse collapse <?= $groupingShowed ? '' : 'show' ?>" aria-labelledby="relevant-sidebar-section-parishHeader">

			      <div class="accordion-body">
			      	<div id="sidebar_parish_schools_list" data-pagination-page_limit="8" data-pagination-start_page="1" data-pagination-margin2edges="2" data-pagination-margin2current="1">
			        <?php foreach($sidebar['parish_schools']['items'] as $school) : ?>
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
									</div>
								</div>
							</a>
						</div>
					<?php endforeach; ?>
					</div>
					<div id="sidebar_parish_schools_pagination" class="view_more_wrap"></div>
			      </div>

			    </div>
			  </div>
		  	<?php endif; ?>

			</div>

		</div>
	</div>

</div>

<script type="text/javascript" src="<?= $site['baseURL'] ?>/assets/themes/localidades/js/pagination.js"></script>
<script type="text/javascript" defer>	
	<?php if(exists($sidebar['grouping_schools']['items'])) : ?>
	const groupingSchools = new Pagination('groupingSchools', $("#sidebar_grouping_schools_list"), $("#sidebar_grouping_schools_pagination"));
	<?php endif; ?>

	<?php if(exists($sidebar['parish_schools']['items'])) : ?>
	const parishSchools = new Pagination('parishSchools', $("#sidebar_parish_schools_list"), $("#sidebar_parish_schools_pagination"));
	<?php endif; ?>
</script>