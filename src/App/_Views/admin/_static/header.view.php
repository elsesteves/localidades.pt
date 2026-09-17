<?php
	$adminInfo = \User\Admin::getAdminInfo();
?>
<div id="bo_header">
  <a href="logout.php">
    <button id="logout-btn">Terminar Sessão</button>
  </a>
  <div id="logout_adminName">
  	<a href="?module=account">
			<i class="fa fa-cog" aria-hidden="true"></i>
			<?= $adminInfo['profile']['name'] ?>
		</a>
  </div>

  <div id="header_lang_wrap">
  	<form>
			<select name="bo_lang" id="header_lang_select" onchange="adminLangChange(this.value)">
		  		<?php
		  			$langs = \Lang\Lang::getList();
		  			$lang_id = \Lang\Lang::getLanguage('admin');

		  			foreach ($langs as $lang) : ?>
		  				<option value="<?= $lang['ref_short'] ?>" <?= $lang_id == $lang['id'] ? 'selected' : '' ?>><?= $lang['name'] ?></option>
		  		<?php endforeach; ?>
			</select>
		</form>
  </div>
</div>
