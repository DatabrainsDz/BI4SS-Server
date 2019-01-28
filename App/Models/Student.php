<?php


namespace App\Models;


use Core\Model;

class Student extends Model {

    public static function auth($data)
    {
        try {
            $db = static::getDB();
            $stmt = $db->prepare('SELECT scholar_year FROM student 
                                            WHERE id_student = :id_student
                                            AND current_year = :current_year
                                            AND study_level = :level');
            $stmt->bindValue(':id_student', $data['id_student'], \PDO::PARAM_INT);
            $stmt->bindValue(':current_year', $data['current_year'], \PDO::PARAM_STR);
            $stmt->bindValue(':level', $data['level'], \PDO::PARAM_STR);
            $stmt->execute();

        } catch (\PDOException $e) {

        }
    }

}