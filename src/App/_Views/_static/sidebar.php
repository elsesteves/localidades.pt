<section id="sidebar" class="">
  <div class="inner">
    <nav>
      <ul>
        <li><a href="<?= $page == 'homepage' ? '' : $baseURL ?>#intro"><?= $site['name'] ?></a></li>
        
         <li><a class="<?php if(in_array($page, array('services'))) { print 'active'; } ?>" href="<?= $page == 'homepage' ? '#solutions' : $baseURL. 'solutions' ?>"><?= \Lang\Dictionary::get('solutions') ?></a></li>
        
        <li><a class="<?php if(in_array($page, array('projects', 'project'))) { print 'active'; } ?>" href="<?= $page == 'homepage' ? '#projects' : $baseURL . 'projects' ?>"><?= \Lang\Dictionary::get('projects_made') ?></a></li>
       
        <li><a class="<?php if(in_array($page, array('contacts'))) { print 'active'; } ?>" href="<?= $page == 'homepage' ?  '#contacts' : $baseURL . 'contacts' ?>"><?= \Lang\Dictionary::get('contact us') ?></a></li>
      </ul>
    </nav>

    <?php

    $langs = array(
      "pt" => array(
        "name" => 'Português',
        "abr" => 'PT',
      ),
      "en" => array(
        "name" => 'English',
        "abr" => 'EN',
      ),
    );
    ?>

    <div id="langs">
      <?php 
      $langCount = 0;
      foreach ($langs as $key => $value) : ?>
        <?php if ($langCount) : ?>
          <div class="separator"></div>
        <?php endif; ?>   
        <a class="<?= $pageLang == $key ? 'active' : '' ?>" href="<?= $site['baseURL'] . '/' . $key ?>" title="<?= $value['name'] ?>"><?= $value['abr'] ?></a>             
      <?php 
      $langCount++;
      endforeach; ?>
    </div>
  </div>
</section>