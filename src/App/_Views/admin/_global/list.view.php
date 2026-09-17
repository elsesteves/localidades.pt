<div id="main_title"><?= $title ?></div>

<div id="breadcrumbs_area">
    <?php foreach($breadcrumbs as $key => $breadcrumb) : ?>
        <?php if($key > 0) {
            echo '&gt;';
        } ?>
        <?php if(exists($breadcrumb['link'])) : ?>
            <a href="<?= $breadcrumb['link'] ?>"><?= $breadcrumb['label'] ?></a>
        <?php else: ?>
            <span><?= $breadcrumb['label'] ?></span>
        <?php endif; ?>
    <?php endforeach;  ?>
</div>