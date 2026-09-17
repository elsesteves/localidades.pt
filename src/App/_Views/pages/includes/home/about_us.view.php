<?php if(exists($about_us['page']['description'])) : ?>
<section id="about_us" class="wrapper style-bg0 fade-up">
    <div class="inner">
      <h2><?= $about_us['page']['title'] ?></h2>
      <p><?= nl2br(\Data\Str::srcCorrect($about_us['page']['description'])) ?></p>
    </div>
</section>
<?php endif; ?>