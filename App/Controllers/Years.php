<?php

namespace App\Controllers;

use App\Models\Year;
use Core\Controller;
use Core\View;

class Years extends Controller {
    public function allAction()
    {
        $years = Year::getAll();

        $years_refactored = $this->refactor_data_of_years($years);
        //die(var_dump($years_refactored));
        $data = [
            'title' => 'Years',
            'status' => 200,
            'data' => $years_refactored,
        ];
        //die(var_dump($data['data']));
        View::render("Years/all.php", $data);
    }

    public function byYearAction()
    {
        $year = $this->route_params['year'];
        $dataByGender = Year::byGender($year);
        $dataByCity = Year::byCity($year);
        $dataByNationality = Year::ByNationality($year);

        $this->refactor_data_of_city($this->refactor_data($dataByCity));
        $data = [
            "byGender" => $this->refactor_data($dataByGender),
            "byCity" => $this->refactor_data_of_city($this->refactor_data($dataByCity)),
            "byNationality" => $this->refactor_data($dataByNationality)
        ];
        $response = [
            'title' => 'Years By One',
            'status' => 200,
            'data' => $data,
        ];
        View::render("Years/all.php", $response);
    }


    protected function before()
    {
//      echo '(before) ';
//      return false ; // if you don't want execute the last of code
    }

    protected function after()
    {
//      echo ' (after)';
    }

    private function refactor_data_of_years($array)
    {
        $years_refactored = [];
        // refactoring data;
        for ($i = 0; $i < count($array); $i++) {
            $scholar_year = $array[$i]->scholar_year;
            $status_count = $array[$i]->a;
            if ($scholar_year == $array[($i + 1) % count($array)]->scholar_year) {
                array_push($years_refactored, [
                    "scholar_year" => $scholar_year,
                    "admitted" => $status_count,
                    "adjourned" => $array[($i + 1) % count($array)]->a,
                ]);
            }

        }
        return $years_refactored;
    }

    private function refactor_data($data)
    {
        $refactored_data = [];
        foreach ($data as $d) {
            $keys = array_keys($d);

            //echo $d[$keys[1]] . "<br>";
            $refactored_data[$d[$keys[0]]] = empty($refactored_data[$d[$keys[0]]]) ? [
                "Admis" => "0",
                "Ajourné" => "0",
            ] : $refactored_data[$d[$keys[0]]];
            $refactored_data[$d[$keys[0]]][$d[$keys[1]]] = $d[$keys[2]];

        }
        return $refactored_data;
    }

    private function refactor_data_of_city($data)
    {
        $refactored_data = [];
        $adm = 0;
        $ajr = 0;
        foreach ($data as $key => $val) {
            if ((intval($val['Admis']) + intval($val['Ajourné'])) > 30) {
                $refactored_data[$key] = $val;
            } else {
                $adm += intval($val["Admis"]);
                $ajr += intval($val["Ajourné"]);
                $val['Admis'] = (String) $adm;
                $val['Ajourné'] = (String) $ajr;
                $refactored_data['Others'] = $val;
            }
        }
        return $refactored_data;
    }
}