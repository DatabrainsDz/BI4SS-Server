<?php


namespace App\Controllers;

use App\Models\Subject;
use Core\Controller;
use Core\View;


/*
 * ya3tik semester wino , study level , current year w 3am scholair
 *
 * */

class Subjects extends Controller {

    public function allAction()
    {
        $request_data = [
            "year" => $this->route_params['year'],
            "current_year" => $_GET['current_year'],
            "level" => $_GET['level'],
            "semester" => $_GET['semester'],
            "type" => " > 10",
        ];
        if ($_GET['level'] == 0) {
            $request_data['type'] = " < 10";
        }

        $dataByGender = Subject::byGender($request_data);
        $dataByNationality = Subject::byNationality($request_data);
        $dataByCity = Subject::byCity($request_data);
        $data = [
            "byGender" => $this->refactor_data($dataByGender),
            "byCity" => $this->refactor_data($dataByCity),
            "byNationality" => $this->refactor_data($dataByNationality)
        ];
        $response = [
            'title' => "I don't know",
            'status' => 200,
            'data' => [0 => $data],
        ];
        View::render("Years/all.php", $response);
    }


    private function refactor_data($data)
    {
        $refactored_data = [];
        foreach ($data as $d) {
            $keys = array_keys($d);

            //echo $d[$keys[1]] . "<br>";
            $refactored_data[$d[$keys[0]]] = empty($refactored_data[$d[$keys[0]]]) ? [] : $refactored_data[$d[$keys[0]]];
            $refactored_data[$d[$keys[0]]][$d[$keys[1]]] = $d[$keys[2]];

        }
        return $refactored_data;
    }
}