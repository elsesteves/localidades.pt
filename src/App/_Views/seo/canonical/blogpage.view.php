<?php
	$title = $blog['page']['title'];
	$canonical_url = $site['domain'] . $site['baseURL'] . '/';
	$canonical_url .= $pageLang . '/blog/' . $blog['page']['id'] . '/' . \Data\Str::permalink_clean($title);
?>

<link rel="canonical" href="<?= $canonical_url ?>">