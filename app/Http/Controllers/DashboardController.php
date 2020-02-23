<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pasien;
use App\Kunjungan;

class DashboardController extends Controller
{
    //
    public function __construct(){
        $this->active = 'dashboard';
    }

    function index(){
        $kunjungan = Kunjungan::all();
        $totalKunjungan = count($kunjungan);
        $totalBiaya = 0;
        foreach ($kunjungan as $v) {
            $totalBiaya = $totalBiaya + $v->biaya;
        }

        $pasien = Pasien::all();
        $totalPasien = count($pasien);
        return view('main.dashboard.index')
        ->with('totalPasien', $totalPasien)
        ->with('totalKunjungan', $totalKunjungan)
        ->with('totalBiaya', $totalBiaya)
        ->with('pasien', $totalPasien)
        ->with('active', $this->active);
    }
}
