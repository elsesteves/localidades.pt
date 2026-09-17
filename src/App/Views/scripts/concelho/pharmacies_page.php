<?php /*
<script type="text/javascript">
	var pharmacyListItems = <?= json_encode($pharmacies); ?>;

	function listItemTemplate(data)	{

		var html = '';

		$.each( data, function( key, pharmacy ) {
			console.log( key + ": " + pharmacy );

			html += '<div class="col-md-6 col-lg-4 col-xxl-3">';
				html += '<a href="'+pharmacy.url+'">';
					html += '<div class="pharmacy_card">';
						html += '<div class="img_wrap">';
							html += '<div class="pharmacy_img" style="background-image: none;"></div>';
						html += '</div>';
						html += '<div class="info">';
							html += '<div class="title">'+pharmacy.title+'</div>';
							html += '<div class="address">'+pharmacy.title+'</div>';
							
							if (typeof pharmacy.freguesia.title !== 'undefined') {
								html += '<div class="freguesia">'+pharmacy.freguesia.title+'</div>';
							}		

						html += '</div>';
					html += '</div>';
				html += '</a>';
			html += '</div>';
        });


	}


	/*
	$('#pharmacies_list').pagination({
	    dataSource: pharmacyListItems,
	    pageSize: 5,
	    showGoInput: true,
	    showGoButton: true,
	    callback: function(data, pagination) {
	        // template method of yourself
	        console.log(data);
	        $.each( data, function( key, value ) {
	           console.log( key + ": " + value );
	        });
	    }
	});
	* /
</script>


<script src="<?= $site['baseURL'] ?>/assets/plugins/pagination.js.org_dist_2.6.0/pagination.js"></script>
*/?>