function call_user_func_array(cb, parameters) {  
    // Call a user function which is the first parameter with the arguments contained in array    
    var func;

    if (typeof cb == 'string') {  
        if (typeof this[cb] == 'function') {  
            func = this[cb];  
        } else {  
            func = (new Function(null, 'return ' + cb))();  
        }  
    } else if (cb instanceof Array) {  
        func = eval(cb[0]+"['"+cb[1]+"']");  
    }  
      
    if (typeof func != 'function') {  
        throw new Exception(func + ' is not a valid function');  
    }  
  
    return func.apply(null, parameters);  
}

function bo_alert(alert_object) {
	$("#bo_alert_header").html(alert_object.title);
	$("#bo_alert_body").html(alert_object.msg);

	var btn_group = '';
	for (var i = 0; i < alert_object.buttons.length; i++) {
		var button = '<button class="'+alert_object.buttons[i].class+'" onclick="'+alert_object.buttons[i].function+'('+alert_object.buttons[i].arguments+')">'+alert_object.buttons[i].text+'</button>';
		btn_group += button;
	}

	if (btn_group != '') {
		$("#bo_alert_footer").html(btn_group);
	}

	$("#bo_alert_box").show();
	$("#bo_alert_wrapper").show();
}

function bo_alert_close() {
	$("#bo_alert_wrapper").hide();
	$("#bo_alert_box").hide();	
}


function bo_prompt(prompt_object) {
	$("#bo_prompt_header").html(prompt_object.title);

	var msg = prompt_object.msg;

	for (var i = 0; i < prompt_object.inputs.length; i++) {
		msg += '<div class="bo_input_group"><div class="label">'+prompt_object.inputs[i].label+'</div><input type="'+prompt_object.inputs[i].type+'" class="'+prompt_object.inputs[i].class+'" value="'+prompt_object.inputs[i].value+'"></div>';
	}

	$("#bo_prompt_body").html(msg);

	var btn_group = '';
	for (var i = 0; i < prompt_object.buttons.length; i++) {
		var button = '<button class="'+prompt_object.buttons[i].class+'" onclick="'+prompt_object.buttons[i].function+'('+prompt_object.buttons[i].arguments+')">'+prompt_object.buttons[i].text+'</button>';
		btn_group += button;
	}

	if (btn_group != '') {
		$("#bo_prompt_footer").html(btn_group);
	}

	$("#bo_prompt_box").show();
	$("#bo_prompt_wrapper").show();
}

function bo_prompt_close() {
	$("#bo_prompt_wrapper").hide();
	$("#bo_prompt_box").hide();	
}

document.getElementById("bo_alert_wrapper").addEventListener("click", function( e ){
    e = window.event || e; 
    if(this === e.target) {
        bo_alert_close();
    }
});

$(document).on("click", "#bo_alert_footer > button", function() {
	bo_alert_close();
});

document.getElementById("bo_prompt_wrapper").addEventListener("click", function( e ){
    e = window.event || e; 
    if(this === e.target) {
        bo_prompt_close();
    }
});

$(document).on("click", "#bo_prompt_footer > button", function() {
	bo_prompt_close();
});

function sideMenuSubToggle(id) {
	if ($("#sideMenuSub-"+id).hasClass("hidden")) {
		$("#sideMenuSub-"+id).removeClass("hidden");
		$("#sideMenuBtn-"+id).html('<i class="fa fa-caret-down" aria-hidden="true"></i>');
	} else {
		$("#sideMenuSub-"+id).addClass("hidden");
		$("#sideMenuBtn-"+id).html('<i class="fa fa-caret-right" aria-hidden="true"></i>');
	}
}

$(document).on("click", ".bo_table_actions_check", function() {
	if($(this).is(":checked")) {
		var table = $(this).parent().parent().parent();
		$(table).children(".bo_table_body").find(".bo_table_row_check_input").prop('checked', true);
		$(this).prop('checked', false);
		$(this).parent().hide();
		$(table).children(".bo_table_actions").children(".bo_table_actions_uncheck_group").show();
	}
});

$(document).on("click", ".bo_table_actions_uncheck", function() {
	if($(this).is(":checked")) {
		var table = $(this).parent().parent().parent();
		$(table).children(".bo_table_body").find(".bo_table_row_check_input").prop('checked', false);
		$(this).prop('checked', false);
		$(this).parent().hide();
		$(table).children(".bo_table_actions").children(".bo_table_actions_check_group").show();
	}
});


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
		        //return item.el.attr('title') + '<small>Company Name</small>';
		        return item.el.attr('title');
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
		        //return item.el.attr('title') + '<small>Company Name</small>';
		        return item.el.attr('title');
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
			tError: 'Não foi posível carregar',
			titleSrc: function(item) {
			  //return item.el.attr('title') + '<small>Company Name</small>';
			  return item.el.attr('title');
			},

			markup: '<div class="mfp-iframe-scaler c-iframe-popup-cont">'+
			          '<div class="mfp-close"></div>'+
			          '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
			          /*'<div class="mfp-title"><small>Company Name</small></div>'+*/
			        '</div>', // HTML markup of popup, `mfp-close` will be replaced by the close button

			callbacks: {
			    markupParse: function(template, values, item) {
			     values.title = item.el.attr('title');
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
			}});
	}

});


