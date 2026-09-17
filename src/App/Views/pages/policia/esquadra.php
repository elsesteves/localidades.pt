<?php
	include __DIR__."/../inc/breadcrumbs.php";
?>

<div class="container-fluid mb-3">
	<div class="row">
		<?php include __DIR__."/sidebar.php"; ?>
		<div id="region_main" class="col-lg-9 col-md-7 sticky-col">

			<div class="pb-4">
				<h2 class="section_title main"><?= $esquadra['title'] ?></h2>

				<?php if(exists($esquadra['address'])) : ?>
				<p>
					<b><?= \Lang\Dictionary::get('address') ?>:</b> 
					<span><?= $esquadra['address'] ?></span>
				</p>
				<?php endif; ?>

				<?php if(exists($esquadra['zip_code'])) : ?>
				<p>
					<b><?= \Lang\Dictionary::get('zip_code') ?>:</b> 
					<span><?= $esquadra['zip_code'] ?></span>
				</p>
				<?php endif; ?>

				<?php if(exists($esquadra['freguesia'])) : ?>
				<p>
					<b><?= \Lang\Dictionary::get('parish') ?>:</b> 
					<span><a href="<?= $esquadra['freguesia']['url'] ?>"><?= $esquadra['freguesia']['title'] ?></a></span>
				</p>
				<?php endif; ?>

				<?php if(exists($esquadra['concelho'])) : ?>
				<p>
					<b><?= \Lang\Dictionary::get('municipality') ?>:</b> 
					<span><a href="<?= $esquadra['concelho']['url'] ?>"><?= $esquadra['concelho']['title'] ?></a></span>
				</p>
				<?php endif; ?>

				<?php if(exists($esquadra['distrito'])) : ?>
				<p>
					<b><?= \Lang\Dictionary::get('district') ?>:</b> 
					<span><a href="<?= $esquadra['distrito']['url'] ?>"><?= $esquadra['distrito']['title'] ?></a></span>
				</p>
				<?php endif; ?>

				<?php include __DIR__."/../inc/map.php"; ?>

				<?php if(exists($esquadra['emails']) || exists($esquadra['phones'])) : ?>
					<h2 class="section_title"><?= \Lang\Dictionary::get('contacts') ?></h2>

					<?php if(exists($esquadra['emails'])) : ?>
					<p>
						<b><?= \Lang\Dictionary::get('contact_emails') ?>:</b> 
						<span><?= stdEmailListString($esquadra['emails']) ?></span>
					</p>
					<?php endif; ?>

					<?php if(exists($esquadra['phones'])) : ?>
					<p>
						<b><?= \Lang\Dictionary::get('contact_phones') ?>:</b> 
						<span><?= stdPhoneListString($esquadra['phones']) ?></span>
					</p>
					<?php endif; ?>
				<?php endif; ?>
				
			</div>

		</div>
	</div>
</div>