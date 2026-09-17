<div id="main_title">Definições Gerais do Website</div>

<div id="bo_window_wrap">

    <div id="bo_tab_wrap">
        <div id="bo_tab_cont">
            
            <?php foreach($tabs as $tab) : ?>

                <?php if($tab['name'] == $file['tab']) : ?>
                    <a href="<?= $site['baseURL'] ?>/admin">
                        <div class="bo_tab active">
                            <i class="fa fa-<?= $tab['fa_icon'] ?>" aria-hidden="true"></i>
                            <?= $tab['title'] ? $tab['title'] : '('.$tab['name'].')' ?>
                        </div>
                    </a>
                <?php else : ?>
                    <div class="bo_tab">
                        <i class="fa fa-<?= $tab['fa_icon'] ?>" aria-hidden="true"></i>
                        <?= $tab['title'] ? $tab['title'] : '('.$tab['name'].')' ?>
                    </div>
                <?php endif; ?>
                
            <?php endforeach; ?>

        </div>
    </div>
    <div id="bo_window_cont">

    <?php

        $tabFile = fileTryLoop(array(
            __DIR__.'/../'.$file['folder'].'/tabs/'.$file['tab'].'.view.php',
            __DIR__.'/../_global/tabs/'.$file['tab'].'.view.php'
        ));

        if ($tabFile !== false) {
            require_once $tabFile;
        }

    ?>

    </div>

<div id="bo_window_wrap">