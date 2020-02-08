<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use App\Dokter;

class DokterController extends Controller
{
    //
    public function __construct(){
        $this->active = 'pasien';
    }
    
    function list(){
        $this->active = 'dokter';
        return view('main.dokter.list')
        ->with('dokter', Dokter::orderBy('nama')->paginate(20));
    }

    function store(Request $request){
        $store = Dokter::insert([
            'nama' => $request->nama
        ]);
        if($store){
            return Redirect::to(route('dokter-list'))->with('msg', 'Data berhasil disimpan');
        }
    }

    function edit(Request $request){
        $dokter = Dokter::find($request->id);
        $dokter->nama = $request->nama;
        if($dokter->save()){
            return Redirect::to(route('dokter-list'))->with('msg', 'Data berhasil disimpan');
        }
    }

    function remove(Request $request){
        $dokter = Dokter::find($request->id);
        if($dokter->delete()){
            return Redirect::to(route('dokter-list'))->with('msg', 'Data berhasil dihapus');
        }
    }
}
