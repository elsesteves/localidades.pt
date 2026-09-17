<section class="wrapper style-bg1 fade-up">
	<div id="breadcrumbs" class="inner">
		<a href="<?= $baseURL ?>"><?= $site['name'] ?></a> &gt;
		<a href="<?= $site['baseURL'] ?>/projects"><?= \Lang\Dictionary::get('projects_made') ?></a> &gt;
		<span class="active"><?= $project['info']['title'] ?></span>
	</div>
</section>

<section id="project" class="wrapper style-bg1 fade-up">
    <div class="inner pad-top-short">
		<h2><?= $project['info']['title'] ?></h2>
		<div id="info">
			<div id="main_info">
			<?php if(exists($project['info']['description'])) : ?>  
				<p><?= nl2br(\Data\Str::srcCorrect($project['info']['description'])) ?></p>
			<?php endif; ?>
			<?php if(exists($project['details'])) : ?>
				<table class="details">
					<?php 
					$i = 0;
					foreach ($project['details'] as $detail) : ?>
						<tr>
							<td><?= $detail['name'] ?></td>
							<td><?= $detail['value'] ?></td>
						</tr>
					<?php 
					$i++;
					endforeach; ?>
					<tr></tr>
				</table>
			<?php endif; ?>
			<?php if(exists($project['info']['url'])) : ?>
				<ul class="actions">
					<li>
						<a href="<?= $project['info']['url'] ?>" target="_blank" class="button">
							<i class="fa fa-link" aria-hidden="true"></i>
							<?= \Lang\Dictionary::get('view_project') ?>
						</a>
					</li>
				</ul>
			<?php endif; ?>
			</div>
			<div id="side_info">
				<?php if(exists($project['images'])) : ?>
					<h3><?= \Lang\Dictionary::get('gallery') ?></h3>
					<div class="gallery">
						<?php foreach ($project['images'] as $image) { ?>
							<a href="<?= $site['baseURL'] ?>/<?= $image['image_full'] ?>" class="js-smartPhoto" data-caption="<?= $image['caption'] ?>" data-id="<?= $image['id'] ?>" data-group="gallery"/>
								<picture>
									<source media="(min-width:801px)" srcset="<?= $site['baseURL'] . '/' . $image['image_full'] ?>">
                  <source media="(min-width:401px)" srcset="<?= $site['baseURL'] . '/' . $image['image_resize'] ?>">
                  <img loading="lazy" src="<?= $site['baseURL'] . '/' . $image['image_thumb']  ?>" alt="<?= $image['caption'] ?>">
                </picture>
							</a>
						<?php } ?>
					</div>
				<?php endif; ?>
			</div>
		</div>

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

<section id="projects" class="wrapper style-bg2 fade-up">
    <div class="inner <?= $page == 'projects' ? 'pad-top-short' : '' ?>">
      <h2><?= \Lang\Dictionary::get('related_projects') ?></h2>
      <?php if(exists($projects['page']['description'])) : ?>
        <p><?= nl2br(\Data\Str::srcCorrect($projects['page']['description'])) ?></p>
      <?php endif; ?>
      <div class="projects">
        <?php foreach ($related as $projectItem) : ?>
          <?php if(exists($projectItem['url'])) : ?>
            <a href="<?= $site['baseURL'] .'/'. $projectItem['url'] ?>">
          <?php endif; ?>
          <section>
            <div class="item">
              <div class="item-inner">
              	<picture>
                  <source media="(min-width:401px)" srcset="<?= $site['baseURL'] . '/' . $projectItem['image']['resize'] ?>">
                  <img loading="lazy" src="<?= $site['baseURL'] . '/' . $projectItem['image']['thumb'] ?>" alt="<?= $projectItem['title'] ?>">
                </picture>
                <div class="info"><?= $projectItem['title'] ?></div>
              </div>
            </div>
          </section>
          <?php if(exists($projectItem['url'])) : ?>
            </a>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
      <?php if($page != 'projects') : ?>
        <ul class="actions align-center">
          <li><a href="<?= $site['baseURL'] ?>/projects" class="button"><?= \Lang\Dictionary::get('view_more') ?></a></li>
        </ul>
      <?php endif; ?>
    </div>
</section>

<?php require __DIR__ .'/includes/contacts/form.view.php'; ?>