<?php 
$mapURL = $site['baseURL'] .'/tools/maps/'.$pageLang;

if (exists($siteInfo['coords']['lat']) && exists($siteInfo['coords']['lng'])) {
  $mapURL .= '?lat='.$siteInfo['coords']['lat'].'&lng='.$siteInfo['coords']['lng'].'&z=17';
}

?>
<iframe id="map" src="<?= $mapURL ?>"></iframe>

<?php 
  if (file_exists(__DIR__.'/scripts/map.view.php')) {
    require_once __DIR__.'/scripts/map.view.php';
  } 
?>