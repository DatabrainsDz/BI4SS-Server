<?php

namespace App\Models;

use Core\Model;

class Year extends Model {
    public static function getAll()
    {
        try {
            $db = static::getDB();
            $stmt = $db->query("SELECT scholar_year, status, COUNT(status) as a FROM student GROUP BY scholar_year, status");
            $results = $stmt->fetchAll(\PDO::FETCH_OBJ);
            return $results;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function byCity($year)
    {
        try {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT title_wilaya, status, count(status),bac_wilaya
                                            FROM student,wilaya
                                            WHERE scholar_year = :year AND student.bac_wilaya = wilaya.id_wilaya
                                            GROUP BY bac_wilaya, status"
            );
            $stmt->bindValue(':year', $year, \PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $results;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function ByNationality($year)
    {
        try {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT nationality, status, count(status)
                                            FROM student
                                            WHERE scholar_year = :year
                                            GROUP BY nationality, status"
            );
            $stmt->bindValue(':year', $year, \PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $results;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function byGender($year)
    {
        try {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT gender, status, count(status) as count
                                          FROM student
                                          WHERE scholar_year = :year
                                          GROUP BY gender, status"
            );
            $stmt->bindValue(':year', $year, \PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $results;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }
}