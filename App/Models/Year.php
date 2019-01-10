<?php

namespace App\Models;

use Core\Model;

class Year extends Model {
   public static function getAll() {
      try {
         $db = static::getDB();
         $stmt = $db->query("SELECT scholar_year, status, COUNT(status) as a FROM student GROUP BY scholar_year, status");
         $results = $stmt->fetchAll(\PDO::FETCH_OBJ);
         return $results;
      } catch (\PDOException $e) {
         echo $e->getMessage();
      }
   }
}