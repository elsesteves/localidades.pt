var editor = document.querySelectorAll(".editor");

var bo_editor = [];

$(document).ready(function(){
  for (var i = editor.length - 1; i >= 0; i--) {
  	bo_editor[i] = new Editor($("#editor-"+i));
    //editor[i].contentDocument.designMode = "on";
    cmsLoadImgs(i);
  }
});

$(".editor").on("load", function(){
  var i = $(this).data('id');
  $(this).contents().on("change keyup click onmouseup", function(){
    bo_editor[i].textChange();
  });
});

window.addEventListener("load",function(){

	$('.UndoButton').click(function(){
		var i = $(this).data('editor-id');
		bo_editor[i].styleText("Undo", null);
	});

	$('.RedoButton').click(function(){
		var i = $(this).data('editor-id');
		bo_editor[i].styleText("Redo", null);
	});

	$('.BoldButton').click(function(){
		var i = $(this).data('editor-id');
		bo_editor[i].styleText("Bold", null);
	});

	$('.ItalicButton').click(function(){
		var i = $(this).data('editor-id');
		bo_editor[i].styleText("Italic", null);
	});

	$('.UnderlineButton').click(function(){
		var i = $(this).data('editor-id');
		bo_editor[i].styleText("Underline", null);
	});

	$('.StrikeButton').click(function(){
		var i = $(this).data('editor-id');
		bo_editor[i].styleText("Strikethrough", null);
	});

	$('.SupButton').click(function(){
		var i = $(this).data('editor-id');
		bo_editor[i].styleText("Superscript", null);
	});

	$('.SubButton').click(function(){
		var i = $(this).data('editor-id');
		bo_editor[i].styleText("Subscript", null);
	});

	$('.OrderedListButton').click(function(){
		var i = $(this).data('editor-id');
		bo_editor[i].styleText("InsertOrderedList", "New" + Math.round(Math.random() *1000));
	});

	$('.UnorderedListButton').click(function(){
		var i = $(this).data('editor-id');
		bo_editor[i].styleText("InsertUnorderedList", null);
	});

	$('.LeftAlignButton').click(function(){
		var i = $(this).data('editor-id');
		bo_editor[i].styleText("justifyLeft", null);
	});

	$('.CenterAlignButton').click(function(){
		var i = $(this).data('editor-id');
		bo_editor[i].styleText("justifyCenter", null);
	});

	$('.RightAlignButton').click(function(){
		var i = $(this).data('editor-id');
		bo_editor[i].styleText("justifyCenter", null);
	});

	$('.FullAlignButton').click(function(){
		var i = $(this).data('editor-id');
		bo_editor[i].styleText("justifyFull", null);
	});

	$('.AddLinkButton').click(function(){
		var i = $(this).data('editor-id');
		bo_editor[i].addLink(i);
	});

	$('.RemoveLinkButton').click(function(){
		var i = $(this).data('editor-id');
		bo_editor[i].styleText("Unlink", null);
	});

	$(document).on("change", '.FontColorButton', function(event){
		var i = $(this).data('editor-id');
		bo_editor[i].styleText("ForeColor", event.target.value);
	});

	$(document).on("change", '.HighlightButton', function(event){
		var i = $(this).data('editor-id');
		bo_editor[i].styleText("BackColor", event.target.value);
	});

	$(document).on("change", '.HeadingChanger', function(event){
		var i = $(this).data('editor-id');
		bo_editor[i].styleText("formatBlock", event.target.value);
	});

	$(document).on("change", '.FontChanger', function(event){
		var i = $(this).data('editor-id');
		bo_editor[i].styleText("FontName", event.target.value);
	});

	$(document).on("change", '.FontSizeChanger', function(event){
		var i = $(this).data('editor-id');
		bo_editor[i].styleText("FontSize", event.target.value);
	});


	$('.TableButton').click(function(){
	  var i = $(this).data('editor-id');
	  $(".menus_wrap").eq(i).children('div').addClass("hidden");
	  $(".tab-upload").eq(i).removeClass("hidden");
	});

	$('.ImageButton').click(function(){
	  var i = $(this).data('editor-id');
	  $(".menus_wrap").eq(i).children('div').addClass("hidden");
	  $(".img-upload").eq(i).removeClass("hidden");
	});

	$('.VideoButton').click(function(){
	  var i = $(this).data('editor-id');
	  $(".menus_wrap").eq(i).children('div').addClass("hidden");
	  $(".vid-upload").eq(i).removeClass("hidden");
	});


	$('.CodeButton').click(function(){
	  var i = $(this).data('editor-id');
	  var editor_html = editor[i].innerHTML;
	  $("#code_src_"+i).val(editor_html);
	  $(".menus_wrap").eq(i).children('div').addClass("hidden");
	  $(".code-upload").eq(i).removeClass("hidden");
	});


	$(document).on("click", ".imglist .pic-item .pic-add", function() {
	  var i = $(this).data('editor-id');
	  var imagesrc = $(this).data('img-src');
	  var imageCaption = $(this).data('img-caption');
	  var imgalign = $("#imgalign_"+i).val();

	  addPicture(i, imagesrc, imageCaption, imgalign);
	});

},false);


