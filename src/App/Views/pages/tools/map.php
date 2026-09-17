<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Maps | EstevesWeb</title>

  <meta name="author" content="Esteves Web">
  <meta name="distribution" content="Global">
  <meta name="rating" content="General">
  <meta name="expires" content="Never">
  <meta name="robots" content="Index, Follow">
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <link rel="shortcut icon" href="<?= $site['baseURL'] ?>/assets/images/logo/logo.png">

  <link rel="icon" type="image/png" sizes="16x16" href="<?= $site['baseURL'] ?>/assets/images/favicon/favicon-16x16.png">
  <link rel="icon" type="image/png" sizes="32x32" href="<?= $site['baseURL'] ?>/assets/images/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="<?= $site['baseURL'] ?>/assets/images/favicon/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="256x2566" href="<?= $site['baseURL'] ?>/assets/images/favicon/favicon-256x256.png">

  <link href='https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900' rel='stylesheet'>
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

  <?php if (file_exists(__PROJECT_ROOT__.'/assets/themes/localidades/css/global.min.css')) : ?>
    <link rel="stylesheet" href="<?= $site['baseURL'] ?>/assets/themes/localidades/css/global.min.css" />
  <?php else: ?>
    <link rel="stylesheet" href="<?= $site['baseURL'] ?>/assets/themes/localidades/css/global.css" />
  <?php endif; ?>

  <link rel="stylesheet" type="text/css" href="<?= $site['baseURL'] ?>/assets/themes/localidades/css/map.css">

  <link rel="stylesheet" type="text/css" href="<?= $site['baseURL'] ?>/assets/plugins/leaflet/leaflet.css">
  <link rel="stylesheet" type="text/css" href="<?= $site['baseURL'] ?>/assets/plugins/leaflet/leaflet-search-master/src/leaflet-search.css">
</head>
<body>

  <div id="map-wrap">
    <div id="map-left">
      <div id="map-box" class="full">

        <div id="map-right">
          <div id="map-info">
            
          </div>
          <div id="weather-wrap">
            <div id="current-weather">
              <div class="temp"></div>
              <div class="cond"></div>
              <div class="humid"></div>
            </div>
          </div>
        </div>

        <div id="map_wrap">
          <div id="map" class="map"></div>
        </div>

        <div id="toggle_side_show" class="">
          <i class="fa fa-angle-double-<?= \Device::isMobile() ? 'up' : 'right' ?>" aria-hidden="true"></i>
        </div>
      </div>
      
      <div id="side-box" class="hidden">

        <div id="toggle_side_hide">
          <i class="fa fa-angle-double-<?= \Device::isMobile() ? 'down' : 'left' ?>" aria-hidden="true"></i>
        </div>

        <div id="route_input_wrap">
          <div id="start_route_input_box" class="route_input_box" onclick="toggleRouteStart()">
            <label><?= \Lang\Dictionary::get('departure') ?></label>
            <div class="marker">
              <i class="fa fa-map-marker" aria-hidden="true"></i>
            </div>
          </div>
          <div id="end_route_input_box" class="route_input_box" onclick="toggleRouteEnd()">
            <label><?= \Lang\Dictionary::get('destination') ?></label>
            <div class="marker">
              <i class="fa fa-map-marker" aria-hidden="true"></i>
            </div>
          </div>
        </div>

        <input type="text" name="" id="map_search_input" onchange="search(this.value)" placeholder="<?= \Lang\Dictionary::get('search_location') ?>">
        <div id="result-box">
          
        </div>
        <div id="directions-wrap" style="display: none;">
          <div id="directions-loading_box">
            <div class="spinner"></div>
            <span><?= \Lang\Dictionary::get('map_directions_loading') ?></span>
          </div>
          <div id="directions-box"></div>
        </div>
      </div>
    </div>   
    
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script type="text/javascript" src="<?= $site['baseURL'] ?>/assets/plugins/leaflet/leaflet.js"></script>
  <script type="text/javascript" src="<?= $site['baseURL'] ?>/assets/plugins/leaflet/leaflet-search-master/src/leaflet-search.js"></script>

  <script type="text/javascript" src="<?= $site['baseURL'] ?>/assets/plugins/leaflet/leaflet-search-master/src/leaflet-search-geocoder.js"></script>

  <script type="text/javascript">
    var lat = <?= $coords['lat'] ?>;
    var lng = <?= $coords['lon'] ?>;
    var z = <?= $coords['z'] ?>;

    var humidityName = '<?= \Lang\Dictionary::get('humidity') ?>';
    var askUserGeoLocation = <?= $geolocation ?>;
    var baseURL = '<?= $site['baseURL'] ?>';
    var polylineColor = "#186a32";

    var viewMoreInfoTxt = '<?= \Lang\Dictionary::get('view_more_info') ?>';
    var markAsDestinationTxt = '<?= \Lang\Dictionary::get('mark_as_destination') ?>';
  </script>
  <script type="text/javascript" src="<?= $site['baseURL'] ?>/assets/themes/localidades/js/map.js"></script>

</body>
</html>




