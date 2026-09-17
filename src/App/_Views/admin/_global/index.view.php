<div id="main_title"><?= $display['title'] ?></div>

<div id="breadcrumbs_area">
    <?php foreach($display['breadcrumbs'] as $key => $breadcrumb) : ?>
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


<div class="bo_window_group_cont">
  <div class="bo_top_actions">
  	<?php

  	$include = fileTryLoop(array(
			__DIR__.'/../'.$file['folder'].'/'.$file['file'].'/top_actions.view.php',
			__DIR__.'/'.$file['file'].'/top_actions.view.php'
    ));

    if ($include !== false) {
      require $include;
    }
  	?>
  </div>
</div>

<div class="bo_table">
  <div class="bo_table_header">
	    <div class="bo_table_header_item bo_table_header_id">
	    	ID
	    </div><div class="bo_table_header_item bo_table_header_pic">
	    	
	    </div><div class="bo_table_header_item bo_table_header_status">
			Nome
	    </div><div class="bo_table_header_item bo_table_header_actions bo_slider_list_actions">
			Ações
		</div>
	</div>
	<form method="POST" action="<?= projectLink('/admin/form') ?>" enctype="multipart/form-data">
		<div class="bo_table_body bo_table_body_sortable" data-module="<?= $module ?>" data-submodule="<?= $submodule ?>" data-tab="" data-action="pos" data-id="<?= $id ?>">
		<?php if(empty($rows)) : ?>
			<div class="bo_table_noresults">
		      Não há resultados disponíveis
		    </div>
		<?php else: ?>
			<?php foreach ($rows as $rowKey => $row) :
				$get_query = array(
					"module" => $_GET['module'],
					"submodule" => $_GET['submodule'] ? $_GET['submodule'] : '',
					"id" => $row['id'],
				);
			?>

				<div id="bo_table_row_item_<?= $row['id'] ?>" class="bo_table_row <?= $rowKey % 2 ? 'even' : 'odd' ?>" data-row-id="<?= $row['id'] ?>">
					<div class="bo_table_row_item bo_table_row_id">
						<?= $row['id'] ?>		
					</div><div class="bo_table_row_item bo_table_row_pic">
						
					</div><div class="bo_table_row_item bo_table_row_status">
						<?= $row['name'] ?>		
					</div><div class="bo_table_row_item bo_table_row_actions bo_slider_list_actions">
						<a href="<?= projectLink("/admin/index?".http_build_query($get_query)) ?>">
							<button type="button" class="bo_table_action_link" title="Abrir Listagem"><i class="fa fa-th-list" aria-hidden="true"></i></button>
						</a>
						
						<a href="<?= projectLink("/admin/edit?".http_build_query($get_query)) ?>">
					    	<button type="button" class="bo_table_action_link" title="Abrir Página"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
					  	</a>

					  	<button type="button" class="bo_table_action_visible<?= $row['deleted'] == 0 ? '' : '_not' ?>" onclick="itemToggle(<?= $row['id'] ?>, this)" title="<?= $row['deleted'] == 0 ? 'Ativo' : 'Desativado' ?>"><i class="fa fa-<?= $row['deleted'] == 0 ? 'eye' : 'eye-slash' ?>" aria-hidden="true"></i></button>

					</div>
				</div>
			<?php endforeach ?>
		<?php endif; ?>

		</div>
	</form>

</div>