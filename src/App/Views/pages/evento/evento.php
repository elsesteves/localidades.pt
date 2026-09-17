<?php
	include __DIR__."/../inc/breadcrumbs.php";

	function eventTypesString(array $types, $withLink = false) {
		$searchURL = SITE_CONFIGS['info']['baseURL'] .'/'. \Lang\Lang::fetchCurrentLangRef() .'/'. \Lang\Dictionary::get('urlparam_events');
		$typeArr = [];

		foreach($types as $type) {
			$item = '';

			if ($withLink) {
				//$url = $type['url'];
				$url = $searchURL."?id_tipo=".$type['id'];
				$item .= '<a href="'.$url.'" title="'.$type['title'].'">';
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

<div class="container-fluid mb-3">
	<div class="row">
		<?php include __DIR__."/sidebar.php"; ?>
		<div id="region_main" class="col-lg-9 col-md-7 sticky-col">

			<div class="pb-4">
				<h2 class="section_title main"><?= $item['title'] ?></h2>

				<?php if(exists($item['image']['background'])) : ?>
					<div class="img_wrap mb-4">
						<img src="<?= $item['image']['background'] ?>">
					</div>
				<?php endif; ?>

				<?php if(exists($item['types'])) : ?>
					<p>
						<b><?= \Lang\Dictionary::get('event_types') ?>:</b> 
						<span><?= eventTypesString($item['types'], true) ?></span>
					</p>
				<?php endif; ?>

				<?php if(exists($item['dates']['start'])) : ?>
					<p>
						<b><?= \Lang\Dictionary::get('event_start_date') ?>:</b> 
						<span><?= $item['dates']['start']['formatted'] ?></span>
					</p>
				<?php endif; ?>

				<?php if(exists($item['dates']['end']) && $item['dates']['end']['show']) : ?>
					<p>
						<b><?= \Lang\Dictionary::get('event_end_date') ?>:</b> 
						<span><?= $item['dates']['end']['formatted'] ?></span>
					</p>
				<?php endif; ?>

				<?php if(exists($item['address'])) : ?>
				<p>
					<b><?= \Lang\Dictionary::get('address') ?>:</b> 
					<span><?= $item['address'] ?></span>
				</p>
				<?php endif; ?>

				<?php if(exists($item['zip_code'])) : ?>
				<p>
					<b><?= \Lang\Dictionary::get('zip_code') ?>:</b> 
					<span><?= $item['zip_code'] ?></span>
				</p>
				<?php endif; ?>

				<?php if(exists($item['freguesia'])) : ?>
				<p>
					<b><?= \Lang\Dictionary::get('parish') ?>:</b> 
					<span><a href="<?= $item['freguesia']['url'] ?>"><?= $item['freguesia']['title'] ?></a></span>
				</p>
				<?php endif; ?>

				<?php if(exists($item['concelho'])) : ?>
				<p>
					<b><?= \Lang\Dictionary::get('municipality') ?>:</b> 
					<span><a href="<?= $item['concelho']['url'] ?>"><?= $item['concelho']['title'] ?></a></span>
				</p>
				<?php endif; ?>

				<?php if(exists($item['distrito'])) : ?>
				<p>
					<b><?= \Lang\Dictionary::get('district') ?>:</b> 
					<span><a href="<?= $item['distrito']['url'] ?>"><?= $item['distrito']['title'] ?></a></span>
				</p>
				<?php endif; ?>

				<?php include __DIR__."/../inc/map.php"; ?>

				<?php if(exists($item['emails']) || exists($item['phones'])) : ?>
					<h2 class="section_title"><?= \Lang\Dictionary::get('contacts') ?></h2>

					<?php if(exists($item['emails'])) : ?>
					<p>
						<b><?= \Lang\Dictionary::get('contact_emails') ?>:</b> 
						<span><?= stdEmailListString($item['emails']) ?></span>
					</p>
					<?php endif; ?>

					<?php if(exists($item['phones'])) : ?>
					<p>
						<b><?= \Lang\Dictionary::get('contact_phones') ?>:</b> 
						<span><?= stdPhoneListString($item['phones']) ?></span>
					</p>
					<?php endif; ?>
				<?php endif; ?>

				<?php if(exists($item['description'])) : ?>
				<p>
					<b><?= \Lang\Dictionary::get('description') ?>:</b> 
					<div><?= nl2br($item['description']) ?></div>
				</p>
				<?php endif; ?>
				
			</div>

		</div>
	</div>
</div>