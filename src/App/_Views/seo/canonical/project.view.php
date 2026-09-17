<?php
	$title = $project['info']['title'] ? $project['info']['title'] : $project['info']['name'];
	$canonical_url = $site['domain'] . $site['baseURL'] . '/';
	$canonical_url .= $pageLang . '/projects/' . $project['info']['id'] . '/' . \Data\Str::permalink_clean($title);
?>

<link rel="canonical" href="<?= $canonical_url ?>">