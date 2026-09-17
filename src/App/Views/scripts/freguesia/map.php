<script type="text/javascript">
	window.onload = function() {
	    var ajax = {
		    method: 'GET',
		    url: '<?= SITE_CONFIGS['info']['baseURL'] ?>/api/<?= $pageLang ?>/parish/<?= $freguesia['id'] ?>/<?= \Data\Str::permalink_clean($freguesia['title']) ?>/map/points',
		    data: ''
		};

		platform_ajax(ajax).then(response => {
		    var obj = JSON.parse(response);

			var mapData = {};
		    mapData.locations = obj;

		    mapData = JSON.stringify(mapData);

		    document.getElementById('map').contentWindow.postMessage(mapData);
		}).catch(error => {
		    //console.log(error);
		});
	};
</script>