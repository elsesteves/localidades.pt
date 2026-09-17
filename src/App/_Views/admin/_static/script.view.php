<script type="text/javascript">
  var ajaxBaseLink = "<?= projectLink("/admin/ajax") ?>";
</script>

<script type="text/javascript" src="<?= $site['baseURL'] ?>/assets/themes/admin/js/main.js<?= $noCache; ?>"></script>

<script type="text/javascript">

  function adminLangChange(adminLang) {
    <?php
      $getArr = array();
      foreach ($_GET as $getKey => $getValue) {
        array_push($getArr, "$getKey=$getValue");
      }
      $getTxt = implode("&", $getArr);
    ?>
    var link = '?<?= !empty($getTxt) ? $getTxt.'&' : '' ?>admin_lang='+adminLang;

    window.location = link;
  }

  function adminAJAX(ajaxObject) {
    var xhr = new XMLHttpRequest();
    return new Promise(function(resolve, reject) {
     xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {

          switch (xhr.status) {
            case 200:
              resolve(xhr.responseText);
              break;
            default:
              var json = JSON.parse(xhr.responseText);
              console.log(json);

              var alertObject = {
                title: '<i class="fa fa-exclamation" aria-hidden="true"></i> '+json.code+' | '+json.title,
                msg: json.msg,
                buttons: [
                  {
                    text: 'OK',
                    function: 'bo_alert_close',
                    arguments: '',
                    class: ''
                  }
                ]
              };
              bo_alert(alertObject);
              reject(false);
          }
          
        }
      }
      xhr.open(ajaxObject.method, ajaxObject.url);
      if (typeof ajaxObject.data === 'string') {
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      }      
      xhr.send(ajaxObject.data);
    });
  }

</script>