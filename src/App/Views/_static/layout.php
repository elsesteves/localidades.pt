<?php 
  require_once __DIR__.'/helper.php';
  $pageLang = \Lang\Lang::fetchCurrentLangRef();
?>
<!DOCTYPE html>
<html lang="<?= $pageLang ? $pageLang : '' ?>" dir="ltr">
<head>
	<?php
      if (file_exists(__DIR__.'/../head/'.$page.'.php')) {
        require_once __DIR__.'/../head/'.$page.'.php';
      } else {
        require_once __DIR__.'/../head/default.php';
      }

      if (file_exists(__DIR__.'/../seo/'.$page.'.php')) {
        require_once __DIR__.'/../seo/'.$page.'.php';
      } else {
        require_once __DIR__.'/../seo/default.php';
      }
    ?>
</head>
<body>

	<?php 
      require_once __DIR__.'/header.php';

      if (file_exists(__DIR__.'/../pages/'.$page.'.php')) {
	      require_once __DIR__.'/../pages/'.$page.'.php';
	    }

	    require_once __DIR__.'/footer.php';
      require_once __DIR__.'/script.php';
  ?>

</body>
</html>