<?php
	include __DIR__."/../inc/breadcrumbs.php";

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
?>

<div class="container-fluid mb-3">
	<div class="row">
		<?php include __DIR__."/sidebar.php"; ?>
		<div id="region_main" class="col-lg-9 col-md-7 sticky-col">

			<div class="pb-4">
				<h2 class="section_title"><?= $escola['title'] ?></h2>

				<?php if(exists($escola['codigo_escola'])) : ?>
				<p>
					<b><?= \Lang\Dictionary::get('codigo_escola') ?>:</b> 
					<span><?= $escola['codigo_escola'] ?></span>
				</p>
				<?php endif; ?>

				<?php if(exists($escola['grouping'])) : ?>
				<p>
					<b><?= \Lang\Dictionary::get('school_grouping') ?>:</b> 
					<a href="<?= $escola['grouping']['url'] ?>"><span><?= $escola['grouping']['title'] ?></span></a>
				</p>
				<?php endif; ?>


				<?php if(exists($escola['cycles'])) : ?>
				<p>
					<b><?= \Lang\Dictionary::get('school_cycles') ?>:</b> 
					<span><?= schoolCyclesString($escola['cycles']) ?></span>
				</p>
				<?php endif; ?>

				<?php if(exists($escola['address'])) : ?>
				<p>
					<b><?= \Lang\Dictionary::get('address') ?>:</b> 
					<span><?= $escola['address'] ?></span>
				</p>
				<?php endif; ?>

				<?php if(exists($escola['zip_code'])) : ?>
				<p>
					<b><?= \Lang\Dictionary::get('zip_code') ?>:</b> 
					<span><?= $escola['zip_code'] ?></span>
				</p>
				<?php endif; ?>

				<?php if(exists($escola['freguesia'])) : ?>
				<p>
					<b><?= \Lang\Dictionary::get('parish') ?>:</b> 
					<span><a href="<?= $escola['freguesia']['url'] ?>"><?= $escola['freguesia']['title'] ?></a></span>
				</p>
				<?php endif; ?>

				<?php if(exists($escola['concelho'])) : ?>
				<p>
					<b><?= \Lang\Dictionary::get('municipality') ?>:</b> 
					<span><a href="<?= $escola['concelho']['url'] ?>"><?= $escola['concelho']['title'] ?></a></span>
				</p>
				<?php endif; ?>

				<?php if(exists($escola['distrito'])) : ?>
				<p>
					<b><?= \Lang\Dictionary::get('district') ?>:</b> 
					<span><a href="<?= $escola['distrito']['url'] ?>"><?= $escola['distrito']['title'] ?></a></span>
				</p>
				<?php endif; ?>

				<?php include __DIR__."/../inc/map.php"; ?>


				<?php if(exists($escola['ext_url']) || exists($escola['emails']) || exists($escola['phones'])) : ?>
					<h2 class="section_title"><?= \Lang\Dictionary::get('contacts') ?></h2>
					
					<?php if(exists($escola['ext_url'])) : ?>
					<p>
						<b><?= \Lang\Dictionary::get('label_website') ?>:</b> 
						<span><a target="_blank" href="<?= $escola['ext_url'] ?>"><?= $escola['ext_url'] ?></a></span>
					</p>
					<?php endif; ?>

					<?php if(exists($escola['emails'])) : ?>
					<p>
						<b><?= \Lang\Dictionary::get('contact_emails') ?>:</b> 
						<span><?= stdEmailListString($escola['emails']) ?></span>
					</p>
					<?php endif; ?>

					<?php if(exists($escola['phones'])) : ?>
					<p>
						<b><?= \Lang\Dictionary::get('contact_phones') ?>:</b> 
						<span><?= stdPhoneListString($escola['phones']) ?></span>
					</p>
					<?php endif; ?>
				<?php endif; ?>
				
			</div>

		</div>
	</div>
</div>