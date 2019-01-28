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
            "semester2" => $_GET['semester2'],
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
            'data' => $data,
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

    public function associationAction()
    {
        $inputData = [
            "current_year" => $_GET['current_year'],
            "level" => $_GET['level'],
            "semester" => $_GET['semester'],
        ];
        $result = Subject::getAssociations($inputData);
//        die(var_dump($result));
//        die(var_dump($this->refactor_associations($result)));
        $response = [
            'title' => "I don't know",
            'status' => 200,
            'data' => $this->refactor_associations($result),
        ];
        View::render("Years/all.php", $response);
    }


    private function refactor_associations($data)
    {
        $refactored_data = [];
        foreach ($data as $d) {
            $refactored_data [$d['id_subject_one']] = [];
        }
//        die(var_dump($refactored_data));
        foreach ($data as $d) {
            array_push($refactored_data[$d['id_subject_one']], $d['id_subject_two']);
        }
        return $refactored_data;
    }
}