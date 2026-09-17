<header>
	<div class="">

		<nav class="navbar navbar-expand-lg pt-2 pb-2">
		  <div class="container-fluid">
		    <a class="navbar-brand" href="<?= SITE_CONFIGS['info']['baseURL'] . '/' ?>" title="<?= SITE_CONFIGS['info']['name'] ?>">
		    	<img src="<?= SITE_CONFIGS['info']['baseURL'] ?>/assets/images/logo/logo.png">
		    </a>
		    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
		      <span class="navbar-toggler-icon"></span>
		    </button>
		    <div class="collapse navbar-collapse" id="navbarColor02">
		      <ul class="navbar-nav me-auto">
		        <li class="nav-item">
		          <a class="nav-link" href="<?= SITE_CONFIGS['info']['baseURL']. '/' . \Lang\Lang::fetchCurrentLangRef() . '/' . \Lang\Dictionary::get('urlparam_events') ?>"><?= \Lang\Dictionary::get('events') ?></a>
		        </li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><?= \Lang\Dictionary::get('leisure') ?></a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="<?= SITE_CONFIGS['info']['baseURL']. '/' . \Lang\Lang::fetchCurrentLangRef() . '/' . \Lang\Dictionary::get('urlparam_beaches') ?>"><?= \Lang\Dictionary::get('beaches') ?></a>
						<a class="dropdown-item" href="<?= SITE_CONFIGS['info']['baseURL']. '/' . \Lang\Lang::fetchCurrentLangRef() . '/' . \Lang\Dictionary::get('urlparam_tourism_points') ?>"><?= \Lang\Dictionary::get('tourism_points') ?></a>
					</div>
				</li>
		        <li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><?= \Lang\Dictionary::get('services') ?></a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="<?= SITE_CONFIGS['info']['baseURL']. '/' . \Lang\Lang::fetchCurrentLangRef() . '/' . \Lang\Dictionary::get('urlparam_healthcare') ?>"><?= \Lang\Dictionary::get('healthcare') ?></a>
						<a class="dropdown-item" href="<?= SITE_CONFIGS['info']['baseURL']. '/' . \Lang\Lang::fetchCurrentLangRef() . '/' . \Lang\Dictionary::get('urlparam_pharmacies') ?>"><?= \Lang\Dictionary::get('pharmacies') ?></a>
						<a class="dropdown-item" href="<?= SITE_CONFIGS['info']['baseURL']. '/' . \Lang\Lang::fetchCurrentLangRef() . '/' . \Lang\Dictionary::get('urlparam_schools') ?>"><?= \Lang\Dictionary::get('educational_establishments') ?></a>
						<a class="dropdown-item" href="<?= SITE_CONFIGS['info']['baseURL']. '/' . \Lang\Lang::fetchCurrentLangRef() . '/' . \Lang\Dictionary::get('urlparam_police') ?>"><?= \Lang\Dictionary::get('law_enforcement') ?></a>
						<a class="dropdown-item" href="<?= SITE_CONFIGS['info']['baseURL']. '/' . \Lang\Lang::fetchCurrentLangRef() . '/' . \Lang\Dictionary::get('urlparam_firefighters') ?>"><?= \Lang\Dictionary::get('firefighters') ?></a>
					</div>
				</li>
		      </ul>
		      <div id="header_langs" class="d-flex">
		      	<?php
					$langs = array(
						'pt' => array(
							"name" => 'Português',
							"short" => 'PT',
							"link" => 'pt',
						), 
						'en' => array(
							"name" => 'English',
							"short" => 'EN',
							"link" => 'en',
						),
					);

					$i = 0;
					foreach($langs as $lang) { 
						if ($i > 0) {
							?><span class="separator"></span><?php
						}
						?>
						<?php 

						if ($lang['link'] != \Lang\Lang::fetchCurrentLangRef()) { ?>
							<a class="nav-link" href="<?= SITE_CONFIGS['info']['baseURL'].'/'.$lang['link'] ?>" title="<?= $lang['name'] ?>"><?= $lang['short'] ?></a>
						<?php } else { ?>
							<a class="nav-link active" title="<?= $lang['name'] ?>"><?= $lang['short'] ?></a>
						<?php } ?>
					<?php 
						$i++;
					}
		      	?>
		      </div>
		    </div>
		  </div>
		</nav>

	</div>
</header>