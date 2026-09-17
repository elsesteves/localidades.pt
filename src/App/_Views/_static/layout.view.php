<?php $pageLang = \Lang\Lang::fetchCurrentLangRef(); ?>
<!DOCTYPE HTML>
<html lang="<?= $pageLang ? $pageLang : '' ?>" dir="ltr">
  <head>
    <?php
      if (file_exists(__DIR__.'/../head/'.$page.'.view.php')) {
        require_once __DIR__.'/../head/'.$page.'.view.php';
      } else {
        require_once __DIR__.'/../head/default.view.php';
      }

      if (file_exists(__DIR__.'/../seo/'.$page.'.view.php')) {
        require_once __DIR__.'/../seo/'.$page.'.view.php';
      } else {
        require_once __DIR__.'/../seo/default.view.php';
      }
    ?>
  </head>
  <body class="is-preload">
    <?php 
      require_once __DIR__.'/header.php';
      require_once __DIR__.'/sidebar.php';
    ?>
    <div id="wrapper">
      <?php require_once __DIR__.'/../pages/'.$page.'.view.php'; ?>
    </div>
    <?php
      require_once __DIR__.'/footer.php';
      require_once __DIR__.'/script.php';
    ?>
  </body>
</html>