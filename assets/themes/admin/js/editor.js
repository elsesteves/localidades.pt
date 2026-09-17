// Credit to Liam (Stack Overflow)
// https://stackoverflow.com/a/41034697/3480193
class Cursor {
    static getCurrentCursorPosition(parentElement) {
        var selection = window.getSelection(),
            charCount = -1,
            node;
        
        if (selection.focusNode) {
            if (Cursor._isChildOf(selection.focusNode, parentElement)) {
                node = selection.focusNode; 
                charCount = selection.focusOffset;
                
                while (node) {
                    if (node === parentElement) {
                        break;
                    }

                    if (node.previousSibling) {
                        node = node.previousSibling;
                        charCount += node.textContent.length;
                    } else {
                        node = node.parentNode;
                        if (node === null) {
                            break;
                        }
                    }
                }
            }
        }
        
        return charCount;
    }
    
    static setCurrentCursorPosition(chars, element) {
        if (chars >= 0) {
            var selection = window.getSelection();
            
            let range = Cursor._createRange(element, { count: chars });

            if (range) {
                range.collapse(false);
                selection.removeAllRanges();
                selection.addRange(range);
            }
        }
    }
    
    static _createRange(node, chars, range) {
        if (!range) {
            range = document.createRange()
            range.selectNode(node);
            range.setStart(node, 0);
        }

        if (chars.count === 0) {
            range.setEnd(node, chars.count);
        } else if (node && chars.count >0) {
            if (node.nodeType === Node.TEXT_NODE) {
                if (node.textContent.length < chars.count) {
                    chars.count -= node.textContent.length;
                } else {
                    range.setEnd(node, chars.count);
                    chars.count = 0;
                }
            } else {
                for (var lp = 0; lp < node.childNodes.length; lp++) {
                    range = Cursor._createRange(node.childNodes[lp], chars, range);

                    if (chars.count === 0) {
                    break;
                    }
                }
            }
        } 

        return range;
    }
    
    static _isChildOf(node, parentElement) {
        while (node !== null) {
            if (node === parentElement) {
                return true;
            }
            node = node.parentNode;
        }

        return false;
    }
}

/*

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
        return item.el.attr('title');
      }
    }
    // other options
  });
});


function textChange() {
  var str = $("#editor").contents().find("body").html();
  $("#page_body").val(str);
}

*/

var editor = document.querySelectorAll("iframe.editor");

function textChange(i) {
  var str = editor[i].contentWindow.document.body.innerHTML;
  var target = $("#editor-"+i).data('target');
  console.log('Target: #'+target);
  $("#"+target).val(str);
}

$(document).ready(function(){
  for (var i = editor.length - 1; i >= 0; i--) {
    editor[i].contentDocument.designMode = "on";
    cmsLoadImgs(i);
  }
});


$("iframe").on("load", function(){
  var i = $(this).data('id');
  $(this).contents().on("change keyup click onmouseup", function(){
    textChange(i);
  });
});