function pageChange(i) {
	bo_editor[i].textChange();
}


function cmsLoadImgs(id) {
  var ajax = {
    method: 'GET',
    url: 'ajax.php?module=cms&submodule=pages&tab=images&file=list&id='+id,
    data: ''
  };

  bo_ajax(ajax).then(response => {
    var json = JSON.parse(response);
    $(".imglist").eq(id).html('');

    var listHTML = '';

    for(var i = 0; i < json.length; i++) {
      listHTML += '<div class="pic-item"><div class="pic-cont"><img src="../'+json[i].image_thumb+'"></div><div class="pic-info"><input class="pic-name" type="text" value="'+json[i].name+'" onkeyup="cmsImgCaption('+json[i].id+', this.value)"/><div class="pic-time">'+json[i].time_lastmod+'</div></div><div class="pic_btn_cont"><button class="pic-add" data-editor-id="'+id+'" data-img-src="../'+json[i].image_full+'" data-img-caption="'+json[i].name+'" type="button"><i class="fa fa-paperclip" aria-hidden="true"></i> Adicionar à Página</button><button class="pic-del" type="button" onclick="cmsImgDel('+json[i].id+', this)"><i class="fa fa-trash" aria-hidden="true"></i> Remover da Lista</button></div></div>';
    }

    $(".imglist").eq(id).html(listHTML);


  }).catch(error => {
    //console.log(error);
  });
}

function cmsImgDel(id, el) {
  var ajax = {
    method: 'GET',
    url: 'ajax.php?module=cms&submodule=pages&tab=images&file=delete&id='+id,
    data: ''
  };

  bo_ajax(ajax).then(response => {
    $(el).parent().parent().remove();
  }).catch(error => {
    //console.log(error);
  });
}

function cmsImgCaption(id, value) {
  var ajax = {
    method: 'POST',
    url: 'ajax.php?module=cms&submodule=pages&tab=images&file=caption&id='+id,
    data: encodeURI("caption="+value)
  };

  bo_ajax(ajax).then(response => {
    //console.log(response);
  }).catch(error => {
    //console.log(error);
  });
}

function addPicture(id, imageSrc, imageCaption, imgAlign) {
  var image ='<img title="'+imageCaption+'" alt="'+imageCaption+'" src="'+imageSrc+'">';
  
  var contenteditable = 'true';
  if (imgAlign == "center") {
    var imagerect = '<div class="img_wrap" data-imgsrc="'+imageSrc+'" data-align="center" data-caption="" style="margin-left: auto; margin-right: auto;" contenteditable="'+contenteditable+'">'+image+'</div>';
  } else {
    if (imgAlign == 'left') {
      $padding = 'padding-right: 16px;';
    } else {
      $padding = 'padding-left: 16px;';
    }
    
    var imagerect = '<div class="img_wrap" data-imgsrc="'+imageSrc+'" data-align="'+imgAlign+'" data-caption="" contenteditable="'+contenteditable+'" style="float: '+imgAlign+';'+$padding +'">'+image+'</div>';
  }

  bo_editor[id].styleText("insertHTML", imagerect);
}


