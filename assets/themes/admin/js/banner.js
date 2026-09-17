function cmsBannerLoadImgs(id) {
  var ajax = {
    method: 'GET',
    url: 'ajax.php?module=cms&submodule=banner&tab=images&file=list&id='+id,
    data: ''
  };

  bo_ajax(ajax).then(response => {
    var json = JSON.parse(response);
    cmsBannerLoadImgsAdd(id, json);

  }).catch(error => {
    //console.log(error);
  });
}

function cmsBannerLoadImgsAdd(id, json) {
  $(".banner-pic-list").eq(id).html('');

  var listHTML = '';

  for(var i = 0; i < json.length; i++) {
    listHTML += '<div class="pic-item"><div class="pic-cont"><img src="../'+json[i].image_thumb+'"></div><div class="pic-info"><input class="banner-pic-name" type="text" value="'+json[i].name+'" onkeyup="cmsBannerImgCaption('+json[i].id+', this.value)"/><div class="banner-pic-time">'+json[i].time_lastmod+'</div></div><div class="pic_btn_cont"><button class="pic-add"  data-editor-id="'+id+'" data-img-src="../'+json[i].image_full+'" data-img-caption="'+json[i].name+'"><i class="fa fa-paperclip" aria-hidden="true"></i> Adicionar ao banner</button><button class="pic-del" onclick="cmsBannerImgDel('+json[i].id+', this)"><i class="fa fa-trash" aria-hidden="true"></i> Remover da Lista</button></div></div>';
  }

  $(".banner-pic-list").eq(id).html(listHTML);
}

function cmsBannerImgDel(id, el) {
  var ajax = {
    method: 'GET',
    url: 'ajax.php?module=cms&submodule=banner&tab=images&file=delete&id='+id,
    data: ''
  };

  bo_ajax(ajax).then(response => {
    $(el).parent().parent().remove();
  }).catch(error => {
    //console.log(error);
  });
}

function cmsBannerImgCaption(id, value) {
  var ajax = {
    method: 'POST',
    url: 'ajax.php?module=cms&submodule=banner&tab=images&file=caption&id='+id,
    data: encodeURI("caption="+value)
  };

  bo_ajax(ajax).then(response => {
    //console.log(response);
  }).catch(error => {
    //console.log(error);
  });
}