window.addEventListener("load",function(){

  $('.UndoButton').click(function(){
    var i = $(this).data('editor-id');
    editor[i].contentWindow.document.execCommand("Undo",false,null);
    textChange(i);
  });

  $('.RedoButton').click(function(){
    var i = $(this).data('editor-id');
    editor[i].contentWindow.document.execCommand("Redo",false,null);
    textChange(i);
  });

  $('.BoldButton').click(function(){
    var i = $(this).data('editor-id');
    editor[i].contentWindow.document.execCommand("Bold", false, null);
    textChange(i);
  });

  $('.ItalicButton').click(function(){
    var i = $(this).data('editor-id');
    editor[i].contentWindow.document.execCommand("Italic", false, null);
    textChange(i);
  });

  $('.UnderlineButton').click(function(){
    var i = $(this).data('editor-id');
    editor[i].contentWindow.document.execCommand("Underline", false, null);
    textChange(i);
  });

  $('.StrikeButton').click(function(){
    var i = $(this).data('editor-id');
    editor[i].contentWindow.document.execCommand("Strikethrough", false, null);
    textChange(i);
  });

  $('.SupButton').click(function(){
    var i = $(this).data('editor-id');
    editor[i].contentWindow.document.execCommand("Superscript", false, null);
    textChange(i);
  });

  $('.SubButton').click(function(){
    var i = $(this).data('editor-id');
    editor[i].contentWindow.document.execCommand("Subscript", false, null);
    textChange(i);
  });

  $('.OrderedListButton').click(function(){
    var i = $(this).data('editor-id');
    editor[i].contentWindow.document.execCommand("InsertOrderedList", false, "New" + Math.round(Math.random() *1000));
    textChange(i);
  });

  $('.UnorderedListButton').click(function(){
    var i = $(this).data('editor-id');
    editor[i].contentWindow.document.execCommand("InsertUnorderedList", false, null);
    textChange(i);
  });

  $('.LeftAlignButton').click(function(){
    var i = $(this).data('editor-id');
    editor[i].contentWindow.document.execCommand("justifyLeft", false, null);
    textChange(i);
  });

  $('.CenterAlignButton').click(function(){
    var i = $(this).data('editor-id');
    editor[i].contentWindow.document.execCommand("justifyCenter", false, null);
    textChange(i);
  });

  $('.RightAlignButton').click(function(){
    var i = $(this).data('editor-id');
    editor[i].contentWindow.document.execCommand("justifyRight", false, null);
    textChange(i);
  });

  $('.FullAlignButton').click(function(){
    var i = $(this).data('editor-id');
    editor[i].contentWindow.document.execCommand("justifyFull", false, null);
    textChange(i);
  });

  $('.AddLinkButton').click(function(){
    var i = $(this).data('editor-id');

    var prompt_object = {
      title: 'Adicionar Link URL',
      msg: 'Introduza um endereço URL',
      inputs: [
        {
          type: 'text',
          class: 'bo_cms_link',
          value: 'http://',
          label: 'URL:'
        },
        {
          type: 'checkbox',
          class: 'bo_cms_link_blank',
          value: '',
          label: 'Abrir num novo separador?'
        }
      ],
      buttons: [
        {
          text: 'Cancelar',
          function: 'bo_prompt_close',
          arguments: '',
          class: 'bo_prompt_cancel'
        },
        {
          text: 'Confirmar',
          function: 'addCmsLink',
          arguments: [i],
          class: ''
        }
      ]
    };
    bo_prompt(prompt_object);

  });



  $('.RemoveLinkButton').click(function(){
    var i = $(this).data('editor-id');
    editor[i].contentWindow.document.execCommand("Unlink",false,null);
    textChange(i);
  });



  $(document).on("change", '.FontColorButton', function(event){
    var i = $(this).data('editor-id');
    editor[i].contentWindow.document.execCommand("ForeColor", false, event.target.value);
    textChange(i);
  });

  $(document).on("change", '.HighlightButton', function(event){
    var i = $(this).data('editor-id');
    editor[i].contentWindow.document.execCommand("BackColor", false, event.target.value);
    textChange(i);
  });

  $(document).on("change", '.HeadingChanger', function(event){
    var i = $(this).data('editor-id');
    editor[i].contentWindow.document.execCommand("formatBlock", false, event.target.value);
    textChange(i);
  });

  $(document).on("change", '.FontChanger', function(event){
    var i = $(this).data('editor-id');
    editor[i].contentWindow.document.execCommand("FontName", false, event.target.value);
    textChange(i);
  });

  $(document).on("change", '.FontChanger', function(event){
    var i = $(this).data('editor-id');
    editor[i].contentWindow.document.execCommand("FontName", false, event.target.value);
    textChange(i);
  });

  $(document).on("change", '.FontSizeChanger', function(event){
    var i = $(this).data('editor-id');
    editor[i].contentWindow.document.execCommand("FontSize", false, event.target.value);
    textChange(i);
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
  var editor_html = editor[i].contentWindow.document.body.innerHTML;
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
  editor[id].contentWindow.document.execCommand("insertHTML",false, imagerect);
  textChange(id);
}




$(document).on("click", ".menu_close_btn", function() {
  $(this).parent().parent().addClass("hidden");
});

function addCmsLink(i) {
  var cms_link = $(".bo_cms_link").val();

  if($(".bo_cms_link_blank").is(':checked')){
    var sText = editor[i].contentWindow.document.getSelection();
    editor[i].contentWindow.document.execCommand('insertHTML', false, '<a href="' + cms_link + '" target="_blank">' + sText + '</a>');
  } else {
    editor[i].contentWindow.document.execCommand("CreateLink", false, cms_link);
  }

  textChange(i);
}

$(document).on("click", ".pagevid_url_btn", function() {
  var i = $(this).data('editor-id');
  var youtube = $(this).parent().children(".pagevid_url_input").val();
  var youtube = youtube.replace("https://www.youtube.com/watch?v=", "");
  var videorect = '<div class="vidcase" contenteditable="false" style="margin: 0 auto;"><div class="vidcase_inner"><iframe src="https://www.youtube.com/embed/'+youtube+'"></iframe></div></div><br><br>';
  editor[i].contentWindow.document.execCommand("insertHTML",false, videorect);
  
  textChange(i);
});

$(document).on("click", ".page_code_btn", function() {
  var i = $(this).data('editor-id');
  var src_code = $("#code_src_"+i).val();
  editor[i].contentWindow.document.body.innerHTML = src_code;

  textChange(i);
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

  editor[id].contentWindow.document.execCommand("insertHTML",false, table);
  textChange(id);
}