<?php
	$sidebar = array(
		"events" => array(
			"title" => \Lang\Dictionary::get('events'),
			"img" => SITE_CONFIGS['info']['baseURL'] .'/assets/images/sidebar/event.jpg',
			"url" => SITE_CONFIGS['info']['baseURL']. '/' . \Lang\Lang::fetchCurrentLangRef() . '/' . \Lang\Dictionary::get('urlparam_events'),
			"description" => \Lang\Dictionary::get('sidebar_highlight_events_description'),
		),
		"beaches" => array(
			"title" => \Lang\Dictionary::get('beaches'),
			"img" => SITE_CONFIGS['info']['baseURL'] .'/assets/images/sidebar/beach.jpg',
			"url" => SITE_CONFIGS['info']['baseURL']. '/' . \Lang\Lang::fetchCurrentLangRef() . '/' . \Lang\Dictionary::get('urlparam_beaches'),
			"description" => \Lang\Dictionary::get('sidebar_highlight_beaches_description'),
		),
		"tourism_points" => array(
			"title" => \Lang\Dictionary::get('tourism_points'),
			"img" => SITE_CONFIGS['info']['baseURL'] .'/assets/images/sidebar/tourism.jpg',
			"url" => SITE_CONFIGS['info']['baseURL']. '/' . \Lang\Lang::fetchCurrentLangRef() . '/' . \Lang\Dictionary::get('urlparam_tourism_points'),
			"description" => \Lang\Dictionary::get('sidebar_highlight_tourism_description'),
		),
		"healthcare" => array(
			"title" => \Lang\Dictionary::get('healthcare'),
			"img" => SITE_CONFIGS['info']['baseURL'] .'/assets/images/sidebar/hospital.jpg',
			"url" => SITE_CONFIGS['info']['baseURL']. '/' . \Lang\Lang::fetchCurrentLangRef() . '/' . \Lang\Dictionary::get('urlparam_healthcare'),
			"description" => \Lang\Dictionary::get('sidebar_highlight_healthcare_description'),
		),
		"pharmacies" => array(
			"title" => \Lang\Dictionary::get('pharmacies'),
			"img" => SITE_CONFIGS['info']['baseURL'] .'/assets/images/sidebar/pharmacy.jpg',
			"url" => SITE_CONFIGS['info']['baseURL']. '/' . \Lang\Lang::fetchCurrentLangRef() . '/' . \Lang\Dictionary::get('urlparam_pharmacies'),
			"description" => \Lang\Dictionary::get('sidebar_highlight_pharmacies_description'),
		),
		"schools" => array(
			"title" => \Lang\Dictionary::get('educational_establishments'),
			"img" => SITE_CONFIGS['info']['baseURL'] .'/assets/images/sidebar/school.jpg',
			"url" => SITE_CONFIGS['info']['baseURL']. '/' . \Lang\Lang::fetchCurrentLangRef() . '/' . \Lang\Dictionary::get('urlparam_schools'),
			"description" => \Lang\Dictionary::get('sidebar_highlight_schools_description'),
		),
		"police" => array(
			"title" => \Lang\Dictionary::get('law_enforcement'),
			"img" => SITE_CONFIGS['info']['baseURL'] .'/assets/images/sidebar/police.jpg',
			"url" => SITE_CONFIGS['info']['baseURL']. '/' . \Lang\Lang::fetchCurrentLangRef() . '/' . \Lang\Dictionary::get('urlparam_police'),
			"description" => \Lang\Dictionary::get('sidebar_highlight_police_description'),
		),
		"firefighters" => array(
			"title" => \Lang\Dictionary::get('firefighters'),
			"img" => SITE_CONFIGS['info']['baseURL'] .'/assets/images/sidebar/firefighters.jpg',
			"url" => SITE_CONFIGS['info']['baseURL']. '/' . \Lang\Lang::fetchCurrentLangRef() . '/' . \Lang\Dictionary::get('urlparam_firefighters'),
			"description" => \Lang\Dictionary::get('sidebar_highlight_firefighters_description'),
		),
	);

	$currentURL = \Request::path();
?>

<div class="col-lg-3 col-md-5 sticky-col">
	<div class="row" id="main_sidebar">

		<?php foreach($sidebar as $sidebarItem) : 
			if ($sidebarItem['url'] == $currentURL) {
				continue;
			}
		?>
		<a href="<?= $sidebarItem['url'] ?>" title="<?= $sidebarItem['title'] ?>">
			<div class="col-12 mb-3 sidebar_highlight">
				<div class="img_wrap show">
					<div class="img" data-bg="<?= $sidebarItem['img'] ?>"></div>
				</div>
				<div class="info">
					<div class="title"><?= $sidebarItem['title'] ?></div>
					<div class="description"><?= $sidebarItem['description'] ?></div>
				</div>
			</div>
		</a>
		<?php endforeach; ?>

	</div>
</div>