<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Antrian;
use App\Pasien;
use Redirect;

class AntrianController extends Controller
{
    //
    public function __construct(){
        $this->active = 'antrian';
    }
    
    function index(){
        return view('main.antrian.antrian')->with('active', $this->active);
    }

    function getAntrian(){
        return Antrian::first()->antrian;
    }

    function addAntrian(Request $request){
        $antrian = json_decode(Antrian::first()->antrian);
        $pasien = Pasien::find($request->id);
        $newData = [
            'id'=> $pasien->id,
            'no_rekam_medis' => $pasien->no_rekam_medis,
            'nama'=>$pasien->nama,
        ];
        $isExist = false;
        foreach($antrian as $a){
            if($a->id == $request->id){
                return Redirect::to(route('antrian'))->withErrors(['error' => 'Data sudah terdapat di antrian']);
            }else{
                $isExist = false;
            }
        }
        // dd($isExist);
        if($isExist == false){
            array_push($antrian, $newData);
            $set = Antrian::first();
            $set->antrian = $antrian;
            if($set->save()){
                return Redirect::to(route('antrian'))->with('msg', 'Pasien berhasil ditambahkan ke antrian');
            }
        }else{
            return Redirect::to(route('antrian'))->withErrors(['error' => 'Data sudah terdapat di antrian']);
        }
        
    }

    function setAntrian(Request $request){
        $antrian = Antrian::first();
        $antrian->antrian = json_encode($request->data);
        if($antrian->save()){
            return ['msg'=>'success'];
        }else{
            return ['msg'=>'fail'];
        }
         
    }
}
