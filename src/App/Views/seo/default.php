


<!-- Schema -->
<?php 
	if (file_exists(__DIR__.'/schema/breadcrumbs/'.$page.'.php')) {
    	require_once __DIR__.'/schema/breadcrumbs/'.$page.'.php';
	}

	if (file_exists(__DIR__.'/schema/'.$page.'.php')) {
    	require_once __DIR__.'/schema/'.$page.'.php';
	} else {
    	require_once __DIR__.'/schema/default.php';
	}
?>