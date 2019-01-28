<?php


namespace App\Models;


use Core\Model;

class Subject extends Model {

    public static function byCity($data)
    {
        $results = [];
        try {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT course_title,title_wilaya, count(average) as average FROM result, student, course, wilaya
                                            WHERE student.scholar_year = :year 
                                            AND student.scholar_year = result.scholar_year 
                                            AND student.id_student = result.id_student 
                                            AND student.current_year = :current_year 
                                            AND student.study_level = :level 
                                            AND course.id_course = result.id_course 
                                            AND student.bac_wilaya = wilaya.id_wilaya
                                            AND average {$data['type']} 
                                            AND course.semester = :semester GROUP BY course.id_course, bac_wilaya;"
            );
            $stmt->bindValue(':year', $data['year'], \PDO::PARAM_STR);
            $stmt->bindValue(':current_year', $data['current_year'], \PDO::PARAM_STR);
            $stmt->bindValue(':level', $data['level'], \PDO::PARAM_STR);
            $stmt->bindValue(':semester', $data['semester'], \PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
        return $results;
    }

    public static function ByNationality($data)
    {
        $results = [];
        try {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT course_title,nationality, count(average) as average FROM result, student, course 
                                            WHERE student.scholar_year = :year 
                                            AND student.scholar_year = result.scholar_year 
                                            AND student.id_student = result.id_student 
                                            AND student.current_year = :current_year 
                                            AND student.study_level = :level 
                                            AND course.id_course = result.id_course 
                                            AND average {$data['type']} 
                                            AND course.semester = :semester GROUP BY course.id_course, nationality;"
            );
            $stmt->bindValue(':year', $data['year'], \PDO::PARAM_STR);
            $stmt->bindValue(':current_year', $data['current_year'], \PDO::PARAM_STR);
            $stmt->bindValue(':level', $data['level'], \PDO::PARAM_STR);
            $stmt->bindValue(':semester', $data['semester'], \PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
        return $results;
    }

    public static function byGender($data)
    {
        $results = [];
        try {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT course_title,gender, count(average) as average FROM result, student, course 
                                            WHERE student.scholar_year = :year 
                                            AND student.scholar_year = result.scholar_year 
                                            AND student.id_student = result.id_student 
                                            AND student.current_year = :current_year 
                                            AND student.study_level = :level 
                                            AND course.id_course = result.id_course 
                                            AND average {$data['type']} 
                                            AND course.semester = :semester GROUP BY course.id_course, gender;"
            );
            $stmt->bindValue(':year', $data['year'], \PDO::PARAM_STR);
            $stmt->bindValue(':current_year', $data['current_year'], \PDO::PARAM_STR);
            $stmt->bindValue(':level', $data['level'], \PDO::PARAM_STR);
            $stmt->bindValue(':semester', $data['semester'], \PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
        return $results;

    }

    public static function getAssociations($data)
    {
        $results = [];
        try {
            $db = static::getDB();
            $stmt = $db->prepare("SELECT * from subjectAssociations
                                            WHERE id_subject_one IN (SELECT DISTINCT id_course
                                             FROM course
                                             WHERE year = :current_year
                                               AND branch_level = :level
                                               AND semester = :semester)"
            );
            $stmt->bindValue(':current_year', $data['current_year'], \PDO::PARAM_STR);
            $stmt->bindValue(':level', $data['level'], \PDO::PARAM_STR);
            $stmt->bindValue(':semester', $data['semester'], \PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
        return $results;

    }
}