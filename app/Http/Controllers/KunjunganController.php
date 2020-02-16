<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Kunjungan;
use Carbon\Carbon;
use Redirect;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KunjunganExport;
use PDF;

class KunjunganController extends Controller
{
    public function __construct(){
        $this->active = 'kunjungan';
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

    function list(Request $request){
        $kunjungan = Kunjungan::orderBy('tanggal', 'desc')->paginate(10);
        $totalKunjungan = count($kunjungan);
        $totalBiaya = 0;
        foreach ($kunjungan as $v) {
            $totalBiaya = $totalBiaya + $v->biaya;
        }
        return view('main.kunjungan.list')
        ->with('kunjungan', $kunjungan)
        ->with('totalKunjungan',$totalKunjungan)
        ->with('totalBiaya',$totalBiaya)
        ->with('active', $this->active);
    }

    //HELPER
    function filterByDate($from, $to, $order){
        if($from && $to){
            $kunjungan = Kunjungan::whereBetween('tanggal', [$from, $to])->orderBy('tanggal', $order);
        }else if($from){
            $kunjungan = Kunjungan::where('tanggal', '>=', $from )->orderBy('tanggal', $order);
        }else if($to){
            $kunjungan = Kunjungan::where('tanggal', '<=', $to )->orderBy('tanggal', $order);
        }
        else{
            $kunjungan = Kunjungan::orderBy('tanggal', $order);
        }
        return ['kunjunganReal' => $kunjungan->get(), 'kunjungan' => $kunjungan->paginate(10)];
    }

    function filter(Request $request){
        $kunjungan = $this->filterByDate($request->from, $request->to, 'desc');
        $kunjunganReal = $kunjungan['kunjunganReal'];
        $kunjungan = $kunjungan['kunjungan'];
        $totalKunjungan = count($kunjunganReal);
        $totalBiaya = 0;
        foreach ($kunjunganReal as $v) {
            $totalBiaya = $totalBiaya + $v->biaya;
        }
        return view('main.kunjungan.list')
        ->with('from', $request->from)
        ->with('to', $request->to)
        ->with('kunjungan', $kunjungan)
        ->with('totalKunjungan',$totalKunjungan)
        ->with('totalBiaya',$totalBiaya)
        ->with('active', $this->active);
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

    function exportExcel(Request $request){
        $data = $this->filterByDate($request->from, $request->to, 'asc');
        $kunjungan = $data['kunjunganReal'];
        $totalKunjungan = count($kunjungan);
        $totalBiaya = 0;
        foreach ($kunjungan as $v) {
            $totalBiaya = $totalBiaya + $v->biaya;
        }
        return Excel::download(new KunjunganExport($kunjungan, $totalBiaya, $totalKunjungan, ($request->from?$request->from:'Kunjungan Pertama'), ($request->to?$request->to:'Kunjungan Terakhir')), 'kunjungan_'.($request->from?$request->from:'awal').'_to_'.($request->to?$request->to:'terakhir').'.xlsx');
    }

    function exportPdf(Request $request){
        $kunjungan = $this->filterByDate($request->from, $request->to, 'asc')['kunjunganReal'];
        $totalKunjungan = count($kunjungan);
        $totalBiaya = 0;
        foreach ($kunjungan as $v) {
            $totalBiaya = $totalBiaya + $v->biaya;
        }
        return PDF::loadview('main.kunjungan.pdf.laporan',
        [
            'kunjungan'=>$kunjungan, 
            'totalBiaya'=>$totalBiaya, 
            'totalKunjungan'=>$totalKunjungan, 
            'from'=> ($request->from?$request->from:'Kunjungan Pertama'), 
            'to'=>($request->to?$request->to:'Kunjungan Terakhir')
        ])->download('kunjungan_'.($request->from?$request->from:'Kunjungan Pertama').'_to_'.($request->to?$request->to:'Kunjungan Terakhir').'.pdf');
    }

}
