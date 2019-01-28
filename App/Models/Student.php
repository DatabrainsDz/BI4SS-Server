<?php


namespace App\Models;


use Core\Model;

class Student extends Model {

    public static function auth($data)
    {
        $results = [];
        try {
            $db = static::getDB();
            $stmt = $db->prepare('SELECT MAX(scholar_year) as scholar_year FROM student 
                                            WHERE id_student = :student_id
                                            AND current_year = :current_year
                                            AND study_level = :level');
            $stmt->bindValue(':student_id', $data['student_id'], \PDO::PARAM_STR);
            $stmt->bindValue(':current_year', $data['current_year'], \PDO::PARAM_STR);
            $stmt->bindValue(':level', $data['level'], \PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
        return $results;
    }

}