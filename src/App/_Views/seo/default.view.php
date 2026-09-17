<?php
	if(exists($seo['opengraph']['image']['image_full'])) {
		$og_image = $site['domain'].$site['baseURL'].'/'.$seo['opengraph']['image']['image_full'];
	} elseif(exists($siteInfo['seo']['opengraph']['image']['image_full'])) {
		$og_image = $site['domain'].$site['baseURL'].'/'.$siteInfo['seo']['opengraph']['image']['image_full'];
	}

	if (file_exists(__DIR__.'/canonical/'.$page.'.view.php')) {
    	require_once __DIR__.'/canonical/'.$page.'.view.php';
	}
?>

<!-- Open Graph Data -->
<meta property="og:site_name" content="<?= $siteInfo['title'] ?>">
<meta property="og:type" content="website">
<meta property="og:url" content="<?= $site['domain'] . Request::path() ?>"/>
<meta property="og:title" content="<?= $siteInfo['seo']['title'] ?>">
<meta property="og:description" content="<?= $siteInfo['seo']['description'] ?>">
<?php if(exists($og_image)) : ?>
<meta property="og:image" content="<?= $og_image ?>">
<?php endif; ?>

<!-- Twitter Card Data -->
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="<?= $siteInfo['seo']['title'] ?>">
<meta name="twitter:description" content="<?= $siteInfo['seo']['description'] ?>">
<?php if(exists($og_image)) : ?>
<meta name="twitter:image" content="<?= $og_image ?>">
<?php endif; ?>

<!-- Schema -->
<?php 
	if (file_exists(__DIR__.'/schema/breadcrumbs/'.$page.'.view.php')) {
    	require_once __DIR__.'/schema/breadcrumbs/'.$page.'.view.php';
	}

	if (file_exists(__DIR__.'/schema/'.$page.'.view.php')) {
    	require_once __DIR__.'/schema/'.$page.'.view.php';
	} else {
    	require_once __DIR__.'/schema/default.view.php';
	}
?>