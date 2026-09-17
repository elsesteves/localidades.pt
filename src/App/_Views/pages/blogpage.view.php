<section class="wrapper style-bg1 fade-up">
	<div id="breadcrumbs" class="inner">
		<a href="<?= $baseURL ?>"><?= $site['name'] ?></a> >
		<span class="active"><?= $blog['page']['title'] ?></span>
	</div>
</section>

<section id="blog_page" class="wrapper style-bg1 fade-up">
    <div class="inner">
      <h2><?= $blog['page']['title'] ?></h2>
      <?php if(exists($blog['page']['page'])) : ?>  
				<?= $blog['page']['page'] ?>
      <?php endif; ?>
      <?php if(!empty($blog['images'])) : ?>
      	<div class="gallery">
      		<?php foreach($blog['images'] as $img) : ?>
      			<a href="<?= $site['baseURL'] . '/'. $img['image_full'] ?>" class="js-smartPhoto" data-caption="<?= $img['caption'] ?>" data-id="<?= $img['id'] ?>" data-group="gallery"/>
	      			<div class="gallery_item">
		      			<img src="<?= $site['baseURL'] . '/'. $img['image_thumb'] ?>" title="<?= $img['caption'] ?>" alt="<?= $img['caption'] ?>">
		      		</div>
		      	</a>
      		<?php endforeach; ?>
      	</div>
      <?php endif; ?>

      <div id="share_wrap">
      	<h3><?= \Lang\Dictionary::get('share_social_media') ?></h3>
	      <ul class="icons">
		    	<?php 
			    	$shareLinks = \SocialNetwork::shareLinks();
			    	foreach($shareLinks as $network => $shareLink) {
			    		$networkInfo = \SocialNetwork::$networks[$network];
			    		?>
			    		<li>
		            <a href="<?= $shareLink ?>" target="_blank" class="icon brands fa-<?= $networkInfo['icon'] ?>">
		              <span class="label"><?= $networkInfo['name'] ?></span>
		            </a>
		          </li>
			    		<?php
			    	}
		    	?>
		    </ul>
		  </div>

    </div>

</section>

<?php require __DIR__ .'/includes/contacts/form.view.php'; ?>