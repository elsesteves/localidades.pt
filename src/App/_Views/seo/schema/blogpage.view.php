<script type="application/ld+json">
	{
	"@context": "http://schema.org",
	"@type": "BlogPosting",
	"mainEntityOfPage":{
		"@type":"WebPage",
		"@id":"<?= $site['domain'] . Request::path() ?>"
	},
	"headline": "<?= $blog['page']['title'] ?>",
	<?php if(!empty($og_image)) : ?>
	"image": {
		"@type": "ImageObject",
		"url": "<?= $og_image ?>"
	},
	<?php endif; ?>
	"description": "<?= $blog['page']['description'] ?>",
	"articleBody": "<?= str_replace(array("\r", "\n"), '', strip_tags($blog['page']['page'])) ?>"
	}
</script>