<?php

class Router {
  
  public static $routes = array();
  public static $redirects = array();

  public static function start() {
    //Visit::log();
    $path = Request::getPath();
    $pathShort = $path['shortPath'];
    
    if (!self::checkRedirects($pathShort)) {
      if (!self::checkRoutes($pathShort)) {
        \Lang\Lang::default();
        /* 404 Error */
        $controller = 'Controllers\Error';

        //dd($path);

        if (exists($path['parsedShortPath'][1]) && $path['parsedShortPath'][1] == 'api') {
          $controller::apiMethodNotFound();
        } else {
          $controller::pageNotFound();
        }
      }
    }
  }

  protected static function checkRedirects($pathShort) {
    //Find if this url must be redirected
    foreach (self::$redirects as $from => $to) {
      if (self::isMatch($pathShort, $from)) {
        //Match was found;
        $parameters = self::getURLParams(self::$redirects, $from);
        $toRealPath = self::redirToPath($to, $parameters);
        
        http_response_code(301);
        redirect($toRealPath);
        return true;
      }
    }
  }

  protected static function checkRoutes($pathShort) {
    //Finding which is the approriate route, via regex
    $req_start = $_REQUEST;

    foreach (self::$routes[\Request::method()] as $route => $controller) {
      if (!self::urlLevelsCheck($route, $pathShort)) {
        continue;
      }

      self::clearRequest($req_start);

      if (self::isMatch($pathShort, $route)) {
        
        $params = self::getURLParams(self::$routes[\Request::method()], $route);
        self::addToRequest($params);

        if (!\Lang\Lang::checkInURL()) {
          continue;
        }

        if (strpos($route, '/admin') == 0) {
          \Lang\Lang::checkInURL('admin');
        }

        if (is_callable($controller)) {
          if(!self::callFunction($controller, $params)) {
            print($route.' - called method');
            continue;
          }
        } else {
          $method = self::controllerParamReplace($controller, $params);

          if (!self::callController($method['method'], $method['arguments'])) {
            continue;
          }
        }

        return true;
      }
    }

    return false;
  }

  protected static function removeFinalSlash($path) {
    if (mb_substr ($path, -1) == '/') {
      $path = substr_replace($path ,"",-1);
    }

    return $path;
  }

  protected static function isMatch($currentPath, $route) {
    $currentPath = self::removeFinalSlash($currentPath);
    $route = self::removeFinalSlash($route);
    
    $route_regex = preg_replace(array('/\{int:(.*?)\}/', '/\{(.*?)\}/') , array('([0-9]+)', '(.*)'), $route);
    $route_regex = str_replace('/', '\/', $route_regex);
    $route_regex = '/'.$route_regex.'$/iDA';

    if (preg_match($route_regex, $currentPath)) {
      return true;
    }

    return false;
  }

  protected static function getURLParams(&$routeGroup, $route) {
    $path = \Request::getPath();
    $path = $path['parsedShortPath'];

    $params = array();
    $routeParams = explode("/", $route);
    $newParams = array();

    foreach($routeParams as $index => $param){
      if (preg_match('/\{int:(.*?)\}/', $param)) {
        if(isset($path[$index])){
          $param = str_replace(array('{int:', '}'), array('', ''), $param);
          $newParams[$param] = $path[$index];
        }
      } elseif(preg_match('/\{(.*?)\}/', $param)){       
        if(isset($path[$index])){
          $param = str_replace(array('{', '}'), array('', ''), $param);
          $newParams[$param] = $path[$index];  
        }
      }
    }

    return $newParams;
  }

  protected static function urlLevelsCheck($route, $realPath) {
    $realPath = self::removeFinalSlash($realPath);
    $route = self::removeFinalSlash($route);

    $route_count = explode('/', $route);
    $realPath_count = explode('/', $realPath);

    if (count($route_count) == count($realPath_count)) {
      return true;
    }

    return false;
  }

