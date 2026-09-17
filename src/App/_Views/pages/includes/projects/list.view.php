<section id="projects" class="wrapper style-bg2 fade-up">
    <div class="inner <?= $page == 'projects' ? 'pad-top-short' : '' ?>">
      <h2><?= $projects['page']['title'] ?></h2>
      <?php if(exists($projects['page']['description'])) : ?>
        <p><?= nl2br(\Data\Str::srcCorrect($projects['page']['description'])) ?></p>
      <?php endif; ?>
      <div class="projects">
        <?php foreach ($projects['items'] as $project) : ?>
          <?php if(exists($project['url'])) : ?>
            <a href="<?= $site['baseURL'] .'/'. $project['url'] ?>" target="">
          <?php endif; ?>
          <section>
            <div class="item">
              <div class="item-inner">
                <picture>
                  <source media="(min-width:401px)" srcset="<?= $site['baseURL'] . '/' . $project['image']['resize'] ?>">
                  <img loading="lazy" src="<?= $site['baseURL'] . '/' . $project['image']['thumb'] ?>" alt="<?= $project['title'] ?>">
                </picture>
                <div class="info"><?= $project['title'] ?></div>
              </div>
            </div>
          </section>
          <?php if(exists($project['url'])) : ?>
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