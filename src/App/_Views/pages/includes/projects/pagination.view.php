<?php

$pagination = $projects['pagination'];

if($pagination['last'] > 1 || $pagination['current'] != 1) {
	$path = \Request::getPath()['path'];
	?>
	<section class="wrapper style-bg2 fade-up">
		<div class="inner pad-top-none pagination-block">
			<?php for($pageNum = 1; $pageNum <= $pagination['last']; $pageNum++) : ?>
				<?php 
					$getData = $_GET;
					$getData['page'] = $pageNum;
					$url = $path . '?'. http_build_query($getData);
				?>
				<a href="<?= $url ?>">
					<div class="pagination-item <?= $pageNum == $pagination['current'] ? 'current' : '' ?>">
						<?= $pageNum ?>	
					</div>
				</a>
			<?php endfor; ?>
		</div>
	</section>
	<?php 
}
?>