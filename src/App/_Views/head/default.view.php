<meta charset="utf-8"/>
<meta name="author" content="Esteves Web">
<title><?php 
	if (exists($seo['title'])) {
		$siteInfo['seo']['title'] = $seo['title'] . ' | ' . $site['name'];
	}
	print $siteInfo['seo']['title'];
?></title>
<meta name="description" content="<?php 
	if (exists($seo['description'])) {
		$siteInfo['seo']['description'] = $seo['description'] . ' ' . $siteInfo['seo']['description'];
	}
	print $siteInfo['seo']['description'];
?>" />
<meta name="keywords" content="<?php
	$keywords = array();
	if(exists($seo['keywords'])) {
		foreach($seo['keywords'] as $keyword) {
			array_push($keywords, $keyword['keyword']);
		}
		print implode(', ', $keywords);
		if(exists($siteInfo['seo']['keywords'])) {
			print ', ';
		}
	}
?><?= $siteInfo['seo']['keywords'] ?>" />
<meta name="distribution" content="Global">
<meta name="rating" content="General">
<meta name="expires" content="Never">
<meta name="robots" content="Index, Follow">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
<link rel="shortcut icon" href="<?= $site['baseURL'] ?>/assets/images/logo/logo.png">

<link rel="icon" type="image/png" sizes="16x16" href="<?= $site['baseURL'] ?>/assets/images/favicon/favicon-16x16.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?= $site['baseURL'] ?>/assets/images/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="<?= $site['baseURL'] ?>/assets/images/favicon/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="256x2566" href="<?= $site['baseURL'] ?>/assets/images/favicon/favicon-256x256.png">

<link rel="stylesheet" href="<?= $site['baseURL'] ?>/assets/themes/hyperspace/css/main.min.css" />
<noscript><link rel="stylesheet" href="<?= $site['baseURL'] ?>/assets/themes/hyperspace/css/noscript.min.css" /></noscript>

<?php if(in_array($page, array('project', 'blogpage'))) : ?>
<link rel="stylesheet" href="https://unpkg.com/smartphoto@1.1.0/css/smartphoto.min.css">
<?php endif; ?>

<?php if(in_array($page, array('homepage'))) : ?>
<link rel="stylesheet" type="text/css" href="<?= $site['baseURL'] ?>/assets/plugins/slick-1.8.1/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="<?= $site['baseURL'] ?>/assets/plugins/slick-1.8.1/slick/slick-theme.css"/>
<?php endif; ?>

<?php if (file_exists(__PROJECT_ROOT__.'/assets/themes/agency/css/global.min.css')) : ?>
	<link rel="stylesheet" href="<?= $site['baseURL'] ?>/assets/themes/agency/css/global.min.css" />
<?php else: ?>
	<link rel="stylesheet" href="<?= $site['baseURL'] ?>/assets/themes/agency/css/global.css" />
<?php endif; ?>

<?php if (file_exists(__PROJECT_ROOT__.'/assets/themes/agency/css/'.$page.'.min.css')) : ?>
	<link rel="stylesheet" href="<?= $site['baseURL'] ?>/assets/themes/agency/css/<?= $page ?>.min.css" />
<?php else: ?>
	<?php if (file_exists(__PROJECT_ROOT__.'/assets/themes/agency/css/'.$page.'.css')) : ?>
		<link rel="stylesheet" href="<?= $site['baseURL'] ?>/assets/themes/agency/css/<?= $page ?>.css" />
	<?php endif; ?>
<?php endif; ?>


<!-- Global site tag (gtag.js) - Google Analytics (Old) -->
<!-- Google Analytics ID G-9SC64P7P05 -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-9SC64P7P05"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-9SC64P7P05');
</script>

<!--
<!- Global site tag (gtag.js) - Google Ads: 743768014 ->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-743768014"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-743768014');
</script>
<!- Event snippet for Website traffic conversion page ->
<script>
  gtag('event', 'conversion', {'send_to': 'AW-743768014/XBDZCMusnaUDEM7_0-IC'});
</script>

-->

<!-- Global site tag (gtag.js) - Google Analytics (New) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-222186537-1">
</script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-222186537-1');
</script>


<!-- Clarity tracking code for https://estevesweb.pt/ -->
<script>
    (function(c,l,a,r,i,t,y){
        c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
        t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i+"?ref=bwt";
        y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
    })(window, document, "clarity", "script", "atsarmkhcq");
</script>


<!-- Meta Pixel Code -->
<!-- Pixel ID 484001640043628 -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '484001640043628');
fbq('track', 'PageView');
<?php if(($page == 'contacts') && Form::formSuccess()) : ?>
fbq('track', 'Lead');
<?php endif; ?>
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=484001640043628&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->