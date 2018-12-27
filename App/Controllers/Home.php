<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;

class Home extends Controller {
   public function indexAction()
   {
      $data = [
         'title'  => 'Home',
         'colors' => ['red', 'green', 'blue'],
      ];
      View::render("Home/index.php", $data);
   }


   protected function before()
   {
//      echo '(before) ';
//      return false ; // if you don't want execute the last of code
   }

   protected function after()
   {
//      echo ' (after)';
   }
}