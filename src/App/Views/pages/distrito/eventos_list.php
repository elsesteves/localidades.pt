<?php
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
?>

<div class="pb-4">
	<h2 class="section_title"><?= \Lang\Dictionary::getReplaced('events_next') ?></h2>
	<div class="row gx-2 gy-2 points_list">
		<?php foreach($events['items'] as $item) : ?>

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

	<div class="view_more_wrap mt-2">
		<a href="<?= $distrito['url']."/".\Lang\Dictionary::get('urlparam_events') ?>" class="view_more_btn"><?= \Lang\Dictionary::get('view_more') ?></a>
	</div>
</div>