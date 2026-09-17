<a data-mfp-src="#item_new_form" class="popup-html">
	<button type="submit" style=""><i class="fa fa-plus" aria-hidden="true"></i> <?= $display['top_actions']['add']['button'] ?></button>
</a>

<?php //dd($addform_options); 

function imageResizeFields() {
	ob_start();
	?>
	<div class="bo_img_resize" style="padding: 10px;">
		<button type="button" class="delete" onclick="removeImageResize(this)" style="outline: none; background: var(--color-btn-5); color: var(--color-1); font-family: var(--font-4); border: none; line-height: 26px; font-size: 12px; padding: 0 10px; border-radius: 3px; cursor: pointer; display: block; margin-left: auto;">
			<i class="fa fa-trash" aria-hidden="true"></i>
			Eliminar Corte
		</button>

		<div class="bo_input_group">
			<div class="label" style="text-align: right;">Nome do corte</div> 
			<input type="text" name="img_resize[name][]" value="" required/>
    </div>
		<div class="bo_input_group" style="width: calc(50% - 2px); display: inline-block;">
			<div class="label" style="text-align: right;">Largura (px)</div> 
			<input type="number" name="img_resize[width_px][]" value="" step="1" min="1" required/>
    </div>
    <div class="bo_input_group" style="width: calc(50% - 2px); display: inline-block;">
			<div class="label" style="text-align: right;">Altura (px)</div> 
			<input type="number" name="img_resize[height_px][]" value="" step="1" min="1" required/>
    </div>
  </div>
	<?php
	$output = ob_get_clean();
	$output = trim(preg_replace('/\s\s+/', ' ', $output));

	return $output;
}
?>

<div id="item_new_form" class="subcat_form popup_form mfp-hide">
  <div class="popup_form_title"><?= $display['top_actions']['add']['title'] ?></div>

  <div class="popup_window_cont">
    <div class="popup_window_tab_wrap">
      <div class="popup_window_tab_sel">
        <div class="bo_popup_subtitle"><?= $display['top_actions']['add']['subtitle'] ?></div>
      </div>
    </div>
    <div class="popup_window_input_wrap">
      <div class="popup_window_group_cont_sel">
        <form method="POST" action="<?= projectLink('/admin/form') ?>" enctype="multipart/form-data">
          <div class="bo_popup_window_group">

          	<!--
        		<input type="hidden" name="category" value="<?= $id ?>">
						-->

						<input type="hidden" name="form" value="add_module">
        		<input type="hidden" name="module" value="system">
        		<input type="hidden" name="submodule" value="modules">        		
        		<input type="hidden" name="id" value="<?= $id ?>">

						<div class="bo_input_group">
			        <div class="label">Nome</div>
			        <input type="text" name="name" value="<?= $id != 0 ? $info['name'] . '_' : '' ?>" required/>
		      	</div>

		      	<div class="bo_input_group">
			        <div class="label">Título</div>
			        <input type="text" name="title" required/>
		      	</div>

		      	<div class="bo_input_group">
			        <div class="label">Singular</div>
			        <input type="text" name="single" required/>
		      	</div>

		      	<div class="bo_input_group">
			        <div class="label">Plural</div>
			        <input type="text" name="plural" required/>
		      	</div>

		      	<!--
		      	<div class="bo_input_group">
			        <div class="label">Categorias?</div>
			        <input type="checkbox" name="categories" checked/>
		      	</div>
		      	-->

		      	<?php if(!empty($addform_options['settings'])) : ?>
		      		<div class="bo_properties_wrap">
				      	<div class="properties_heading_1">Definições</div>
				      	<div class="bo_properties_box">
					      	<?php foreach($addform_options['settings'] as $id_setting => $setting) : ?>
					      		<div class="bo_input_group">
											<div class="label"><?= $setting['title'] ? $setting['title'] : $setting['name'] ?></div> 
											<input type="text" name="settings[<?= $id_setting ?>]" value=""/>
						      	</div>
									<?php endforeach; ?>
								</div>
							</div>
						<?php endif; ?>

						<div class="bo_properties_wrap">
			      	<div class="properties_heading_1">Separadores</div>
			      	<div class="bo_properties_box">
				      	<?php foreach($addform_options['tabs'] as $id_tab => $tab) : ?>
				      		<div class="bo_input_group">
										<input type="checkbox" name="tabs[<?= $id_tab ?>]" value="1"/>
										<div class="label"><b><?= $tab['title'] ? $tab['title'] : $tab['name'] ?></b></div> 
					      	</div>

					      	<?php if($tab['name'] == 'images') : ?>
					      		<div class="bo_img_resizes_wrap">
					      			<button type="button" onclick="addImageResize()" style="outline: none; background: var(--color-6); color: var(--color-1); font-family: var(--font-4); border: none; line-height: 28px; font-size: 13px; padding: 0 15px; border-radius: 4px; cursor: pointer; display: block; margin-left: auto;">
					      				<i class="fa fa-plus" aria-hidden="true"></i> Adicionar Novo Corte de Imagem
					      			</button>

					      			<div class="bo_img_resizes_box">

					      				<?= imageResizeFields() ?>

					      			</div>
					      		</div>
					      	<?php endif; ?>

					      	<?php if(!empty($tab['settings'])) : ?>
					      		<div class="bo_properties_wrap">
						      			<div class="properties_heading_2">Definições</div>
								      	<div class="bo_properties_box">
								      	<?php foreach($tab['settings'] as $id_setting => $setting) : ?>
								      		<div class="bo_input_group">
														<div class="label"><?= $setting['title'] ? $setting['title'] : $setting['name'] ?></div> 
														<input type="text" name="settings[<?= $id_setting ?>]" value=""/>
									      	</div>
								      	<?php endforeach; ?>
								      </div>
							      </div>
					      	<?php endif; ?>
				      	<?php endforeach; ?>
				      </div>
			      </div>

          	<button type="submit" class="bo_submit_btn" name="item_new_submit" title="Gravar" ><i class="fa fa-floppy-o" aria-hidden="true"></i> <?= $display['top_actions']['add']['save_button'] ?></button>

          </div>
        </form>
      </div>
    </div>
  </div>

</div>

<script>
	function addImageResize() {
		$(".bo_img_resizes_box").append('<?= imageResizeFields() ?>');
	}

	function removeImageResize(el) {
		$(el).parent().remove();
	}
</script>