<div class="col-lg-3 col-md-5 sticky-col bs-component">
	<div id="region-sidebar" class="card">
		<h6 class="card-header"><?= \Lang\Dictionary::get('other_healthcare_units_that_may_interest_you') ?></h6>

		<div class="card-body">

			<div class="accordion" id="schools-sidebar-sections-wrap">

			<?php if(exists($sidebar['grouping_units']['items'])) : ?>
				<?php $groupingShowed = true; ?>
			  <div class="accordion-item">
			    <h6 class="accordion-header" id="schools-sidebar-section-groupingHeader">
			      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#schools-sidebar-section-groupingCollapse" aria-expanded="true" aria-controls="schools-sidebar-section-groupingCollapse">
			        <div><?= \Lang\Dictionary::get('healthcare_units_from_grouping') ?></div>
			      </button>
			    </h6>
			    <div id="schools-sidebar-section-groupingCollapse" class="accordion-collapse collapse show" aria-labelledby="schools-sidebar-section-groupingHeader">

			      <div class="accordion-body">
			      	<div id="sidebar_grouping_units_list" data-pagination-page_limit="8" data-pagination-start_page="1" data-pagination-margin2edges="2" data-pagination-margin2current="1">
			      	<?php foreach($sidebar['grouping_units']['items'] as $unit) : ?>
						<div class="col-12">
							<a href="<?= $unit['url'] ?>">
								<div class="school_card">
									<div class="img_wrap">
										<div class="school_img" style="background-image: none;"></div>
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
			<?php endif; ?>

			  <div class="accordion-item">
			    <h6 class="accordion-header" id="schools-sidebar-section-parishHeader">
			      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#schools-sidebar-section-parishCollapse" aria-expanded="<?= $groupingShowed ? 'false' : 'true' ?>" aria-controls="schools-sidebar-section-parishCollapse">
			        <div>
				        <?= \Lang\Dictionary::get('healthcare_units_from') . ' ' . $unidade['concelho']['title'] ?>
			        </div>					
			      </button>
			    </h6>
			    <div id="schools-sidebar-section-parishCollapse" class="accordion-collapse collapse <?= $groupingShowed ? '' : 'show' ?>" aria-labelledby="schools-sidebar-section-parishHeader">
			      
			      <div class="accordion-body">
			      	<div id="sidebar_municipality_units_list" data-pagination-page_limit="8" data-pagination-start_page="1" data-pagination-margin2edges="2" data-pagination-margin2current="1">
			        <?php foreach($sidebar['municipality_units']['items'] as $unit) : ?>
						<div class="col-12">
							<a href="<?= $unit['url'] ?>">
								<div class="school_card">
									<div class="img_wrap">
										<div class="school_img" style="background-image: none;"></div>
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
					<div id="sidebar_municipality_units_pagination" class="view_more_wrap"></div>
			      </div>

			    </div>
			  </div>

			</div>

		</div>
	</div>

</div>



<script type="text/javascript" src="<?= $site['baseURL'] ?>/assets/themes/localidades/js/pagination.js"></script>
<script type="text/javascript" defer>
	const municipalityUnits = new Pagination('municipalityUnits', $("#sidebar_municipality_units_list"), $("#sidebar_municipality_units_pagination"));
	<?php if(exists($sidebar['grouping_units']['items'])) : ?>
		const groupingUnits = new Pagination('groupingUnits', $("#sidebar_grouping_units_list"), $("#sidebar_grouping_units_pagination"));
	<?php endif; ?>
</script>