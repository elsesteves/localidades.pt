<section id="intro" class="wrapper style-bg1 fullscreen fade-up">

	<video  autoplay="" muted="" loop="" preload="true" style="position: absolute; min-width: 100%; min-height: 100%; top: 0; left: 0; overflow: hidden; opacity: 0.75; filter: grayscale(0.2) blur(3px);">
		<source src="assets/themes/agency/images/waves_green.webm" type="video/webm">
	</video>

	<div class="inner">

		<div class="slide">
			<?php 
				if ($pageLang == 'pt') {
					?>
					<div class="media">
						<iframe style="" frameborder="0" allowfullscreen="1" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" src="https://www.youtube.com/embed/kxDh3IFV4PQ?modestbranding=1&autoplay=1&controls=0&showinfo=0&rel=0&enablejsapi=1&version=3&playerapiid=iframe_sliderVideo&origin=https%3A%2F%2Fwww.estevesweb.pt&allowfullscreen=true&wmode=transparent&iv_load_policy=3&cc_load_policy=0&playsinline=0&html5=1&widgetid=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					</div>
					<?php
					
				} elseif($pageLang == 'en') {
					?>
					<div class="media">
						<iframe style="" frameborder="0" allowfullscreen="1" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" src="https://www.youtube.com/embed/bKuJr-h1BJQ?modestbranding=1&autoplay=1&controls=0&showinfo=0&rel=0&enablejsapi=1&version=3&playerapiid=iframe_sliderVideo&origin=https%3A%2F%2Fwww.estevesweb.pt&allowfullscreen=true&wmode=transparent&iv_load_policy=3&cc_load_policy=0&playsinline=0&html5=1&widgetid=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					</div>
					<?php
				}

			?>
			

			<div class="text">
				<?php /*<h1><?= $slider['title'] ?></h1>*/ ?>
				<p><?= nl2br($slider['subtitle']) ?></p>
			</div>
		</div>


		<?php if(exists($slider['button']['url'])) : ?>
		<ul class="actions">
			<li><a href="<?= $slider['button']['url'] ?>" class="button scrolly"><?= $slider['button']['label'] ?></a></li>
		</ul>
		<?php endif; ?>
	</div>
</section>