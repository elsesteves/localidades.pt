<section class="wrapper style-bg1 fade-up">
	<div id="breadcrumbs" class="inner">
		<a href="<?= $baseURL ?>"><?= $site['name'] ?></a> >
		<span class="active"><?= $info['page']['title'] ?></span>
	</div>
</section>

<section id="about_us" class="wrapper style-bg1 fade-up">
    <div class="inner">
      <h2><?= $info['page']['title'] ?></h2>
      <?php if(exists($info['page']['description'])) : ?>  
		<p><?= nl2br(\Data\Str::srcCorrect($info['page']['description'])) ?></p>
      <?php endif; ?>
    </div>
</section>

<?php require __DIR__ .'/includes/contacts/form.view.php'; ?>