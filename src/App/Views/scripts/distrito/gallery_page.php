<script src="<?= $site['baseURL'] ?>/assets/plugins/magnific-popup/jquery.magnific-popup.js"></script>

<script defer type="text/javascript">
	/*
	var iframes = document.getElementsByClassName("iframe-showfullcontent");
	for(i = 0; i < iframes.length; i++) {
	    iframes[i].style.height = iframes[i].contentWindow.document.body.scrollHeight + 'px';
	}
	*/

	$jquery_maginific_popup(document).on('ready', function() {

		if ($('.popup-html').length) {
			$jquery_maginific_popup('.popup-html').magnificPopup({
			    type:'inline',
			    midClick: true
			});
		}

		if($('.popup-img').length) {
			$jquery_maginific_popup('.popup-img').magnificPopup({
			    type: 'image',

			    tLoading: 'A carregar a imagem...',
			    //tCounter:"%curr% de %total%",
			    mainClass: 'mfp-img-mobile',
			    image: {
			      tError: 'A imagem não pôde ser carregada',
			      titleSrc: function(item) {
			        return item.el.data('popup_caption');
			      }
			    }
			});
		}

		if($('.popup-img-slide').length) {
			$jquery_maginific_popup('.popup-img-slide').magnificPopup({
			    type: 'image',

			    //tLoading: 'A carregar a imagem #%curr%...',
			    tLoading: 'A carregar a imagem...',
			    //tCounter:"%curr% de %total%",
			    mainClass: 'mfp-img-mobile',
			    gallery: {
			      enabled: true,
			      navigateByImgClick: true,
			      preload: [0,1] // Will preload 0 - before current, and 1 after the current image
			    },
			    image: {
			      tError: 'A imagem não pôde ser carregada',
			      titleSrc: function(item) {
			        return item.el.data('popup_caption');
			      }
			    }
			});
		}

		if($('.popup-file').length) {
			$jquery_maginific_popup('.popup-file').magnificPopup({
				type: 'iframe',

				tLoading: 'A carregar...',
				mainClass: 'mfp-img-mobile',
				gallery: {
				enabled: true,
				navigateByImgClick: true,
				preload: [0,1] // Will preload 0 - before current, and 1 after the current image
				},

				iframe: {
				tError: 'NÃ£o foi possível carregar',
				titleSrc: function(item) {
				  //return item.el.attr('title') + '<small>Company Name</small>';
				  return item.el.data('popup_caption');
				},

				markup: '<div class="mfp-iframe-scaler c-iframe-popup-cont">'+
				          '<div class="mfp-close"></div>'+
				          '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
				        '</div>', // HTML markup of popup, `mfp-close` will be replaced by the close button

				callbacks: {
				    markupParse: function(template, values, item) {
				     values.title = item.el.data('popup_caption');
				    }
				  },
				patterns: {
				  youtube: {
				    index: 'youtube.com/', // String that detects type of video (in this case YouTube). Simply via url.indexOf(index).

				    id: 'v=', // String that splits URL in a two parts, second part should be %id%
				    // Or null - full URL will be returned
				    // Or a function that should return %id%, for example:
				    // id: function(url) { return 'parsed id'; }

				    src: '//www.youtube.com/embed/%id%?autoplay=1' // URL that will be set as a source for iframe.
				  },
				  vimeo: {
				    index: 'vimeo.com/',
				    id: '/',
				    src: '//player.vimeo.com/video/%id%?autoplay=1'
				  },
				  gmaps: {
				    index: '//maps.google.',
				    src: '%id%&output=embed'
				  }

				  // you may add here more sources

				},

				srcAction: 'iframe_src', // Templating object key. First part defines CSS selector, second attribute. "iframe_src" means: find "iframe" and set attribute "src".
				}
			});
		}

	});

</script>