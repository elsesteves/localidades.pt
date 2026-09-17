<?php
	include __DIR__."/../inc/breadcrumbs.php";
?>

<div class="container-fluid mb-3">
	<div class="row">
		<?php include __DIR__."/agrupamento_sidebar.php"; ?>
		<div id="region_main" class="col-lg-9 col-md-7 sticky-col">

			<div class="pb-4">
				<h2 class="section_title main"><?= $agrupamento['title'] ?></h2>

				<?php if(exists($agrupamento['address'])) : ?>
				<p>
					<b><?= \Lang\Dictionary::get('address') ?>:</b> 
					<span><?= $agrupamento['address'] ?></span>
				</p>
				<?php endif; ?>

				<?php if(exists($agrupamento['zip_code'])) : ?>
				<p>
					<b><?= \Lang\Dictionary::get('zip_code') ?>:</b> 
					<span><?= $agrupamento['zip_code'] ?></span>
				</p>
				<?php endif; ?>

				<?php if(exists($agrupamento['freguesia'])) : ?>
				<p>
					<b><?= \Lang\Dictionary::get('parish') ?>:</b> 
					<span><a href="<?= $agrupamento['freguesia']['url'] ?>"><?= $agrupamento['freguesia']['title'] ?></a></span>
				</p>
				<?php endif; ?>
				

				<?php include __DIR__."/../inc/map.php"; ?>

				<h2 class="section_title"><?= \Lang\Dictionary::get('healthcenter_grouping_resp') ?></h2>
				<div class="row pb-4">
					<?php if(exists($agrupamento['resp']['photo'])) : ?>
					<div class="col-md-2 col-xs-4 col-6">
						<img alt="<?= $agrupamento['resp']['name'] ?>" title="<?= $agrupamento['resp']['name'] ?>" src="<?= $agrupamento['resp']['photo'] ?>" style="width: 100%;">
					</div>
					<div class="col-md-10 col-xs-8 col-6">
					<?php else: ?>
					<div class="pb-4">
					<?php endif; ?>
						<?php if(exists($agrupamento['resp']['name'])) : ?>
						<p>
							<b><?= \Lang\Dictionary::get('healthcenter_grouping_resp_name') ?>:</b> 
							<span><?= $agrupamento['resp']['name'] ?></span>
						</p>
						<?php endif; ?>

						<?php if(exists($agrupamento['resp']['position'])) : ?>
						<p>
							<b><?= \Lang\Dictionary::get('healthcenter_grouping_resp_position') ?>:</b> 
							<span><?= $agrupamento['resp']['position'] ?></span>
						</p>
						<?php endif; ?>
					</div>
				</div>

				<?php if(exists($agrupamento['ext_url']) || exists($unidade['emails']) || exists($unidade['phones'])) : ?>
					<h2 class="section_title"><?= \Lang\Dictionary::get('contacts') ?></h2>

					<?php if(exists($agrupamento['ext_url'])) : ?>
					<p>
						<b><?= \Lang\Dictionary::get('label_website') ?>:</b> 
						<span><a target="_blank" href="<?= $agrupamento['ext_url'] ?>"><?= $agrupamento['ext_url'] ?></a></span>
					</p>
					<?php endif; ?>

					<?php if(exists($agrupamento['emails'])) : ?>
					<p>
						<b><?= \Lang\Dictionary::get('contact_emails') ?>:</b> 
						<span><?= stdEmailListString($agrupamento['emails']) ?></span>
					</p>
					<?php endif; ?>

					<?php if(exists($agrupamento['phones'])) : ?>
					<p>
						<b><?= \Lang\Dictionary::get('contact_phones') ?>:</b> 
						<span><?= stdPhoneListString($agrupamento['phones']) ?></span>
					</p>
					<?php endif; ?>
				<?php endif; ?>
			</div>

		</div>
	</div>
</div>