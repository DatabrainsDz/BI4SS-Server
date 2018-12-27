<?php

namespace Core;
class View {

   /**
    * Render a view file
    *
    * @param String $view the view file
    * @param array $data
    * @throws \Exception if file not found
    *
    * return void
    */
   public static function renderSimple($view, $data = []) {
      extract($data, EXTR_SKIP);
      $file = "../App/Views/$view";
      if (is_readable($file)) {
         require $file;
      } else {
         throw new \Exception("$file not found");
      }

   }

   public static function renderTemplate($template, $args = []) {
      static $twig = null;
      if ($twig === null) {
         $loader = new \Twig_Loader_Filesystem(dirname(__DIR__) . '/App/Views');
         $twig = new \Twig_Environment($loader);
      }
      echo $twig->render($template, $args);
   }
}