$(document).on("click", ".menu_close_btn", function() {
  $(this).parent().parent().addClass("hidden");
});

function addCmsLink(i) {
  var cms_link = $(".bo_cms_link").val();

  if($(".bo_cms_link_blank").is(':checked')){
    var sText = editor[i].contentWindow.document.getSelection();
    bo_editor[i].styleText("insertHTML", '<a href="' + cms_link + '" target="_blank">' + sText + '</a>');
  } else {
    bo_editor[i].styleText("CreateLink", cms_link);
  }
}

$(document).on("click", ".pagevid_url_btn", function() {
  var i = $(this).data('editor-id');
  var youtube = $(this).parent().children(".pagevid_url_input").val();
  var youtube = youtube.replace("https://www.youtube.com/watch?v=", "");
  var videorect = '<div class="vidcase" contenteditable="false" style="margin: 0 auto;"><div class="vidcase_inner"><iframe src="https://www.youtube.com/embed/'+youtube+'"></iframe></div></div><br><br>';

  var cursorPos = bo_editor[i].getLastCursorPosition();
  Cursor.setCurrentCursorPosition(cursorPos, bo_editor[i].editor[0]);

  bo_editor[i].styleText("insertHTML", videorect);
});

$(document).on("click", ".page_code_btn", function() {
  var i = $(this).data('editor-id');
  var src_code = $("#code_src_"+i).val();
  editor[i].innerHTML = src_code;

  bo_editor[i].textChange();
});

function tablecreate(id) {
  var colnum = $("#ColInput_"+id).val();
  var rownum = $("#RowInput_"+id).val();
  var TabMobileView = $("#TabMobileView_"+id).val();
  var tablebackcolor = $("#TabBackColorButton_"+id).val();
  var headfontcolor = $("#TabHeaderFontColorButton_"+id).val();
  var headbackcolor = $("#TabHeaderBackColorButton_"+id).val();
  var rowfontcolor = $("#TabRowFontColorButton_"+id).val();
  var rowbackcolor = $("#TabRowBackColorButton_"+id).val();
  var rowfontcolor_even = $("#TabRowFontColorButton_even_"+id).val();
  var rowbackcolor_even = $("#TabRowBackColorButton_even_"+id).val();

  if ($("#TabSpacing_"+id).prop("checked")) {
    var TabSpacing = '';
  } else {
    var TabSpacing = ' border-spacing: inherit;';
  }  

  var table = "";
  var tablehead = "";
  var tablebodytext = "";
  for (var i = 0; i < colnum; i++) {
    tablehead += '<th style="background: '+headbackcolor+'; color: '+headfontcolor+';" height="19"></th>';
  }
  
  tablehead = '<thead>' + tablehead + '</thead>';

  var tablebody = [];
  for (var i = 0; i < rownum; i++) {
    var tablebodyrow = "";
    for (var i1 = 0; i1 < colnum; i1++) {
      if (i % 2 > 0) {
        tablebodyrow += '<td style="background: '+rowbackcolor_even+'; color: '+rowfontcolor_even+';" height="19"></td>';
      } else {
        tablebodyrow += '<td style="background: '+rowbackcolor+'; color: '+rowfontcolor+';" height="19"></td>';
      }

    }
    tablebody += "<tr>" + tablebodyrow + "</tr>";
  }
  
  tablebody = '<tbody>' + tablebody + '</tbody>';

  table = '<table style="background: '+tablebackcolor+'; margin: auto;'+TabSpacing+'" mobile-view="'+TabMobileView+'">' + tablehead + tablebody + '</table>';
  table = '<div class="table-wrapper">'+table+'</div>';

  var cursorPos = bo_editor[id].getLastCursorPosition();
  Cursor.setCurrentCursorPosition(cursorPos, bo_editor[id].editor[0]);

  bo_editor[id].styleText("insertHTML", table);
}