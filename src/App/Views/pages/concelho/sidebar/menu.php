<?php if(exists($sidebar['menu'])) : ?>
  <ul class="nav nav-pills flex-column">
    <?php foreach($sidebar['menu'] as $menuItem) : ?>
      <?php if(exists($menuItem['items'])) : ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="<?= $menuItem['active'] ? 'true' : 'false' ?>"><?php 
            if(exists($menuItem['icon'])) { ?><i class="<?= $menuItem['icon'] ?>"></i> <?php }
          ?><?= $menuItem['label'] ?></a>
          <div class="dropdown-menu <?= $menuItem['active'] ? 'show' : '' ?>" style="">
            <?php foreach($menuItem['items'] as $submenuItem) : ?>
              <a class="dropdown-item <?= $submenuItem['active'] ? 'active' : '' ?>" href="<?= $submenuItem['url'] ?>"><?php 
                if(exists($submenuItem['icon'])) { ?><i class="<?= $submenuItem['icon'] ?>"></i> <?php }
              ?><?= $submenuItem['label'] ?></a>
            <?php endforeach; ?>
          </div>
        </li>
      <?php else : ?>
        <li class="nav-item">
          <a class="nav-link <?= $menuItem['active'] ? 'active' : '' ?>" href="<?= $menuItem['url'] ?>"><?php 
            if(exists($menuItem['icon'])) { ?><i class="<?= $menuItem['icon'] ?>"></i> <?php }
          ?><?= $menuItem['label'] ?></a>
        </li>
      <?php endif; ?>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>