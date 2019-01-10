<?php

namespace App\Controllers;

use App\Models\Year;
use Core\Controller;
use Core\View;

class Years extends Controller {
    public function allAction()
    {
        $years = Year::getAll();

        $years_refactored = $this->refactor_data($years);
        //die(var_dump($years_refactored));
        $data = [
            'title' => 'Years',
            'status' => 200,
            'data' => $years_refactored,
        ];
        //die(var_dump($data['data']));
        View::render("Years/all.php", $data);
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

    private function refactor_data($array) {
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
}