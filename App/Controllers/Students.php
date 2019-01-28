<?php

namespace App\Controllers;

use App\Models\Student;
use Core\Controller;
use Core\View;

class Students extends Controller {

    public function authAction()
    {
        $inputData = [
            'student_id' => $_GET['student_id'],
            'current_year' => $_GET['current_year'],
            'level' => $_GET['level'],
        ];
        $result = Student::auth($inputData);
        View::render("Years/all.php", $result);
    }

}