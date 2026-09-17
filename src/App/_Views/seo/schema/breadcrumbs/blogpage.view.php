<script type="application/ld+json">
	{
		"@context": "https://schema.org",
		"@type": "BreadcrumbList",
		"itemListElement": [
			{
				"@type": "ListItem",
				"position": 1,
				"item": {
					"@id": "<?= $site['domain'] . $site['baseURL'] ?>",
					"name": "<?= $site['name'] ?>"
				}
			}, 
			{
				"@type": "ListItem",
				"position": 2,
				"item": {
					"@id": "<?= $site['domain'] . Request::path() ?>",
					"name": "<?= $blog['page']['title'] ?>"
				}
			}
		]
	}
</script>