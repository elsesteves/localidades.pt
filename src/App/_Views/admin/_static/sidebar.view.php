<?php

$menuItems = array();
//$menuItems = \Models\Admin\Menu::sidebarItems(0)['items'];

function adminSidebarMenu($items) {
	foreach($items as $item_id => $item) {

		if (!($item['allowed'] || $item['has_allowed_items'])) {
			continue;
		}
		?>
		<div class="bo_sidemenu_item">
			<div class="bo_sidemenu_item_top">

				<?php if(!empty($item['items'])) : ?>	
					<div class="bo_sidemenu_sub_toggle" onclick="sideMenuSubToggle(<?= $item_id ?>)">
						<div id="sideMenuBtn-<?= $item_id ?>" class="bo_sidemenu_sub_toggle_inner">
							<i class="fa fa-caret-right" aria-hidden="true"></i>
						</div>
					</div>
				<?php endif; ?>

				<?php if($item['allowed']): ?>
					<a href="<?= $item['info']['link'] ?>">
						<div class="bo_sidemenu_item_name"><?= $item['info']['title'] ?></div>
					</a>
				<?php else: ?>
					<div class="bo_sidemenu_item_name"><?= $item['info']['title'] ?></div>
				<?php endif; ?>

			</div>

			<?php if(!empty($item['items'])) : ?>			
				<div id="sideMenuSub-<?= $item_id ?>" class="bo_sidemenu_sub hidden">
					<?php 
						adminSidebarMenu($item['items']);
					?>
				</div>
			<?php endif; ?>

		</div>
		<?php
	}	
}

?>

<div id="bo_menu_lat">
	<div id="bo_menu_lat_wrap">
		<?php
			adminSidebarMenu($menuItems);
		?>
	</div>
</div>