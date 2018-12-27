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
   public static function render($view, $data = []) {
      extract($data, EXTR_SKIP);

      $file = "../App/Views/$view";
      if (is_readable($file)) {
         require $file;
      } else {
         throw new \Exception("$file not found");
      }

   }
}