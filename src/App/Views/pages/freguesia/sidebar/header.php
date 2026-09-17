<h6 class="card-header">
	<div id="region_banner_wrap" style="width: 100%;">
		<div id="region_banner" <?php if(exists($freguesia['img']['background'])) : ?>
		data-bg="<?= $freguesia['img']['background'] ?>"
		<?php endif; ?> style=""></div>
		<div class="region_name"><?= \Lang\Dictionary::getReplaced("parish_of", array("parish" => $freguesia['title'])) ?></div>
	</div>
</h6>