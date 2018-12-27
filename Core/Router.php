<?php

namespace Core;
class Router {
   protected $routes = [];
   protected $params = [];

   public function add($route, $params = [])
   {
      // convert the route to a regex: escape '/'
      $route = preg_replace('/\//', '\\/', $route);

      // convert variables ex: {controller}
      $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);

      // convert custom variables like id or maybe lang
      $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);

      // add start ^ and the end $;
      $route = '/^' . $route . '$/i';

      $this->routes[$route] = $params;
   }

   public function getRoutes()
   {
      return $this->routes;
   }

   /*
    * if match the url so add the params of url to params of Router
    * match url with table of routes
    */
   public function match($url)
   {
      foreach ($this->routes as $route => $params) {
         if (preg_match($route, $url, $matches)) {
            foreach ($matches as $key => $match) {
               if (is_string($key)) {
                  $params[$key] = $match;
               }
            }
            $this->params = $params;
            return true;
         }
      }
      return false;
   }

   public function dispatch($url)
   {
      $url = $this->removeQueryStringVariables($url);
      if ($this->match($url)) {
         $controller = $this->params["controller"];
         $controller = $this->convertToStudlyCaps($controller);
         $controller = $this->getNamespace() . $controller;

         if (class_exists($controller)) {
            $controller_object = new $controller($this->params);
            $action = $this->params['action'];
            $action = $this->convertToCamelCase($action);

            if (preg_match('/action$/i', $action) == 0) {
               $controller_object->$action();
            } else {
               throw new \Exception("Method {$action} not exist");
            }

         } else {
            throw new \Exception("Controller {$controller} not exist");
         }

      } else {
         throw new \Exception("Not Route Found for url: {$url}", 404);
      }
   }

   public function getParams()
   {
      return $this->params;
   }

   protected function convertToStudlyCaps($string)
   {
      return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
   }

   protected function convertToCamelCase($string)
   {
      return lcfirst($this->convertToStudlyCaps($string));
   }

   // for remove ?page=1&view=....
   protected function removeQueryStringVariables($url)
   {
      if ($url != '') {
         $parts = explode('&', $url, 2);
         if (strpos($parts[0], '=') === false) {
            $url = $parts[0];
         } else {
            $url = '';
         }
      }
      return $url;
   }

   protected function getNamespace()
   {
      $namespace = 'App\Controllers\\';
      if (array_key_exists('namespace', $this->params)) {
         $namespace .= $this->params['namespace'] . '\\';
      }
      return $namespace;
   }
}
