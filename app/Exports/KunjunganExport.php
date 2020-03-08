<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class KunjunganExport implements FromView, ShouldAutoSize
{
    public function __construct($kunjungan, $totalBiaya, $totalKunjungan, $from, $to, $dokter){
        $this->kunjungan = $kunjungan;
        $this->totalBiaya = $totalBiaya;
        $this->totalKunjungan = $totalKunjungan;
        $this->from = $from;
        $this->to = $to;
        $this->dokter = $dokter;
    }


    public function view(): View
    {
        return view('main.kunjungan.excel.laporan')
        ->with('kunjungan',$this->kunjungan)
        ->with('totalBiaya', $this->totalBiaya)
        ->with('totalKunjungan', $this->totalKunjungan)
        ->with('from', $this->from)
        ->with('dokter', $this->dokter)
        ->with('to', $this->to);
    }
}
