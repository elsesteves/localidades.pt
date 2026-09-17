<footer id="footer" class="wrapper">
<div class="inner">
	<ul class="menu">
		<?php if(!empty($footer['info_pages']['pages'])) : ?>
			<?php foreach ($footer['info_pages']['pages'] as $link) : 				
				$target = '';

				if ($link['url'] == "https://www.livroreclamacoes.pt/inicio") {
					$target = '_blank';
				}
				?>
	 			<li>
	 				<a href="<?= $link['url'] ?>" alt="<?= $link['title'] ?>" target="<?= $target ?>" rel="<?= $target == '_blank' ? 'noreferrer' : '' ?>"><?= $link['title'] ?></a>
	 			</li>
	 		<?php endforeach; ?>
		<?php endif; ?>
	</ul>
	<ul class="menu last">
		<li>Copyright &copy; <?= date('Y') ?></li><li><?= $site['name'] ?></li>
	</ul>
</div>
</footer>