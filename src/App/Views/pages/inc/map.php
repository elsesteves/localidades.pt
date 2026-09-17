<?php if (exists($map['gps']['lat']) && exists($map['gps']['lon']) && exists($map['gps']['z'])) : ?>
<div class="pb-4">
	<?php if(exists($showMapTitle)) : ?>
	<h2 class="section_title"><?php 
		if(exists($map['title'])) {
			echo $map['title'];
		} else {
			echo \Lang\Dictionary::get('map');
		}
	?></h2>
	<?php endif; ?>
	<div id="region_map_wrap">
		<iframe id="map" class="map" frameborder="0" src="<?= $site['baseURL'] ?>/<?= $pageLang ?>/tools/maps?lat=<?= $map['gps']['lat'] ?>&lon=<?= $map['gps']['lon'] ?>&z=<?= $map['gps']['z'] ?>"></iframe>
	</div>
</div>

	<?php if (exists($map['points'])) : ?>
	<script type="text/javascript">
		window.onload = function() {
			var locations = <?php print json_encode($map['points']); ?>;

			var mapData = {};
		    mapData.locations = locations;

		    mapData = JSON.stringify(mapData);

		    document.getElementById('map').contentWindow.postMessage(mapData);
		};
	</script>
	<?php endif; ?>

<?php else: ?>
<div class="pb-4">
	<div class="map_unavailable text-center"><?= \Lang\Dictionary::get('map_unavailable') ?></div>
</div>
<?php endif; ?>