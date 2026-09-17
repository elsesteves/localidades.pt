<div class="wrapper fade-up error-page-wrap">
	<div class="inner">
		<h1>404</h1>

		<?php if(exists($error['page']['title'])) : ?>
			<h2><?= $error['page']['title'] ?></h2>
		<?php endif; ?>

		<?php if(exists($error['page']['description'])) : ?>
			<p><?= nl2br(\Data\Str::srcCorrect($error['page']['description'])) ?></p>
		<?php endif; ?>
	</div>
</div>