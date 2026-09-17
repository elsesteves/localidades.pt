<h6 class="card-header">
	<div id="region_banner_wrap" style="width: 100%;">
		<div id="region_banner" <?php if(exists($concelho['img']['background'])) : ?>
		data-bg="<?= $concelho['img']['background'] ?>"
		<?php endif; ?> style=""></div>
		<div class="region_name"><?= \Lang\Dictionary::getReplaced("municipality_of", array("municipality" => $concelho['title'])) ?></div>
	</div>
</h6>