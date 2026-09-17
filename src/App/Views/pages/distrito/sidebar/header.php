<h6 class="card-header">
	<div id="region_banner_wrap" style="width: 100%;">
		<div id="region_banner" <?php if(exists($distrito['img']['background'])) : ?>
		data-bg="<?= $distrito['img']['background'] ?>"
		<?php endif; ?> style=""></div>
		<div class="region_name"><?= \Lang\Dictionary::getReplaced("district_of", array("district" => $distrito['title'])) ?></div>
	</div>
</h6>