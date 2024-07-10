<?php

namespace App\Http\Controllers;

use App\Models\ApiModel;
use App\Models\TrendModel;
use Illuminate\Http\Response;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use DateTime;

class ApiController extends Controller
{
    function getMonthIndex($month)
    {
        $months = ["jan" => 1, "feb" => 2, "mar" => 3, "apr" => 4, "may" => 5, "jun" => 6, "jul" => 7, "aug" => 8, "sep" => 9, "oct" => 10, "nov" => 11, "dec" => 12];
        return $months[$month];
    }

    public function monthDifference()
    {
        $curm = (int) date('m');
        $befm = RingController::convertNumToTextMonth($curm - 1);
        $curm = RingController::convertNumToTextMonth($curm);

        $query = TrendModel::monthDifference($befm, $curm);

        // return $query;

        $cur['name'] = 'jun';
        $bef['name'] = 'jul';
        $t1 = [];
        $t2 = [];
        $name = [];
        foreach ($query as $q) {
            array_push($t1, $q->cur_traffic);
            array_push($t2, $q->bef_traffic);
            array_push($name, $q->name);
        }

        $cur['data'] = $t1;
        $bef['data'] = $t2;

        $res['data'] = [$cur, $bef];
        $res['name'] = $name;
        return $res;
    }

    public function topEachMonth()
    {
        $query = TrendModel::topEachMonth();
        usort($query, function ($a, $b) {
            return $this->getMonthIndex($a->month) - $this->getMonthIndex($b->month);
        });

        $month = [];
        $traffic = [];
        $points = [];
        foreach ($query as $q) {
            array_push($month, $q->month);
            array_push($traffic, $q->traffic);

            // sulap hahah
            $temp['x'] = $q->month;
            $t['text'] = $q->name;
            $t['offsetY'] = 0;
            $temp['label'] = $t;
            array_push($points, $temp);
            // sampai sini sulapnya
        }



        $data['month'] = $month;
        $data['traffic'] = $traffic;
        $data['points'] = $points;

        return $data;
    }

    public function topEachSBU()
    {
        $query = TrendModel::topEachSBU();
        $result = [];

        // spyder style
        $temp['name'] = 'Actual';
        $temp['data'] = [];

        $categories = [];
        foreach ($query as $item) {
            array_push($temp['data'], (int) $item->traffic);
            array_push($categories, $item->name);
        }

        $traffic = [];
        array_push($traffic, $temp);

        $temp['name'] = 'Expected';
        $temp['data'] = [100, 100, 100, 100, 100, 100, 100, 100, 100, 100];

        array_push($traffic, $temp);

        $result['data'] = $traffic;
        $result['categories'] = $categories;

        // bar chart style
        // foreach ($query as $q) {
        //     $temp['x'] = $q->name;
        //     $temp['y'] = $q->traffic;
        //     $goals['name'] = 'Expected';
        //     $goals['value'] = 100;
        //     $goals['strokeColor'] = '#FF0000';
        //     $goals['strokeHeight'] = 2;
        //     $goals['strokeDashArray'] = 2;

        //     $temp['goals'] = [$goals];

        //     array_push($result, $temp);
        // }

        return $result;
    }

    public function top()
    {
        $query = TrendModel::getTopFive();

        $result = [];
        foreach ($query as $q) {
            $temp['x'] = $q->name;
            $temp['y'] = (float) $q->traffic;

            $goals['name'] = 'Expected';
            $goals['value'] = 100;
            $goals['strokeColor'] = '#FF0000';
            $goals['strokeWidth'] = 2;
            $goals['strokeDashArray'] = 2;

            $temp['goals'] = [$goals];

            array_push($result, $temp);
        }

        return $result;
    }

    // ring link details
    public static function ringLink($sbu)
    {
        // read file
        $path = public_path('location utilisasi.xlsx');
        $reader = new Xlsx();
        $spreadsheet = $reader->load($path);
        $sheet = $spreadsheet->getSheetByName($sbu);
        $totalRows = $sheet->getHighestRow();

        // $merge = array();
        // $temp = [];
        // for ($row = 3; $row <= $totalRows; $row++) {
        //     $current_ring = $sheet->getCell("B{$row}")->getValue();
        //     $next_row = $row + 1;
        //     $next_ring = $sheet->getCell("B{$next_row}")->getValue();
        //     if (!empty($sheet->getCell("E{$row}")->getValue())) {
        //         $origin = $sheet->getCell("E{$row}")->getValue();
        //         array_push($temp, $origin);
        //     }
        //     if ($current_ring != $next_ring) {
        //         array_push($merge, [
        //             'ring' => $current_ring,
        //             'link' => $temp
        //         ]);
        //         $temp = [];
        //     }
        // }

        $temp = array();
        for ($row = 3; $row <= $totalRows; $row++) {
            $ring = $sheet->getCell("B{$row}")->getValue();
            $location = $sheet->getCell("C{$row}")->getValue();
            array_push($temp, [
                'ring' => $ring,
                'location' => $location
            ]);
        }


        return $temp;
    }

