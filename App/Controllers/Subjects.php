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

    public function infoAction()
    {
        $inputRequest = [
            "level" => $_GET['level'],
            "scholar_year" => $_GET['scholar_year'],
            "current_year" => $_GET['current_year'],
        ];

        $result = Subject::getSubjects($inputRequest);
        $response = [
            'title' => "I don't know",
            'status' => 200,
            'data' => $this->refactor_info_subjects($result),
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
        $result = [];
        foreach ($data as $d) {
            $refactored_data [$d['id_subject_one']] = [];
        }
        foreach ($data as $d) {
            array_push($refactored_data[$d['id_subject_one']], $d['id_subject_two']);
        }
        foreach ($refactored_data as $key => $val) {
            array_push($result, [
                "subject" => $key,
                "relatedTo" => $val,
            ]);
        }
        return $result;
    }

    private function refactor_info_subjects($array)
    {
        $refactored_data = [];
        foreach ($array as $arr) {
            array_push($refactored_data, $arr['course_title']);
        }
        return $refactored_data;
    }
}