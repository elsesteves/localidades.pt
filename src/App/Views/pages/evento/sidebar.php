<div class="col-lg-3 col-md-5 sticky-col bs-component">
	<div id="region-sidebar" class="card sidebar-relevant">
		<h6 class="card-header"><?= \Lang\Dictionary::get('other_events_that_may_interest_you') ?></h6>

		<div class="card-body">

			<div class="accordion" id="relevant-sidebar-sections-wrap">

			<?php if(exists($sidebar['municipality_events']['items'])) : ?>
			<?php $groupingShowed = false; ?>
			  <div class="accordion-item">
			    <h6 class="accordion-header" id="relevant-sidebar-section-parishHeader">
			      <button class="accordion-button <?= $groupingShowed ? 'collapsed' : '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#relevant-sidebar-section-parishCollapse" aria-expanded="<?= $groupingShowed ? 'false' : 'true' ?>" aria-controls="relevant-sidebar-section-parishCollapse">
			        <div>
				        <?= \Lang\Dictionary::get('events_from') . ' ' . $item['concelho']['title'] ?>
			        </div>					
			      </button>
			    </h6>
			    <div id="relevant-sidebar-section-parishCollapse" class="accordion-collapse collapse <?= $groupingShowed ? '' : 'show' ?>" aria-labelledby="relevant-sidebar-section-parishHeader">

			      <div class="accordion-body">
			      	<div id="sidebar_municipality_events_list" data-pagination-page_limit="8" data-pagination-start_page="1" data-pagination-margin2edges="2" data-pagination-margin2current="1">
			        <?php foreach($sidebar['municipality_events']['items'] as $sidebarItem) : ?>
						<div class="col-12">
							<a href="<?= $sidebarItem['url'] ?>">
								<div class="relevant_card">
									<?php if (exists($sidebarItem['image']['background'])) : ?>
										<div class="img_wrap show">
											<div class="img" data-bg="<?= $sidebarItem['image']['background'] ?>"></div>
										</div>
									<?php else: ?>
										<div class="img_wrap">
											<div class="img" style="background-image: none;"></div>
										</div>
									<?php endif; ?>
									<div class="info">
										<div class="title"><?= $sidebarItem['title'] ?></div>

										<div class="cycles"><?= eventTypesString($sidebarItem['types']) ?></div>

										<?php if(exists($sidebarItem['dates'])) : ?>
										<div class="cycles">
											<?= $sidebarItem['dates']['start']['formatted'] ?>
											<?php if (exists($sidebarItem['dates']['end']['formatted']) && $sidebarItem['dates']['end']['show']) : ?>
												<?= ' - ' . $sidebarItem['dates']['end']['formatted'] ?>
											<?php endif; ?>												
										</div>
										<?php endif; ?>

										<?php if(exists($sidebarItem['address'])) : ?>
										<div class="address"><?= $sidebarItem['address'] ?></div>
										<?php endif; ?>
										
										<?php if(exists($sidebarItem['freguesia'])) : ?>										
										<div class="freguesia"><?= $sidebarItem['freguesia']['title'] ?></div>
										<?php endif; ?>
									</div>
								</div>
							</a>
						</div>
					<?php endforeach; ?>
					</div>
					<div id="sidebar_municipality_events_pagination" class="view_more_wrap"></div>
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
	const municipalityEvents = new Pagination('municipalityEvents', $("#sidebar_municipality_events_list"), $("#sidebar_municipality_events_pagination"));
</script>