    // ring trends
    public static function ringTrend($sbu)
    {
        $rings = TrendModel::getNumberOfRing($sbu, '2024');

        // Iterate over the array and extract the 'ring' values
        $flat = [];
        foreach ($rings as $r) {
            $flat[] = $r->ring;
        }

        // return $flat;

        // merge
        $merge = array();
        foreach ($flat as $f) {
            $result = TrendModel::getTrendsEachSbu($sbu, '2024', $f);
            array_push($merge, $result);
        }

        // return $merge;

        // transform
        $transform = array();
        $month = array();
        foreach ($merge as $m) {
            $temp = array();
            $ring = '';
            foreach ($m as $b) {
                $ring = $b->ring;
                array_push($temp, number_format($b->traffic / 1000000000, 1));
            }
            array_push($transform, [
                'name' => $ring,
                'data' => $temp
            ]);

            // array_push($month, $m->month);
        }

        // $res['data'] = $transform;
        // $res['month'] = $month;

        return $transform;
    }

    public static function getLastDateOfWeek($week)
    {
        // Create a DateTime object for the first day of the given week and year
        $date = new DateTime();
        $date->setISODate(date("Y"), $week);

        // Modify the date to get the last day of the week (Sunday)
        $date->modify('+6 days');

        // Return the formatted date
        return $date->format('d-m');
    }

    // weekly trends
    public static function weeklyTrend($sbu)
    {
        $cw = (int) date('W') - 1;
        $fw = $cw - 3;

        $ringList = TrendModel::getWeeklyNumberOfRing($sbu);

        $merge = [];
        foreach ($ringList as $rl) {
            $query = TrendModel::getWeeklyTrend($sbu, $rl->ring, $fw, $cw);
            array_push($merge, $query);
        }

        // return $merge;

        $data = [];
        foreach ($merge as $items) {
            $traffic = [];
            $name = '';
            foreach ($items as $i) {
                array_push($traffic, number_format($i->traffic / 1000000000, 1));
                $name = $i->ring;
            }
            $temp['name'] = $name;
            $temp['data'] = $traffic;

            array_push($data, $temp);
        }

        $categories = [];
        for ($i = $fw; $i <= $cw; $i++) {
            array_push($categories, self::getLastDateOfWeek($i));
        }
        $res['data'] = $data;
        $res['categories'] = $categories;
        return $res;
    }

    // ring
    public static function listOfMaxTrafficEachRing($sbu, $month)
    {
        ini_set('max_execution_time', 60);

        // read file
        $path = public_path('ring utilisasi.xlsx');
        $reader = new Xlsx();
        $spreadsheet = $reader->load($path);
        $sheet = $spreadsheet->getSheetByName($sbu);
        $totalRows = $sheet->getHighestRow();

        // new array to merge
        $merge = array();

        for ($row = 3; $row <= $totalRows; $row++) {
            if (!empty($sheet->getCell("C{$row}")->getValue())) {
                $data = ApiModel::queryMaxTrafficEachSourceToDestination(
                    $sheet->getCell("C{$row}")->getValue(),
                    $sheet->getCell("D{$row}")->getValue(),
                    $sheet->getCell("B{$row}")->getValue(),
                    $month,

                );
                // var_dump($sheet->getCell("C{$row}")->getValue());
                array_push($merge, $data);
            }
        }

        $flat = array();
        foreach ($merge as $hosts) {
            foreach ($hosts as $h) {
                $flat[] = $h;
            }
        }

        // check missing sbu ring max
        return $flat;
    }

