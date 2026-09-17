<?php if(exists($breadcrumbs)) : ?>
	<div class="container-fluid mt-3">
		<ol class="breadcrumb">
			<?php foreach($breadcrumbs as $breadcrumbItem) : ?>
				<?php if(exists($breadcrumbItem['url'])) : ?>
					<li class="breadcrumb-item"><a href="<?= $breadcrumbItem['url'] ?>"><?= $breadcrumbItem['title'] ?></a></li>
				<?php else: ?>
					<li class="breadcrumb-item active"><?= $breadcrumbItem['title'] ?></li>
				<?php endif; ?>
			<?php endforeach; ?>
		</ol>
	</div>
<?php endif; ?>