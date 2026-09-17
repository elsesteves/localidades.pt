<section id="solutions" class="wrapper style-bg2 fade-up">
	<div class="inner <?= $page == 'services' ? 'pad-top-short' : '' ?>">
	  <h2><?= $services['page']['title'] ?></h2>
	  <?php if(exists($services['page']['description'])) : ?>
	  	<p><?= nl2br(\Data\Str::srcCorrect($services['page']['description'])) ?></p>
	  <?php endif; ?>
	  <div class="services">
	  	<?php foreach ($services['items'] as $service) : ?>
		    <div class="service-item">
		      <div class="img-item">
	            	<div class="item-inner">
	                	<picture>
		                  <img loading="lazy" src="<?= $site['baseURL'] . '/' . $service['image_full'] ?>" alt="<?= $service['title'] ?>">
	                	</picture>
	            	</div>
          </div>
          <div class="txt-item">
						<h3><?= $service['title'] ?></h3>
						<p><?= nl2br(\Data\Str::srcCorrect($service['description'])) ?></p>
					</div>
		    </div>
	    <?php endforeach; ?>
	  </div>
	  <?php /* if($page != 'services') : ?>
        <ul class="actions align-center">
          <li><a href="<?= $site['baseURL'] ?>/solutions" class="button"><?= \Lang\Dictionary::get('view_more') ?></a></li>
        </ul>
      <?php endif; */ ?>
	</div>
</section>