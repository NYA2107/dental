<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Kunjungan;
use Carbon\Carbon;
use Redirect;

class KunjunganController extends Controller
{
    public function __construct(){
        $this->active = 'pasien';
        $this->rules = array(
            'tanggal'=> 'required',
            'anamnesa' => 'required',
            'diagnosa' => 'required',
            'tindakan' => 'required',
            'biaya' => 'required',
            'id_pasien' => 'required',
            'id_dokter' => 'required'
        );
    }

    //POST
    function store(Request $request){
        $validator = Validator::make($request->all(), $this->rules);
        if($validator->fails()){
            return Redirect::to(route('pasien-detail', $request->id_pasien))->withErrors(['error' => 'Data yang anda masukkan tidak valid atau sudah terdaftar']);
        }else{
            $save = Kunjungan::insert($request->except('_token'));
            if($save){
                return Redirect::to(route('pasien-detail', $request->id_pasien))->with('msg', 'Data berhasil disimpan'); 
            }else{
                return Redirect::to(route('pasien-detail', $request->id_pasien))->withErrors(['error' => 'Gagal menyimpan data']);
            }
        }
    }

    //POST
    function edit(Request $request){
        $validator = Validator::make($request->all(), $this->rules);
        if($validator->fails()){
            return Redirect::to(route('pasien-detail', $request->id_pasien))->withErrors(['error' => 'Data yang anda masukkan tidak valid  ']);
        }else{
            $pasien = Kunjungan::find($request->id);
            $pasien->tanggal = $request->tanggal;
            $pasien->anamnesa = $request->anamnesa;
            $pasien->diagnosa = $request->diagnosa;
            $pasien->tindakan = $request->tindakan;
            $pasien->id_pasien = $request->id_pasien;
            $pasien->id_dokter = $request->id_dokter;
            $pasien->biaya = $request->biaya;
            if($pasien->save()){
                return Redirect::to(route('pasien-detail', $request->id_pasien))->with('msg', 'Data berhasil disimpan');
            }else{
                return Redirect::to(route('pasien-detail', $request->id_pasien))->withErrors(['error' => 'Gagal menyimpan data']);
            }
        }
        
    }

    //POST
    function remove(Request $request){
        $kunjungan = Kunjungan::find($request->id);
        if($kunjungan->delete()){
            return Redirect::to(route('pasien-detail', $kunjungan->pasien->id))->with('msg', 'Data berhasil dihapus');
        }
    }

}
