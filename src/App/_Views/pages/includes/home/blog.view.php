<?php if(!empty($blog['items'])) : ?>
	<section id="blog" class="wrapper style-bg1 fade-up">
		<div class="inner">
			<h2><?= \Lang\Dictionary::get('useful_tips') ?></h2>
			<div id="blogposts-wrapper">
			<?php foreach($blog['items'] as $article) : ?>
				<a href="<?= $site['baseURL'] . $article['url'] ?>">
					<div class="item fade-up">					
						<picture>
			                  <source media="(min-width:401px)" srcset="<?= $site['baseURL'] . '/' . $article['image']['resize'] ?>">
			                  <img src="<?= $article['image']['thumb'] ?>" loading="lazy" alt="<?= $article['title'] ?>">
	                	</picture>
						<div class="title"><?= $article['title'] ?></div>
						<div class="txt"><?= $article['description'] ? nl2br($article['description']) : substr(strip_tags($article['page']), 0, 300) ?></div>
					</div>
				</a>
			<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>