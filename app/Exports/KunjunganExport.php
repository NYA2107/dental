<?php

namespace App\Exports;

use App\Kunjungan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class KunjunganExport implements FromView
{
    public function view(): View
    {
        return view('main.kunjungan.laporan');
    }
}
