<?php 
function schoolCyclesString(array $cycles) {
	$i = 0;
	$str = '';
	foreach($cycles as $cycle) {
		if ($i > 0) {
			$str .= ', ';
		}

		$str .= $cycle['title'];

		$i++;
	}
	return $str;
}

if (exists($schools['items'])) : ?>
	<div class="pb-4">
		<div id="schools_points_list" class="row gx-2 gy-2 points_list" data-pagination-page_limit="12"  data-pagination-start_page="1" data-pagination-margin2edges="2" data-pagination-margin2current="1">
			
			<?php foreach($schools['items'] as $school) : ?>
			<div class="col-md-6 col-lg-4 col-xxl-3">
				<a href="<?= $school['url'] ?>">
					<div class="point_card">
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
		<div id="schools_points_pagination" class="view_more_wrap mt-2"></div>
	</div>

	<script type="text/javascript" src="<?= $site['baseURL'] ?>/assets/themes/localidades/js/pagination.js"></script>
	<script type="text/javascript" defer>
		const schoolsPagination = new Pagination('schoolsPagination', $("#schools_points_list"), $("#schools_points_pagination"));
	</script>
<?php endif; ?>