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
					"@id": "<?= $site['domain'] . $site['baseURL'] ?>/projects",
					"name": "<?= \Lang\Dictionary::get('projects_made') ?>"
				}
			}, 
			{
				"@type": "ListItem",
				"position": 3,
				"item": {
					"@id": "<?= $site['domain'] . Request::path() ?>",
					"name": "<?= $project['info']['title'] ?>"
				}
			}
		]
	}
</script>