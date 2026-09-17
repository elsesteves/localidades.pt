<script type="application/ld+json">
	{
		"@context": "https://schema.org",
		"@type": "WebPage",
		"name":"<?= $project['info']['title'] ?>",
		"description":"<?= \Data\Str::srcCorrect($project['info']['description']) ?>",
		"image" : "<?= $og_image ? $og_image : '' ?>"
	}
</script>