<div class="bo_top_actions">

  <?php /* if(permission_check($module, 'delete')) : ?>
    <button type="button" class="delete" name="button" style="" onclick="itemDeleteConfirm(<?= $id ?>)">
      <i class="fa fa-trash" aria-hidden="true"></i> Eliminar <?= $moduleInfo['single'] ?>
    </button>
  <?php endif; */ ?>
  
</div>


    <form class="" action="" method="post">

      <div class="bo_input_group">
        <div class="label">Nome</div>
        <input type="text" name="title" value="<?= $info['title'] ? $info['title'] : $info['name'] ?>" required/>
      </div>
      
      <div class="bo_input_group">
        <div class="label">Morada</div>
        <textarea name="description"><?= $info['description'] ?></textarea>
      </div>
      
      <?php if(\User\Admin::permissionCheck($base_table, 'edit')) : ?>
        <button type="submit" class="bo_submit_btn" name="data_submit" title="Gravar"><i class="fa fa-floppy-o" aria-hidden="true"></i> Gravar</button>
      <?php endif; ?>

    </form>

<script type="text/javascript">
	
function itemDelete(id) {

	var ajax = {
	  method: 'GET',
	  url: 'ajax.php?module=<?= $module ?>&file=delete&id='+id,
	  data: ''
	};

	bo_ajax(ajax).then(response => {
	  //console.log(response);
	  window.location.replace("?module=<?= $module ?>");
	}).catch(error => {
	  //console.log(error);
	});
}

function itemDeleteConfirm(id) {

  var alert_object = {
    title: 'Eliminar Item',
    msg: 'Tem a certeza que pretende eliminar o item selecionado?<br>Esta ação é irreversível!',
    buttons: [
      {
        text: 'Cancelar',
        function: 'bo_alert_close',
        arguments: '',
        class: 'bo_alert_cancel'
      },
      {
        text: 'Confirmar',
        function: 'itemDelete',
        arguments: [id],
        class: ''
      }
    ]
  };
  bo_alert(alert_object);

}

</script>