$(".bo_table_body_sortable").sortable({
	connectWith: ".bo_table_body_sortable",
    start: function(event, ui) {
        ui.item.data('start_pos', ui.item.index());
    },
    stop: function(event, ui) {
        var start_pos = ui.item.data('start_pos');
        if (start_pos != ui.item.index()) {

        	$('.bo_table_body_sortable').each(function(i, obj) {

        		var parent = {
	        		module: $(this).data('module'),
	        		submodule:  $(this).data('submodule'),
	        		tab: $(this).data('tab'),
	        		file: $(this).data('file'),
	        		id: $(this).data('id')
	        	};

	        	var items = [];
	        	var itemCount = 0;
				$(this).children(".bo_table_row").each(function() {
					if (itemCount % 2) {
						//Even
						if ($(this).hasClass('odd')) {
							$(this).removeClass('odd');
							$(this).addClass('even');
						}
					} else {
						//Odd
						if ($(this).hasClass('even')) {
							$(this).removeClass('even');
							$(this).addClass('odd');
						}
					}
					items.push($(this).data('row-id'));
					itemCount++;
				});
				data = JSON.stringify(items);
	        	
	        	var url = "ajax.php?module="+parent.module;

	        	if (parent.submodule != '') {
	        		var url = url+"&submodule="+parent.submodule;
	        	}

	        	if (parent.tab != '') {
	        		var url = url+"&tab="+parent.tab;
	        	}

	        	if (parent.file != '') {
	        		var url = url+"&file="+parent.file;
	        	}

	        	if (parent.id != '') {
	        		var url = url+"&id="+parent.id;
	        	}

	        	var ajax = {
		          method: 'POST',
		          url: url,
		          data:  encodeURI('items='+ data)
		        };

		        bo_ajax(ajax).then(response => {
			      //console.log(response);


			    }).catch(error => {
			      //console.log(error);
			    });

			});    	

        } else {
            // the item was returned to the same position
        }
    }
});
$(".bo_table_body_sortable").disableSelection();


function bo_drag_drop(event, el) {
	var numOfFiles = 0;
    var numFilesProcessed = 0;

    event.preventDefault();
    numOfFiles = numOfFiles + event.dataTransfer.files.length;

    var parent = {
		module: $(el).data('module'),
		submodule:  $(el).data('submodule'),
		tab: $(el).data('tab'),
		file: $(el).data('file'),
		id: $(el).data('id')
	};

	var url = "ajax.php?module="+parent.module;

	if (parent.submodule != '') {
		var url = url+"&submodule="+parent.submodule;
	}

	if (parent.tab != '') {
		var url = url+"&tab="+parent.tab;
	}

	if (parent.file != '') {
		var url = url+"&file="+parent.file;
	}

	if (parent.id != '') {
		var url = url+"&id="+parent.id;
	}

	
	var processed = 0;
	var success = 0;
	var total = event.dataTransfer.files.length;
	for (var i = 0; i < total; i++) {
      //console.log(event.dataTransfer.files[i]);
      var file = event.dataTransfer.files[i];
      var formdata = new FormData();
      formdata.append("file", file);
      //console.log(event.dataTransfer.files[i].name);
      //console.log(event.dataTransfer.files[i].size+" bytes");

      var ajax = {
        method: 'POST',
        url: url,
        data: formdata
      };

      bo_ajax(ajax).then(response => {
      	processed++;
      	success++;
        //console.log(response);
        if (processed == total) {
        	if ($(el).data('redirect') != '') {
	        	window.location.replace($(el).data('redirect'));
	        } else {
	        	if ($(el).data('callback') !== undefined) {
					var callback = $(el).data('callback');
					//console.log(callback);
					//callback+'('+$(el).data('id')+')';
					var arguments = [$(el).data('id')];
					call_user_func_array(callback, arguments);
				}
	        }
        }
      }).catch(error => {
      	processed++;
        //console.log(error);
        if (processed == total && success > 0) {
        	if ($(el).data('redirect') != '') {
	        	window.location.replace($(el).data('redirect'));
	        } else {
	        	if ($(el).data('callback') !== undefined) {
					var callback = $(el).data('callback');
					//console.log(callback);
					//callback+'('+$(el).data('id')+')';
					var arguments = [$(el).data('id')];
					call_user_func_array(callback, arguments);
				}
	        }
        }
      });
    }

}

function bo_lang_change(link) {
	window.location = link;
}