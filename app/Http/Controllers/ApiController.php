<?php

namespace App\Http\Controllers;

use App\Models\ApiModel;
use App\Models\TrendModel;
use Illuminate\Http\Response;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class ApiController extends Controller
{

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
        }

        return $transform;
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

        // check missing sbu ring max
        // dd($merge);

        $flat = array();
        foreach ($merge as $hosts) {
            foreach ($hosts as $h) {
                $flat[] = $h;
            }
        }

        // dd($flat);

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
        $month = RingController::convertNumToTextMonth();
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
        $month = RingController::convertNumToTextMonth();
        $in = ApiModel::queryTrafficWeek($origin, $terminating, 'Bits received', $month);
        $out = ApiModel::queryTrafficWeek($origin, $terminating, 'Bits sent', $month);

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
            'data' => $temp
        ]);

        $res['data'] = $merge;
        $res['traffic'] = $max;

        return $res;
    }
}