  protected static function controllerParamReplace($controller, $params) {
    $method = explode("(", $controller);
    $methodName = $method[0];

    $argumentVars = array();
    $arguments = array();
    if(count($method) == 2) {
      $method[1] = str_replace(')', '', $method[1]);
      $argumentVars = explode(', ', $method[1]);
      foreach ($argumentVars as $argumentVar) {
        if (strpos($argumentVar, '$') !== false) {
          $param = str_replace('$', '', $argumentVar);
          if (isset($params[$param])) {
            $value = \DB::escape_string($params[$param]);
          } else {
            $value = null;
          }
        } else {
          $value = \DB::escape_string($argumentVar);
        }
               
        array_push($arguments, $value);
      }
    }

    $output = array(
      "method" => $methodName,
      "arguments" => $arguments,
    );

    return $output;
  }

  protected static function callController($controller, $arguments = null){
    $controller = explode(".", $controller);   
    $class = 'Controllers\\'.''.$controller[0];
    $method = $controller[1];

    $argTxt = implode(', ', $arguments);
    if (class_exists($class) && method_exists($class, $method)) {
      call_user_func_array(array($class, $method), $arguments);
      return true;
    }
 
    return false; 
  }

  //For a function defined in the 3rd argument
  protected static function callFunction($function, $params = null) {
    $reflection = new ReflectionFunction($function);
    $arguments  = $reflection->getParameters();

    $parameters= array();
    foreach($arguments as $arg) {
      $parameters[$arg->name] = null;
    }

    foreach($parameters as $key => $value) {
      if (exists($params[$key])) {
        $parameters[$key] = $params[$key];
      }
    }

    if(call_user_func_array($function, $parameters) !== false) {
      return true;
    } else {
      return false;
    }
    
  }

  //Replaces parameters
  protected static function redirToPath($to, $parameters) {
    foreach ($parameters as $key => $value) {
      $to = preg_replace('/{'.$key.'}/i', $value, $to);
    }

    return $to;
  }

  protected static function filterSpecialOptionalUrlParams($path) {
    $routes = array();

    $pattern = '/\[(.*?)\]/m';
    preg_match_all($pattern, $path, $matches, PREG_SET_ORDER, 0);  

    $i = 0;
    while($i < count($matches)) {
      $pathNew = str_replace($matches[$i][0], $matches[$i][1], $path);
      $path = str_replace($matches[$i][0], '', $path);
      
      $pathNew = str_replace('[', '', $pathNew);
      $pathNew = str_replace(']', '', $pathNew);

      array_push($routes, $pathNew);
      $i++;
    }

    array_push($routes, $path);
    return $routes;
  }

  protected static function filterOptionalUrlParams($path) {
    $routes = array();

    $pattern = '/\((.*?)\)/m';
    preg_match_all($pattern, $path, $matches, PREG_SET_ORDER, 0);  

    $i = count($matches) - 1;

    while($i >= 0) {
      $pathNew = str_replace($matches[$i][0], $matches[$i][1], $path);
      $path = str_replace($matches[$i][0], '', $path);
      
      $pathNew = str_replace('(', '', $pathNew);
      $pathNew = str_replace(')', '', $pathNew);

      $routes = array_merge($routes, self::filterSpecialOptionalUrlParams($pathNew));
      $i--;
    }

    $routes = array_merge($routes, self::filterSpecialOptionalUrlParams($path));

    return $routes;
  }
  
  public static function route($httpMethod, $path, $controller) {
    $routes = self::filterOptionalUrlParams($path);

    foreach($routes as $route) {
      self::$routes[$httpMethod][$route] = $controller;
    }
  }

  public static function redirect($from, $to) {
    $routes = self::filterOptionalUrlParams($from);

    foreach($routes as $route) {
      self::$redirects[$route] = $to;
    }
  }
  
  public static function clear(){
    unset(self::$routes[Request::method()]);
  }

  public static function clearRedir(){
    unset(self::$redirects);
  }
  
  protected static function clearRequest($req = nul) {
    $_REQUEST = array();
    self::addToRequest($req);
  }

  protected static function addToRequest($params) {    
    foreach ($params as $key => $value) {
      $_REQUEST[$key] = $value;
    }
  }

}
