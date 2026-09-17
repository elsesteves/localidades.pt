<?php
	$searchFormURL = $site['baseURL'] .'/'. $pageLang .'/'. \Lang\Dictionary::get('urlparam_beaches') .'/'. \Lang\Dictionary::get('urlparam_search');
?>
<form method="GET" action="<?= $searchFormURL ?>">
	<div class="row search-form">

		<?php 
		$formErrors = \Form::getFormErrors('beaches_search');
		if(exists($formErrors)) : ?>
			<div class="col-12 mb-2">
				<div class="alert alert-danger" role="alert"><span><?= \Lang\Dictionary::get('validation_error_general') ?></span></div>
			</div>
			<div class="clearfix"></div>
		<?php endif; ?>

		<div class="col-4 mb-2 form-group">
			<label for="district-select"><?= \Lang\Dictionary::get('district') ?></label>
			<select class="form-control" id="district-select" name="id_distrito" onchange="districtSelected(this.value)">
				<option value=""><?= \Lang\Dictionary::get('district_select') ?></option>
				<?php 
					if(exists($distritos)) {
						foreach($distritos as $distrito) : ?>
							<option value="<?= $distrito['id'] ?>" <?php 
							if (exists($_REQUEST['id_distrito']) && $_REQUEST['id_distrito'] == $distrito['id']) {
								print 'selected';
							}
							?>><?= $distrito['title'] ?></option>
						<?php endforeach; 
					} 
				?>
			</select>
			<?php if(exists($formErrors['id_distrito']['errors'])) : ?>
				<small class="errors"><?= implode('<br>', $formErrors['id_distrito']['errors']) ?></small>
			<?php endif; ?>
		</div>

		<div class="col-4 mb-2 form-group">
			<label for="municipality-select"><?= \Lang\Dictionary::get('municipality') ?></label>
			<select class="form-control" id="municipality-select" name="id_concelho" onchange="municipalitySelected(this.value)" <?php if(!exists($concelhos)) { print 'disabled'; } ?>>
				<option value=""><?= \Lang\Dictionary::get('municipality_select') ?></option>
				<?php 
					if(exists($concelhos)) {
						foreach($concelhos as $concelho) : ?>
							<option value="<?= $concelho['id'] ?>" <?php 
							if (exists($_REQUEST['id_concelho']) && $_REQUEST['id_concelho'] == $concelho['id']) {
								print 'selected';
							}
							?>><?= $concelho['title'] ?></option>
						<?php endforeach; 
					} 
				?>
			</select>
			<?php if(exists($formErrors['id_concelho']['errors'])) : ?>
				<small class="errors"><?= implode('<br>', $formErrors['id_concelho']['errors']) ?></small>
			<?php endif; ?>
		</div>

		<div class="col-4 mb-2 form-group">
			<label for="parish-select"><?= \Lang\Dictionary::get('parish') ?></label>
			<select class="form-control" id="parish-select" name="id_freguesia" <?php if(!exists($freguesias)) { print 'disabled'; } ?>>
				<option value=""><?= \Lang\Dictionary::get('parish_select') ?></option>
				<?php 
					if(exists($freguesias)) {
						foreach($freguesias as $freguesia) : ?>
							<option value="<?= $freguesia['id'] ?>" <?php 
							if (exists($_REQUEST['id_freguesia']) && $_REQUEST['id_freguesia'] == $freguesia['id']) {
								print 'selected';
							}
							?>><?= $freguesia['title'] ?></option>
						<?php endforeach; 
					} 
				?>
			</select>
			<?php if(exists($formErrors['id_freguesia']['errors'])) : ?>
				<small class="errors"><?= implode('<br>', $formErrors['id_freguesia']['errors']) ?></small>
			<?php endif; ?>
		</div>

		<div class="col-12 search_btn_wrap mb-2">
			<button class="search_btn" type="submit"><?= \Lang\Dictionary::get('Search') ?></button>
		</div>

	</div>
</form>

<script type="text/javascript">
	function districtSelected(id_distrito) {
		cleanMunicipalityList();
		cleanParishList();
		getMunicipalityList(id_distrito);
	}

	function municipalitySelected(id_concelho) {
		cleanParishList();
		getParishList(id_concelho);
	}


	function getMunicipalityList(id_distrito) {
		output = '';

		var ajax = {
			method: 'GET',
			url: '/localidades/api/pt/district/'+id_distrito+'/municipalities',
			data: ''
		};

		platform_ajax(ajax).then(response => {
			var obj = JSON.parse(response);

			$.each(obj, function(index, object) {
				output += '<option value="'+object.id+'">'+object.title+'</option>';
			});

			$("#municipality-select").append(output);
			$("#municipality-select").prop("disabled", false);
		}).catch(error => {
			//console.log(error);
		});
	}

	function cleanMunicipalityList() {
		$("#municipality-select").children().each(function() {
			if($(this).val() != '') {
				$(this).remove();
				$("#municipality-select").prop("disabled", true);
			}
		});
	}

	function getParishList(id_concelho) {
		output = '';

		var ajax = {
			method: 'GET',
			url: '/localidades/api/pt/municipality/'+id_concelho+'/parishes',
			data: ''
		};

		platform_ajax(ajax).then(response => {
			var obj = JSON.parse(response);

			$.each(obj, function(index, object) {
				output += '<option value="'+object.id+'">'+object.title+'</option>';
			});

			$("#parish-select").append(output);
			$("#parish-select").prop("disabled", false);
		}).catch(error => {
			//console.log(error);
		});
	}

	function cleanParishList() {
		$("#parish-select").children().each(function() {
			if($(this).val() != '') {
				$(this).remove();
				$("#parish-select").prop("disabled", true);
			}
		});
	}
</script>