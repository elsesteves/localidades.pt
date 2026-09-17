<?php 

  $items = array();
  $i = 1;
  foreach ($projects['items'] as $project) {
    array_push($items, array(
      "@type" => "ListItem",
      "position" => "$i",
      "item" => array(
        "@type" => "WebPage",
        "url" => $project['url'] ? $site['domain'] . $site['baseURL'] .'/'. $project['url'] : '',
        "name" => $project['title'],
        "image" => $project['image']['thumb'] ? $site['domain'] . $site['baseURL'] .'/'. $project['image']['thumb'] : '',
      ),
    ));

    $i ++;
  }

?>

<script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "ItemList",
    "name":"<?= \Lang\Dictionary::get('projects_made') ?>",
    "description":"<?= \Data\Str::srcCorrect($projects['page']['description']) ?>",
    "itemListElement": <?= json_encode($items) ?>
  }
</script>