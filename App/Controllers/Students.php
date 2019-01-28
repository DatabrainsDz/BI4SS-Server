<?php

namespace App\Controllers;

use App\Models\Student;
use Core\Controller;

class Students extends Controller {

    public function authAction()
    {
        $inputData = [
            'student_id' => $_GET['student_id'],
            'current_year' => $_GET['current_year'],
            'level' => $_GET['level'],
        ];

        $result = Student::auth($inputData);
        die(var_dump($result));
    }

}