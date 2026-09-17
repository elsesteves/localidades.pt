<section class="wrapper style-bg2 fade-up">
	<div id="breadcrumbs" class="inner">
		<a href="<?= $baseURL ?>"><?= $site['name'] ?></a> >
		<span class="active"><?= \Lang\Dictionary::get('projects_made') ?></span>
	</div>
</section>

<?php 
	require __DIR__ .'/includes/projects/list.view.php';
	require __DIR__ .'/includes/projects/pagination.view.php';
	require __DIR__ .'/includes/contacts/form.view.php';
?>