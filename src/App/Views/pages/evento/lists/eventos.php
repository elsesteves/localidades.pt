<?php 

if(!function_exists('eventTypesString')) {
	function eventTypesString(array $types, $withLink = false) {
		$typeArr = [];

		foreach($types as $type) {
			$item = '';

			if ($withLink) {
				$item .= '<a href="'.$type['url'].'" title="'.$type['title'].'">';
			}

			$item .= $type['title'];

			if ($withLink) {
				$item .= '</a>';
			}

			$typeArr[] = $item;
		}

		return implode(', ', $typeArr);
	}
}
?>

<?php if (exists($items['items'])) : ?>
	<div class="pb-4">
		<div id="event_points_list" class="row gx-2 gy-2 points_list" data-pagination-page_limit="12"  data-pagination-start_page="1" data-pagination-margin2edges="2" data-pagination-margin2current="1">

			<?php foreach($items['items'] as $item) : ?>
			<div class="col-md-6 col-lg-4 col-xxl-3">
				<a href="<?= $item['url'] ?>">
					<div class="point_card">
						<?php if (exists($item['image']['background'])) : ?>
							<div class="img_wrap show">
								<div class="img" data-bg="<?= $item['image']['background'] ?>"></div>
							</div>
						<?php else: ?>
							<div class="img_wrap">
								<div class="img" style="background-image: none;"></div>
							</div>
						<?php endif; ?>
						<div class="info">
							<div class="title"><?= $item['title'] ?></div>
							<div class="cycles"><?= eventTypesString($item['types']) ?></div>

							<?php if(exists($item['dates'])) : ?>
							<div class="cycles">
								<?= $item['dates']['start']['formatted'] ?>
								<?php if (exists($item['dates']['end']['formatted']) && $item['dates']['end']['show']) : ?>
									<?= ' - ' . $item['dates']['end']['formatted'] ?>
								<?php endif; ?>												
							</div>
							<?php endif; ?>
						
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
		<div id="event_points_pagination" class="view_more_wrap mt-2"></div>
	</div>

	<script type="text/javascript" src="<?= $site['baseURL'] ?>/assets/themes/localidades/js/pagination.js"></script>
	<script type="text/javascript" defer>
		const eventPagination = new Pagination('eventPagination', $("#event_points_list"), $("#event_points_pagination"));
	</script>
<?php else: ?>
	<div class="pb-4">
		<p><?= \Lang\Dictionary::get('search-no_results') ?></p>
	</div>
<?php endif; ?>
