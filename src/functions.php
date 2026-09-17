<?php

function view(string $page, array $data, bool $single = false, int $status_code = 200, bool $print = true) {
  http_response_code($status_code);

  if(session_status() !== PHP_SESSION_ACTIVE)  {
    session_start();
  }

  $site = array(
    "domain" => SITE_CONFIGS['info']['domain'],
    "baseURL" => SITE_CONFIGS['info']['baseURL'],
    "name"  => SITE_CONFIGS['info']['name'],
    "logo" => SITE_CONFIGS['info']['logo'],
  );

  if (empty(SITE_CONFIGS['info']['baseURL'])) {
    $baseURL = '/';
  } else {
    $baseURL = SITE_CONFIGS['info']['baseURL'];
  }

  $siteInfo = Site::info();

  //Cart::load();

  if (is_array($data)) {
    extract($data);
  }

  ob_start();

  $path = explode('/', $page);

  if ($single) {
    if (in_array($path[0], array('emails', 'sitemap', 'admin'))) {
      require __DIR__.'/App/Views/'.$page.'.php';
    } else {
      require __DIR__.'/App/Views/pages/'.$page.'.php';
    }
  } else {
    /*
    $fixedModel = new Models\Fixed();
    $headerMenu = $fixedModel->headerMenu();

    $footer = $fixedModel->footer();
    */

    if (in_array($path[0], array('admin'))) {
      require __DIR__.'/App/Views/admin/_static/layout.php';
    } else {
      require __DIR__.'/App/Views/_static/layout.php';
    }
  }

  $output = ob_get_clean();

  if ($print) {
    Form::clear();
    echo $output;
  }

  return $output;
}

function adminView(array $file, array $data, int $status_code = 200, bool $print = true) {
  http_response_code($status_code);

  if(session_status() !== PHP_SESSION_ACTIVE)  {
    session_start();
  }

  $site = array(
    "domain" => SITE_CONFIGS['info']['domain'],
    "baseURL" => SITE_CONFIGS['info']['baseURL'],
    "name"  => SITE_CONFIGS['info']['name'],
    "logo" => SITE_CONFIGS['info']['logo'],
  );

  if (empty(SITE_CONFIGS['info']['baseURL'])) {
    $baseURL = '/';
  } else {
    $baseURL = SITE_CONFIGS['info']['baseURL'];
  }

  $siteInfo = Site::info();

  if (is_array($data)) {
    extract($data);
  }

  ob_start();

  require __DIR__.'/App/Views/admin/_static/layout.php';

  $output = ob_get_clean();

  if ($print) {
    Form::clear();
    echo $output;
  }

  return $output;
}

function json_return(array $data, int $status_code=200) {
  header('Content-Type: application/json;charset=utf-8');
  http_response_code($status_code);
  $json = json_encode($data);
  echo $json;
}

function redirect(string $link, $external = false) {
  if (!$external) {
    $link = SITE_CONFIGS['info']['baseURL'].$link;
  }

  if (!headers_sent()) {
    header('Location: '.$link);
    exit;
  } else {
    echo '<script type="text/javascript">window.location = "'.$link.'"</script>';
  }
}

function old(string $field) {
  return Form::getOld($field);
}

function dd($var) {
  ?><div style="white-space: pre-wrap; background: #000; color: #fff; font-family: Verdana, Arial; font-size: 13.5px; padding: 8px 12px; line-height: 18px; min-width: 100%; box-sizing: border-box; text-align: left;"><?php var_dump($var); ?></div><?php
  die();
}

function requireFolder(string $pathToFolder, bool $recursive=true) {
  $folder = scandir($pathToFolder);
  foreach ($folder as $folderIndex => $folderChild) {
      if (!in_array($folderChild, array('.', '..'))) {
          $childPath = $pathToFolder . '/'. $folderChild;
          if (is_dir($childPath) && $recursive) {
              //Require files from nested folders
              //If $recursive is true
              requireFolder($childPath);
          } else {
              //require file
              require_once $childPath;
          }
      }
  }
}

