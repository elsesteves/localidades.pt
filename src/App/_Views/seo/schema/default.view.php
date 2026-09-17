<script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@type": "Organization",
		"name": "<?= $siteInfo['title'] ?>",
		"url": "<?= $site['domain'] . $site['baseURL'] ?>",
		"logo": "<?= $site['domain'] . $site['baseURL'] . $site['logo'] ?>"<?php 
		if(exists($siteInfo['emails'])) : ?>, 
		"email": "mailto:<?= $siteInfo['emails'][0]['email'] ?>"<?php 
		endif; 
		if(exists($siteInfo['phones'])) : ?>, 
		"contactPoint" : [
			<?php foreach ($siteInfo['phones'] as $key => $phone) : ?>
			<?php if($key != 0) : ?>, <?php endif;   
		    ?>{ "@type" : "ContactPoint",
		      "telephone" : "<?= str_replace(array(' ', '(', ')'), array('-', '', ''), $phone['number']['unformatted']) ?>",
		      "contactType" : "<?= $phone['label'] ?>"
		    }
		    <?php endforeach; ?>
		]
		<?php endif; 

		if(exists($siteInfo['social'])) : 
			$sameAsSocialTxt = '';
			?>, 
			"sameAs": [
				<?php foreach ($siteInfo['social'] as $socialID => $social) {
					if(exists($social['network'])) { 
						if ($sameAsSocialTxt != '') {
							$sameAsSocialTxt .= ', ';
						}
						$sameAsSocialTxt .= '"'.$social['url'].'"';
					}
				}

				print $sameAsSocialTxt;
				?>
			]
		<?php endif; ?>
		<?php
		/*
		, "potentialAction": {
			"@type": "SearchAction",
			"target": "https://vention.pt//products.php?search={query}",
			"query": "required"
		}
		*/
		?>
	}
</script>