var banner = document.querySelectorAll(".banner_subcontent");
  var bannerArray = [];

  $(".pic-sup-list").sortable({
        start: function(event, ui) {
            ui.item.data('start_pos', ui.item.index());
        },
        stop: function(event, ui) {
            var start_pos = ui.item.data('start_pos');
            if (start_pos != ui.item.index()) {
                // the item got moved
                //alert('Moved')
                console.log('List ID:'+$(this).data('editor-id'))
                getBannerList2($(this).data('editor-id'));
            } else {
                // the item was returned to the same position
                //alert('Same')
            }
        }
    });
    $(".pic-sup-list").disableSelection();

    function getBannerList2(id) {
      bannerArray = [];
      var zIndex = $(".pic-sup-item").length - 1;
      $(".pic-sup-list").eq(id).children(".pic-sup-item").each(
        function() {
          var pic = $(this).children(".pic-cont").children("img").attr("src");
          var width = $(this).children(".pic-data").children(".pic-width").children(".pic-width-input").val();
          var height = $(this).children(".pic-data").children(".pic-height").children(".pic-height-input").val();
          var top = $(this).children(".pic-data").children(".pic-top").children(".pic-top-input").val();;
          var left = $(this).children(".pic-data").children(".pic-left").children(".pic-left-input").val();
          var url = $(this).children(".pic-data").children(".pic-url").children(".pic-url-input").val();
          var title = $(this).children(".pic-data").children(".pic-title").children(".pic-title-input").val();

          if (url == null){
            url = "";
          }

          if (title == null){
            title = "";
          }

          var bannerItemArray = [pic, zIndex, width, height, top, left, url, title];
          bannerArray.push(bannerItemArray);

          zIndex--;
        }
      );

      //console.log(bannerArray);
      renderBanner(id);
      getBannerList(id);
    }

  function updateBanner() {
      /*
    Auto-save method

      fetch('ajax/catbannerupdate.php', {
        method: "POST",
        body: new FormData(document.getElementById('bannerUpdateForm')),
      });
      */
    }

    function getBannerList(id) {
      bannerArray = [];

      $(".pic-sup-list").eq(id).html("");

      $(".banner_subcontent").eq(id).children(".banner_pic_cont").each(function() {
        var wrapperWidth = $(".banner_subcontent").eq(id).width();
        var wrapperHeight = $(".banner_subcontent").eq(id).height();

        var zIndex = $(this).css("zIndex");
        var pic = $(this).children("a").children(".banner_pic").attr("src");
        var width = $(this).width() * 100 / wrapperWidth;
        var height = $(this).height() * 100 / wrapperHeight;
        var position = $(this).position();
        var top = position.top * 100 / wrapperHeight;
        var left = position.left * 100 / wrapperWidth;
        var url = $(this).children("a").attr("href");
        var title = $(this).prop("title");

        if (url == null){
          url = "";
        }

        if (title == null){
          title = "";
        }

        var bannerItemArray = [pic, zIndex, width, height, top, left, url, title];
        bannerArray.push(bannerItemArray);

        var item = '<div class="pic-sup-item"><div class="pic-cont"><img src="'+pic+'"></div><div class="pic-data"><div class="pic-url">Endereço URL:<input type="text" class="pic-url-input" value="'+url+'" placeholder="URL"></div><div class="pic-title">Legenda da Imagem: <input type="text" class="pic-title-input" placeholder="Legenda da Imagem" value="'+title+'"></div><div class="pic-zIndex">'+zIndex+'</div><div class="pic-width">Largura: <input type="number" class="pic-width-input" value="'+width+'"></div><div class="pic-height">Altura: <input type="number" class="pic-height-input" value="'+height+'"></div><div class="pic-top">Dist. ao Topo: <input type="number" class="pic-top-input" value="'+top+'"></div><div class="pic-left">Dist. à Esquerda: <input type="number" class="pic-left-input" value="'+left+'"></div></div><div class="pic_btn_cont"><button class="pic-edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar Imagem</button><button class="pic-remov"><i class="fa fa-trash" aria-hidden="true"></i> Remover do Banner</button></div></div>';

        $(".pic-sup-list").eq(id).append(item);
      });

      //console.log(bannerArray);
    }

  function renderBanner(id) {
      bannerLen = bannerArray.length;
      $(".banner_subcontent").eq(id).html("");

      for (var i = 0; i < bannerLen; i++) {
        var itemAuxTxt = '';
        var itemAuxTxt2 = '<img class="banner_pic" src="'+bannerArray[i][0]+'">';

        if (bannerArray[i][2] > 0 && bannerArray[i][3] > 0) {
          itemAuxTxt = ' width: '+bannerArray[i][2]+'%; height: '+bannerArray[i][3]+'%;';
        }

        if (bannerArray[i][6] != "") {
          itemAuxTxt2 = '<a href="'+bannerArray[i][6]+'">'+itemAuxTxt2+'</a>';
        } else {

          itemAuxTxt2 = '<a>'+itemAuxTxt2+'</a>';
        }

        var item = '<div class="banner_pic_cont" draggable="true" contenteditable="false" style="left: '+bannerArray[i][5]+'%; top: '+bannerArray[i][4]+'%;'+itemAuxTxt+' z-index: '+bannerArray[i][1]+';" title="'+bannerArray[i][7]+'">'+itemAuxTxt2+'</div>';
        $(".banner_subcontent").eq(id).append(item);
      }

      $('.banner_pic_cont').draggable({
        handle: 'img'
      }).resizable({
         handles: 'n, e, s, w, ne, se, sw, nw'
      });

      var target = $(".banner_subcontent").eq(id).data('target');
      $("#"+target).val($(".banner_subcontent").eq(id).html());
      updateBanner();
    }

    $(document).on("dragstop click", ".banner_pic_cont", function(event) {
    var id = $(this).parent().data('editor-id');
      getBannerList(id);
      renderBanner(id);
    });

  $(document).ready(function(){
    for (var i = banner.length - 1; i >= 0; i--) {
      cmsBannerLoadImgs(i);
      getBannerList(i);
    }
  });

  $(document).on("click", ".pic-add", function() {

      var bannerArrayOld = bannerArray;

      bannerArray = [];
      var zIndex = $(".pic-sup-item").length;
      $(".pic-sup-item").each(
        function() {
          var pic = $(this).children(".pic-cont").children("img").attr("src");
          var width = $(this).children(".pic-data").children(".pic-width").children(".pic-width-input").val();
          var height = $(this).children(".pic-data").children(".pic-height").children(".pic-height-input").val();
          var top = $(this).children(".pic-data").children(".pic-top").children(".pic-top-input").val();;
          var left = $(this).children(".pic-data").children(".pic-left").children(".pic-left-input").val();
          var url = $(this).children(".pic-data").children(".pic-url").children(".pic-url-input").val();
          var title = $(this).children(".pic-data").children(".pic-title").children(".pic-title-input").val();

          if (url == null){
            url = "";
          }

          if (title == null){
            title = "";
          }

          var bannerItemArray = [pic, zIndex, width, height, top, left, url, title];
          bannerArray.push(bannerItemArray);

          zIndex--;
        }
      );

      img = $(this).data('img-src');
      caption = $(this).data('img-caption');
      var bannerItemArray = [img, 0, 0, 0, 0, 0, "", caption];
      bannerArray.push(bannerItemArray);

      renderBanner($(this).data('editor-id'));
      getBannerList($(this).data('editor-id'));
    });

    $(document).on("input", ".picSearchInput", function() {
      var search = $(this).val();
      var id = $(this).data('editor-id');

      var ajax = {
      method: 'GET',
      url: 'ajax.php?module=cms&submodule=banner&tab=images&file=list&id='+id+'&search='+search,
      data: ''
    };

    bo_ajax(ajax).then(response => {
      var json = JSON.parse(response);
      cmsBannerLoadImgsAdd(id, json);

    }).catch(error => {
      //console.log(error);
    });

    });

    $(document).on("click", ".pic-edit", function() {
      var index = $(this).parent().parent().index();
      var id = $(this).parent().parent().parent().data('editor-id');

      var pic = $(this).children("a").children(".banner_pic").attr("src");
      var width = $(this).width();
      var height = $(this).height();
      var position = $(this).position();
      var top = position.left;
      var left = position.top;
      var url = $(this).children("a").attr("href");
      var title = $(this).prop("title");

      bannerArray[index][2] = $(this).parent().parent().children(".pic-data").children(".pic-width").children(".pic-width-input").val();
      bannerArray[index][3] = $(this).parent().parent().children(".pic-data").children(".pic-height").children(".pic-height-input").val();
      bannerArray[index][4] = $(this).parent().parent().children(".pic-data").children(".pic-top").children(".pic-top-input").val();
      bannerArray[index][5] = $(this).parent().parent().children(".pic-data").children(".pic-left").children(".pic-left-input").val();
      bannerArray[index][6] = $(this).parent().parent().children(".pic-data").children(".pic-url").children(".pic-url-input").val();
      bannerArray[index][7] = $(this).parent().parent().children(".pic-data").children(".pic-title").children(".pic-title-input").val();

      renderBanner(id);
    });

    $(document).on("input", ".pic-url-input, .pic-title-input, .pic-top-input, .pic-left-input, .pic-width-input, .pic-height-input", function() {
      $(this).parent().parent().parent().children(".pic_btn_cont").children(".pic-edit").click();
    });

    $(document).on("click", ".pic-remov", function() {
      var index = $(this).parent().parent().index();
      var id = $(this).parent().parent().parent().data('editor-id');

      $(".banner_subcontent").eq(id).children(".banner_pic_cont").eq(index).remove();
      $(this).parent().parent().remove();

      getBannerList(id);
      renderBanner(id);
    });