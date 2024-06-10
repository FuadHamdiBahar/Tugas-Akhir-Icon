<?php

namespace App\Http\Controllers;

use App\Models\ApiModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class ApiController extends Controller
{
    // ring
    public static function listOfMaxTrafficEachRing($sbu)
    {
        ini_set('max_execution_time', 60);
        $start = '2024-05-01 00:00:00.000 +0700';
        $end = '2024-05-31 23:59:59.000 +0700';

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
                    self::convertNumToTextMonth(),

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
            'date_range' => $start . ' to ' . $end,
            'message' => 'success',
            'status' => Response::HTTP_OK,
            'sbu' => $sbu,
            'data' => $resume
        );
        return $result;
    }

    public static function convertNumToTextMonth()
    {
        $m = (int) date('m');
        $listMonthName = ['jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec'];
        return $listMonthName[$m - 1];
    }

    // sbu
    public static function listOfMaxTrafficEachSourceToDestination($sbu)
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
                    self::convertNumToTextMonth(),
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
            'message' => 'success',
            'status' => Response::HTTP_OK,
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
