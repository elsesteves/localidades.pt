<div class="col-lg-3 col-md-5 sticky-col bs-component">
	<div id="region-sidebar" class="card sidebar-relevant">
		<h6 class="card-header"><?= \Lang\Dictionary::get('other_police_precints_that_may_interest_you') ?></h6>

		<div class="card-body">

			<div class="accordion" id="relevant-sidebar-sections-wrap">

			<?php $groupingShowed = true; ?>
			  <div class="accordion-item">
			    <h6 class="accordion-header" id="relevant-sidebar-section-parishHeader">
			      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#relevant-sidebar-section-parishCollapse" aria-expanded="<?= $groupingShowed ? 'false' : 'true' ?>" aria-controls="relevant-sidebar-section-parishCollapse">
			        <div>
				        <?= \Lang\Dictionary::get('police_precints_from') . ' ' . $esquadra['concelho']['title'] ?>
			        </div>					
			      </button>
			    </h6>
			    <div id="relevant-sidebar-section-parishCollapse" class="accordion-collapse collapse <?= $groupingShowed ? '' : 'show' ?>" aria-labelledby="relevant-sidebar-section-parishHeader">
			      <div class="accordion-body">
			      	<div id="sidebar_municipality_precints_list" data-pagination-page_limit="8" data-pagination-start_page="1" data-pagination-margin2edges="2" data-pagination-margin2current="1">
			        <?php foreach($sidebar['municipality_precints']['items'] as $unit) : ?>
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
					<div id="sidebar_municipality_precints_pagination" class="view_more_wrap"></div>

			      </div>
			    </div>
			  </div>

			</div>

		</div>
	</div>

</div>


<script type="text/javascript" src="<?= $site['baseURL'] ?>/assets/themes/localidades/js/pagination.js"></script>
<script type="text/javascript" defer>
	const municipalityPrecints = new Pagination('municipalityPrecints', $("#sidebar_municipality_precints_list"), $("#sidebar_municipality_precints_pagination"));
</script>