function readJSONFile(string $filePath) {
  $json = file_get_contents($filePath);
  $data = json_decode($json, true);
  return $data;
}

function requireJSONFolder(string $pathToFolder) {
  $data = array();

  $folder = scandir($pathToFolder);
  foreach ($folder as $folderIndex => $folderChild) {
    if (!in_array($folderChild, array('.', '..'))) {
      $childPath = $pathToFolder . '/'. $folderChild;
      if (is_dir($childPath) && $recursive) {
        //Require files from nested folders
        //If $recursive is true
        $folderData = requireJSONFolder($childPath);
        $data = array_merge($data, $folderData);
      } else {
        //require JSON file
        $fileData = readJSONFile($childPath);
        $data = array_merge($data, $fileData);
      }
    }
  }

  return $data;
}

function exists(&$var) {
  if (isset($var) && !empty($var)) {
    return true;
  } else {
    return false;
  }
}

function fileTryLoop(array $files) {
  foreach ($files as $file) {
    if (file_exists($file)) {
      return $file;
    }
  }
  return false;
}

function arrayMergeAll(array $arrays) {
  $output = array();

  foreach ($arrays as $array) {
    $output = array_merge($output, $array);
  }

  return $output;
}

function showFormErrors(&$errors) {
  //$errors should come from Form class

  if(exists($errors)) {
  ?>
    <div class="form_input_error">
      <?php foreach ($errors as $errorKey => $errorMsg): ?>
        <small><?= $errorMsg ?></small>
      <?php endforeach; ?>
    </div>
  <?php
  }
}

function encode($str, $to='UTF-8') {
  //iso 8859-1 -> 'ISO-8859-1'
  $from = mb_detect_encoding($str);
  $str = mb_convert_encoding($str, $to, $from);
  
  return $str;
}


function projectLink($pathShort) {
  return SITE_CONFIGS['info']['baseURL'].$pathShort;
}

function crawlPage($url, $options = array(), &$error = null) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);

  if(exists($options['post_fields'])) {
    curl_setopt($ch, CURLOPT_POST,1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $options['post_fields']);
  }

  //curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17');
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36');
  curl_setopt($ch, CURLOPT_AUTOREFERER, true);  
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  //curl_setopt($ch, CURLOPT_VERBOSE, 1);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);


  if (exists($options['page_encoding'])) {
    curl_setopt($ch,CURLOPT_ENCODING, $options['page_encoding']);
  }

  $page = curl_exec($ch);

  if (curl_errno($ch)) {
    $error = curl_errno($ch).': '.curl_error($ch);
  }

  if (exists($options['page_encoding'])) {
    $page = mb_convert_encoding($page, 'UTF-8', $options['page_encoding']);
  }

  curl_close($ch);

  if (exists($options['remove_breaks'])) {
    $page = removePageBreaks($page);
  }

  return $page;
}

function removePageBreaks($page) {
  //Removing line breaks
  $page = str_replace(array("\r", "\n"), '', $page);

  //$page = preg_replace( "/\r|\n/", "", $page);

  //Removing white space between elements
  $page = str_replace("> ", ">§", $page);
  $page = str_replace(" <", "§<", $page);
  $hasSpace = true;
  while($hasSpace) {
    if (strpos($page, "§ ") !== false) {
      $page = str_replace("§ ", '§', $page);
    } elseif (strpos($page, " §") !== false) {
      $page = str_replace(" §", '§', $page);
    } else {
      $hasSpace = false;
    }
  }
  $page = str_replace("§", "", $page);

  //$page = trim($page);

  return $page;
}


