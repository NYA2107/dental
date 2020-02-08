<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pasien;

class PasienController extends Controller
{
    public function __construct(){
        $this->active = 'pasien';
    }
    
    //GET
    function list(){
        return view('main.pasien.list')
        ->with('dokter', Pasien::paginate(20))
        ->with('active', $this->active);
    }

    //GET
    function add(){
        
        return view('main.pasien.add');

    }

    //GET
    function search(Request $request){
        $pasien = Pasien::where('nama', 'LIKE', $request->nama)
        ->where('no_rekam_medis', 'LIKE', $request->no_rekam_medis)
        ->paginate(20);

        return view('main.pasien.list')
        ->with('pasien', $pasien)
        ->with('active', $this->active);
    }

    //POST
    function store(){

    }
}