    public static function sumOfMaxTrafficEachRing($sbu, $month)
    {
        $flat = self::listOfMaxTrafficEachRing($sbu, $month);
        $resume = array();
        $val = 0;
        for ($r = 0; $r < count($flat); $r++) {
            // n - 1
            if ($r < count($flat) - 1) {
                $current_ring = $flat[$r]->ring;
                $next_ring = $flat[$r + 1]->ring;
                // kalau ring n == n+1 jumlahkan
                // kalau tidak catet terus reset valnya
                if ($current_ring == $next_ring) {
                    $val += (int)$flat[$r]->traffic;
                } else {
                    $val += (int)$flat[$r]->traffic;
                    $resume[] = array(
                        'name' => $current_ring,
                        'data' => $val,
                        // 'utility' => $val
                    );
                    $val = 0;
                }
            } else {
                $current_ring = $flat[$r]->ring;
                $prev_ring = $flat[$r - 1]->ring;
                if ($current_ring == $prev_ring) {
                    $val += (int)$flat[$r]->traffic;
                    $resume[] = array(
                        'name' => $current_ring,
                        'data' => $val,
                        // 'utility' => $val
                    );
                } else {
                    $val = (int)$flat[$r]->traffic;
                    $resume[] = array(
                        'name' => $current_ring,
                        'data' => $val,
                        // 'utility' => $val
                    );
                }
            }
        }

        return $resume;
    }

    // sbu
    public static function listOfMaxTrafficEachSourceToDestination($sbu, $month)
    {
        ini_set('max_execution_time', 60);

        // read file
        $path = public_path('data utilisasi.xlsx');
        $reader = new Xlsx();
        $spreadsheet = $reader->load($path);
        $sheet = $spreadsheet->getSheetByName($sbu);
        $totalRows = $sheet->getHighestRow();

        // for testing
        // $totalRows = 4;

        // new array to merge
        $merge = array();

        for ($row = 3; $row <= $totalRows; $row++) {
            if (!empty($sheet->getCell("C{$row}")->getValue())) {
                $data = ApiModel::queryMaxTrafficEachSourceToDestination(
                    $sheet->getCell("C{$row}")->getValue(),
                    $sheet->getCell("D{$row}")->getValue(),
                    $sheet->getCell("B{$row}")->getValue(),
                    $month,
                );
                // var_dump($sheet->getCell("C{$row}")->getValue());
                array_push($merge, $data);
            }
        }

        // check missing sbu ring max
        // dd($merge);

        $flat = array();
        foreach ($merge as $hosts) {
            foreach ($hosts as $h) {
                $flat[] = $h;
            }
        }

        $result = array(
            'sbu' => $sbu,
            'data' => $flat,
            'month' => date('F', strtotime(date('d-m-Y')))
        );
        return $result;
    }

    public function listTrafficMonth($origin, $terminating)
    {
        $m = (int) date('m');
        $month = RingController::convertNumToTextMonth($m);
        $in = ApiModel::queryTrafficMonth($origin, $terminating, 'Bits received', $month);
        $out = ApiModel::queryTrafficMonth($origin, $terminating, 'Bits sent', $month);

        $merge = array();
        $temp = array();
        $max = 0;
        foreach ($in as $data) {
            if ($max < $data->traffic) {
                $max = $data->traffic;
            }
            array_push($temp, $data->traffic);
        }

        array_push($merge, [
            'name' => 'Bits received',
            'data' => $temp
        ]);

        $temp = array();
        foreach ($out as $data) {
            if ($max < $data->traffic) {
                $max = $data->traffic;
            }
            array_push($temp, $data->traffic);
        }

        array_push($merge, [
            'name' => 'Bits sent',
            'data' => $temp,
        ]);

        $res['data'] = $merge;
        $res['traffic'] = $max;
        $res['month'] = $month;

        return $res;
    }

    public function listTrafficWeek($origin, $terminating)
    {
        $m = (int) date('m');
        $month = RingController::convertNumToTextMonth($m);
        $in = ApiModel::queryTrafficWeek($origin, $terminating, 'Bits received', $month);
        $out = ApiModel::queryTrafficWeek($origin, $terminating, 'Bits sent', $month);
        // return $out;

        $merge = array();
        $temp = array();
        $time = array();
        $max = 0;
        foreach ($in as $data) {
            if ($max < $data->traffic) {
                $max = $data->traffic;
            }
            array_push($time, $data->time);
            array_push($temp, $data->traffic);
        }

        array_push($merge, [
            'name' => 'Bits received',
            'data' => $temp
        ]);

        $temp = array();
        foreach ($out as $data) {
            if ($max < $data->traffic) {
                $max = $data->traffic;
            }
            array_push($temp, $data->traffic);
        }

        array_push($merge, [
            'name' => 'Bits sent',
            'data' => $temp
        ]);

        $res['data'] = $merge;
        $res['traffic'] = $max;
        $res['time'] = $time;

        return $res;
    }
}
