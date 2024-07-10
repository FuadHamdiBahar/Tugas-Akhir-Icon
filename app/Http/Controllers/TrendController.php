<?php

namespace App\Http\Controllers;

use App\Models\ApiModel;
use App\Models\TrendModel;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class TrendController extends Controller
{
    public function index($sbu)
    {

        // $listMonthName = ['jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul'];
        $listMonthName = ['jul'];
        foreach ($listMonthName as $m) {
            $data = ApiController::sumOfMaxTrafficEachRing($sbu, $m);
            // return $data;
            foreach ($data as $d) {
                TrendModel::createTrend($sbu, $m, '2024', $d['name'], $d['data']);
            }
        }
        $out['message'] = 'Data have been created';
        return $out;
    }

    public function update($sbu)
    {
        // return $sbu;
        $m = (int) date('m');
        $m = RingController::convertNumToTextMonth($m);
        $data = ApiController::sumOfMaxTrafficEachRing($sbu, $m);

        foreach ($data as $ring) {
            TrendModel::updateTrend($sbu, $m, $ring['name'], $ring['data']);
        }
        $out['message'] = 'Data have been updated';
        return $out;
    }

    public static function createWeeklyTrend($sbu)
    {
        ini_set('max_execution_time', 60);
        $m = (int) date('m');
        $month = RingController::convertNumToTextMonth($m);
        $month = 'jul';

        // read file
        $path = public_path('ring utilisasi.xlsx');
        $reader = new Xlsx();
        $spreadsheet = $reader->load($path);
        $sheet = $spreadsheet->getSheetByName($sbu);
        $totalRows = $sheet->getHighestRow();

        // gabung seluruhd data ring
        $merge = [];
        for ($row = 3; $row <= $totalRows; $row++) {
            if (!empty($sheet->getCell("C{$row}")->getValue())) {
                $data = ApiModel::queryMaxTrafficEachSourceToDestinationWeekly(
                    $sheet->getCell("C{$row}")->getValue(),
                    $sheet->getCell("D{$row}")->getValue(),
                    $sheet->getCell("B{$row}")->getValue(),
                    $month,
                );
                array_push($merge, $data);
            }
        }

        // flat biar lurus
        $flat = array();
        foreach ($merge as $hosts) {
            foreach ($hosts as $h) {
                $flat[] = $h;
            }
        }

        // membuat 0 2d array
        $result = array();
        foreach ($flat as $f) {
            $result[$f->ring][$f->week_number] = 0;
        }

        // mengisi 2d array
        foreach ($flat as $f) {
            $result[$f->ring][$f->week_number] += $f->traffic;
        }

        // return $result;

        // menambah ke tabel
        foreach ($result as $res => $r) {
            foreach ($r as $week_number => $traffic) {
                TrendModel::createWeeklyTrend($sbu, $res, $month, $week_number, $traffic);
            }
        }

        return 'BERHASIL';
    }
}
