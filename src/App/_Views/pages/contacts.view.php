<section class="wrapper style-bg1 fade-up">
	<div id="breadcrumbs" class="inner">
		<a href="<?= $baseURL ?>"><?= $site['name'] ?></a> >
		<span class="active"><?= \Lang\Dictionary::get('contact us') ?></span>
	</div>
</section>
	
<?php /*
<iframe src="https://maps.google.com/maps?q=38.7506732,-9.2277702&hl=pt&z=18&t=k&amp;output=embed" height="350" frameborder="0" style="border:0; width: 100%;" allowfullscreen></iframe>
*/ ?>

<?php require __DIR__ .'/includes/contacts/form.view.php'; ?>