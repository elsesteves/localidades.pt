<?php
	header('Content-type: application/xml');
?>
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<?php foreach ($links as $link) : ?>
	<url>
		<loc><?= $site['domain'] . $site['baseURL'] . $link['url'] ?></loc>
		<?php if(exists($link['lastmod'])) : ?>
		<lastmod><?= $link['lastmod'] ?></lastmod>
		<?php endif; ?>
		<?php if(exists($link['priority'])) : ?>
		<priority><?= $link['priority'] ?></priority>
		<?php endif; ?>
	</url>
	<?php endforeach; ?>
</urlset>