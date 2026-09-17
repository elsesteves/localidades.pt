<?php
	include __DIR__."/../inc/breadcrumbs.php";
?>

<div class="container-fluid mb-3">
	<div class="row">
		<?php include __DIR__."/sidebar.php"; ?>
		<div id="region_main" class="col-lg-9 col-md-7 sticky-col">

			<div class="pb-4">
				<h2 class="section_title main"><?= $farmacia['title'] ?></h2>

				<?php if(exists($farmacia['address'])) : ?>
				<p>
					<b><?= \Lang\Dictionary::get('address') ?>:</b> 
					<span><?= $farmacia['address'] ?></span>
				</p>
				<?php endif; ?>

				<?php if(exists($farmacia['zip_code'])) : ?>
				<p>
					<b><?= \Lang\Dictionary::get('zip_code') ?>:</b> 
					<span><?= $farmacia['zip_code'] ?></span>
				</p>
				<?php endif; ?>

				<?php if(exists($farmacia['freguesia'])) : ?>
				<p>
					<b><?= \Lang\Dictionary::get('parish') ?>:</b> 
					<span><a href="<?= $farmacia['freguesia']['url'] ?>"><?= $farmacia['freguesia']['title'] ?></a></span>
				</p>
				<?php endif; ?>

				<?php if(exists($farmacia['concelho'])) : ?>
				<p>
					<b><?= \Lang\Dictionary::get('municipality') ?>:</b> 
					<span><a href="<?= $farmacia['concelho']['url'] ?>"><?= $farmacia['concelho']['title'] ?></a></span>
				</p>
				<?php endif; ?>

				<?php if(exists($farmacia['distrito'])) : ?>
				<p>
					<b><?= \Lang\Dictionary::get('district') ?>:</b> 
					<span><a href="<?= $farmacia['distrito']['url'] ?>"><?= $farmacia['distrito']['title'] ?></a></span>
				</p>
				<?php endif; ?>

				<?php include __DIR__."/../inc/map.php"; ?>

				<?php if(exists($farmacia['emails']) || exists($farmacia['phones'])) : ?>
					<h2 class="section_title"><?= \Lang\Dictionary::get('contacts') ?></h2>

					<?php if(exists($farmacia['emails'])) : ?>
					<p>
						<b><?= \Lang\Dictionary::get('contact_emails') ?>:</b> 
						<span><?= stdEmailListString($farmacia['emails']) ?></span>
					</p>
					<?php endif; ?>

					<?php if(exists($farmacia['phones'])) : ?>
					<p>
						<b><?= \Lang\Dictionary::get('contact_phones') ?>:</b> 
						<span><?= stdPhoneListString($farmacia['phones']) ?></span>
					</p>
					<?php endif; ?>
				<?php endif; ?>
				
			</div>

		</div>
	</div>
</div>