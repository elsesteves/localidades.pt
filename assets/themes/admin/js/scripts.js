$jquery_maginific_popup(document).on('ready', function() {
  $jquery_maginific_popup('.popup-img').magnificPopup({
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
			//tError: '<a href="%url%">A imagem #%curr%</a> não pôde ser carregada.',
      tError: 'A imagem não pôde ser carregada',
			titleSrc: function(item) {
				return item.el.attr('title') + '<small>3D Informática</small>';
			}
		}
    // other options
  });

  $jquery_maginific_popup('.popup-file').magnificPopup({
    type: 'iframe',
    iframe: {
      markup: '<div class="mfp-iframe-scaler">'+
                '<div class="mfp-close"></div>'+
                '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
              '</div>', // HTML markup of popup, `mfp-close` will be replaced by the close button

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
    }  /*,

    //tLoading: 'A carregar a imagem #%curr%...',
    tLoading: 'A carregar o ficheiro...',
    //tCounter:"%curr% de %total%",
		mainClass: 'mfp-img-mobile',
		gallery: {
			enabled: true,
			navigateByImgClick: true,
			preload: [0,1] // Will preload 0 - before current, and 1 after the current image
		},
		image: {
			//tError: '<a href="%url%">A imagem #%curr%</a> não pôde ser carregada.',
      tError: 'O ficheiro não pôde ser carregado',
			titleSrc: function(item) {
				return item.el.attr('title') + '<small>3D Informática</small>';
			}
		}*/
    // other options
  });
});
