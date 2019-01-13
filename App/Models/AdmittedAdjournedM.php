<?php


namespace App\Models;


use Core\Model;

class AdmittedAdjournedM extends Model {
    public static function byCity($year, $current_year, $level)
    {
        $results = [];
        try {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT title_wilaya, status, count(status),bac_wilaya
                                            FROM student,wilaya
                                            WHERE scholar_year = :year 
                                            AND current_year = :current_year 
                                            AND study_level = :level
                                            AND student.bac_wilaya = wilaya.id_wilaya
                                            GROUP BY bac_wilaya, status"
            );
            $stmt->bindValue(':year', $year, \PDO::PARAM_STR);
            $stmt->bindValue(':current_year', $current_year, \PDO::PARAM_STR);
            $stmt->bindValue(':level', $level, \PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
        return $results;
    }

    public static function ByNationality($year, $current_year, $level)
    {
        $results = [];
        try {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT nationality, status, count(status)
                                            FROM student
                                            WHERE scholar_year = :year 
                                            AND current_year = :current_year 
                                            AND study_level = :level
                                            GROUP BY nationality, status"
            );
            $stmt->bindValue(':year', $year, \PDO::PARAM_STR);
            $stmt->bindValue(':current_year', $current_year, \PDO::PARAM_STR);
            $stmt->bindValue(':level', $level, \PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
        return $results;
    }

    public static function byGender($year, $current_year, $level)
    {
        $results = [];
        try {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT gender, status, count(status) as count
                                          FROM student
                                          WHERE scholar_year = :year 
                                          AND current_year = :current_year 
                                          AND study_level = :level
                                          GROUP BY gender, status"
            );
            $stmt->bindValue(':year', $year, \PDO::PARAM_STR);
            $stmt->bindValue(':current_year', $current_year, \PDO::PARAM_STR);
            $stmt->bindValue(':level', $level, \PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
        return $results;

    }
}