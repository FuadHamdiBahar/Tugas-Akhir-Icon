<?php

namespace App\Http\Controllers;

use App\Models\ApiModel;
use App\Models\TrendModel;
use Illuminate\Http\Response;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class ApiController extends Controller
{

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
                array_push($temp, $b->traffic);
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
                // kalau tidak catet teruse reset valnya
                if ($current_ring == $next_ring) {
                    $val += (int)$flat[$r]->max;
                } else {
                    $val += (int)$flat[$r]->max;
                    $resume[] = array(
                        'ring' => $current_ring,
                        'val' => $val
                    );
                    $val = 0;
                }
                // n
            } else {
                $current_ring = $flat[$r]->ring;
                $prev_ring = $flat[$r - 1]->ring;
                if ($current_ring == $prev_ring) {
                    $val += (int)$flat[$r]->max;
                    $resume[] = array(
                        'ring' => $current_ring,
                        'val' => $val
                    );
                } else {
                    $val = (int)$flat[$r]->max;
                    $resume[] = array(
                        'ring' => $current_ring,
                        'val' => $val
                    );
                }
            }
        }

        foreach ($resume as $item) {
            $item['kapasitas'] = 1000; // You can set this to any value you need
        }

        // dd($resume);
        $result = array(
            'month' => $month,
            'sbu' => $sbu,
            'data' => $resume
        );
        return $result;
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
            'data' => $flat
        );
        return $result;
    }

    public function listTraffic($origin, $terminating, $start, $end)
    {
        $start .= ' 00:00:00.000 +0700';
        $end .= ' 23:59:59.000 +0700';
        // $origin = 'SBU-GI.ACEH-NE8000.M14-NPE-02';
        // $terminating = 'SBU-SIGLI-NE8000.M14-UPE-04';

        $in = ApiModel::queryTraffic($origin, $terminating, $start, $end, 'Bits received');
        $out = ApiModel::queryTraffic($origin, $terminating, $start, $end, 'Bits sent');

        $result = array(
            'origin' => $origin,
            'terminating' => $terminating,
            'in' => $in,
            'out' => $out,
            'message' => 'success',
            'status' => Response::HTTP_OK,
        );
        return $result;
    }
}
