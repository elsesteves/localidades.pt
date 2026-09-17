<?php
	include __DIR__."/../inc/breadcrumbs.php";
?>

<div class="container-fluid mb-3">
	<div class="row">
		<?php include __DIR__."/sidebar.php"; ?>
		<div id="region_main" class="col-lg-9 col-md-7 sticky-col">

			<div class="pb-4">
				<h2 class="section_title main"><?= $unidade['title'] ?></h2>

				<?php if(exists($unidade['grouping'])) : ?>
				<p>
					<b><?= \Lang\Dictionary::get('healthcenter_grouping') ?>:</b> 
					<a href="<?= $unidade['grouping']['url'] ?>"><span><?= $unidade['grouping']['title'] ?></span></a>
				</p>
				<?php endif; ?>


				<?php if(exists($unidade['address'])) : ?>
				<p>
					<b><?= \Lang\Dictionary::get('address') ?>:</b> 
					<span><?= $unidade['address'] ?></span>
				</p>
				<?php endif; ?>

				<?php if(exists($unidade['zip_code'])) : ?>
				<p>
					<b><?= \Lang\Dictionary::get('zip_code') ?>:</b> 
					<span><?= $unidade['zip_code'] ?></span>
				</p>
				<?php endif; ?>

				<?php if(exists($unidade['freguesia'])) : ?>
				<p>
					<b><?= \Lang\Dictionary::get('parish') ?>:</b> 
					<span><a href="<?= $unidade['freguesia']['url'] ?>"><?= $unidade['freguesia']['title'] ?></a></span>
				</p>
				<?php endif; ?>

				<?php if(exists($unidade['concelho'])) : ?>
				<p>
					<b><?= \Lang\Dictionary::get('municipality') ?>:</b> 
					<span><a href="<?= $unidade['concelho']['url'] ?>"><?= $unidade['concelho']['title'] ?></a></span>
				</p>
				<?php endif; ?>

				<?php if(exists($unidade['distrito'])) : ?>
				<p>
					<b><?= \Lang\Dictionary::get('district') ?>:</b> 
					<span><a href="<?= $unidade['distrito']['url'] ?>"><?= $unidade['distrito']['title'] ?></a></span>
				</p>
				<?php endif; ?>

				<?php include __DIR__."/../inc/map.php"; ?>

				<?php if(exists($unidade['emails']) || exists($unidade['phones'])) : ?>
					<h2 class="section_title"><?= \Lang\Dictionary::get('contacts') ?></h2>

					<?php if(exists($unidade['emails'])) : ?>
					<p>
						<b><?= \Lang\Dictionary::get('contact_emails') ?>:</b> 
						<span><?= stdEmailListString($unidade['emails']) ?></span>
					</p>
					<?php endif; ?>

					<?php if(exists($unidade['phones'])) : ?>
					<p>
						<b><?= \Lang\Dictionary::get('contact_phones') ?>:</b> 
						<span><?= stdPhoneListString($unidade['phones']) ?></span>
					</p>
					<?php endif; ?>
				<?php endif; ?>
				
			</div>

		</div>
	</div>
</div>