if (!function_exists('mb_ucwords')) {
  function mb_ucwords($str) {
    return mb_convert_case($str, MB_CASE_TITLE, "UTF-8");
  }
}
/*
ADMIN FUNCTIONS



function adminSidebarMenu($parent) {
  $sql = "SELECT admin_menu_items.*, admin_menu_items_lang.title, admin_menu_items_lang.description, admin_permissions.name as permission_name, admin_permission_categories.name as permission_group FROM admin_menu_items LEFT JOIN admin_menu_items_lang ON admin_menu_items_lang.parent = admin_menu_items.id AND admin_menu_items_lang.fk_lang = 1 LEFT JOIN admin_permissions ON admin_menu_items.permission_show = admin_permissions.id LEFT JOIN admin_permission_categories ON admin_permissions.parent = admin_permission_categories.id WHERE admin_menu_items.parent = $parent AND active = 1 ORDER BY -admin_menu_items.pos DESC";
  $menuItems = DB::results($sql);
  
  
  $menu = '';
  $activeMenu = false;
  foreach ($menuItems as $menuItemKey => $menuItem) {
    $active = false;

    $parsingURL = parse_url($menuItem['link']);
    parse_str($parsingURL['query'], $parsedURL);

    //Checking if $_GET is equal,
    //ignoring $_GET['page']
    $get = array();
    foreach ($_GET as $get_key =>$get_val) {
      if ($get_key != 'page') {
        $get[$get_key] = $get_val;
      }
    }

    if ($get == $parsedURL) {
      $is_active = true;
    } else {
      $is_active = false;
    }

    if ($is_active) {
      $active = true;
    }

    if ($parent == 0 && isset($_GET['module']) && $_GET['module'] == $parsedURL['module']) {
      $active = true;
    }
    

    $item = '';
    $submenuToggle = '';
    $children = sidebar_menu($menuItem['id']);

    if (isset($children['active'])) {
      if ($children['active']) {
        $active = true;
      }
    }

    if (!empty($children['menu'])) {
      if ($active) {
        $submenuToggle .= '<div class="bo_sidemenu_sub_toggle" onclick="sideMenuSubToggle('.$menuItem['id'].')"><div id="sideMenuBtn-'.$menuItem['id'].'" class="bo_sidemenu_sub_toggle_inner"><i class="fa fa-caret-down" aria-hidden="true"></i></div></div>';
        $bo_sidemenu_sub_hid = '';
      } else {
        $submenuToggle .= '<div class="bo_sidemenu_sub_toggle" onclick="sideMenuSubToggle('.$menuItem['id'].')"><div id="sideMenuBtn-'.$menuItem['id'].'" class="bo_sidemenu_sub_toggle_inner"><i class="fa fa-caret-right" aria-hidden="true"></i></div></div>';
        $bo_sidemenu_sub_hid = ' hidden';
      }
      $item .= '<div id="sideMenuSub-'.$menuItem['id'].'" class="bo_sidemenu_sub'.$bo_sidemenu_sub_hid.'">'.$children['menu'].'</div>';
    }
    if (empty($menuItem['title'])) {
      $menuItem['title'] = '('.$menuItem['name'].')';
    }

    if ($active) {
      $activeClass = ' active';
      $activeMenu = true;
    } else {
      $activeClass = '';
    }

    if (permission_check($menuItem['permission_group'], $menuItem['permission_name'])) {
      //Show item
      $item = '<div class="bo_sidemenu_item"><div class="bo_sidemenu_item_top">'.$submenuToggle.'<a href="'.$menuItem['link'].'"><div class="bo_sidemenu_item_name'.$activeClass.'">'.$menuItem['title'].'</div></a></div>'.$item.'</div>';
    } else {
      //If there is a visible child, show name and include visible children
      //Otherwise, don´t show
      if (!empty($children['menu'])) {
        $item = '<div class="bo_sidemenu_item"><div class="bo_sidemenu_item_top">'.$submenuToggle.'<div class="bo_sidemenu_item_name'.$activeClass.'">'.$menuItem['title'].'</div></div>'.$item.'</div>';
      }
    }
    $menu .= $item;
  }
  return array(
    "active" => $activeMenu,
    "menu" => $menu
  );
}

*/
?>
