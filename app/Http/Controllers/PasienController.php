<?php

namespace App\Http\Controllers;

// use Illuminate\Support\Facades\Validator;
use Validator;
use Illuminate\Http\Request;
use App\Pasien;
use App\Kunjungan;
use App\Dokter;
use App\Odontogram;
use App\FileStorage;
use Carbon\Carbon;
use Redirect;
use File;
use Response;

class PasienController extends Controller
{
    public function __construct(){
        $this->active = 'pasien';
        $this->rules = array(
            'no_rekam_medis'=> 'required|unique:pasien',
            'nama' => 'required',
            'tanggal_lahir' => 'required',
            'pekerjaan' => 'required',
            'tanggal' => 'required',
            'alamat' => 'required',
            'jenis_kelamin' => 'required'
        );
        $this->rulesEdit = array(
            'no_rekam_medis'=> 'required',
            'nama' => 'required',
            'tanggal_lahir' => 'required',
            'pekerjaan' => 'required',
            'tanggal' => 'required',
            'alamat' => 'required',
            'jenis_kelamin' => 'required'
        );
        $this->rulesUpload = array(
            'id_pasien'=> 'required',
            'keterangan'=> 'required',
            'tanggal' => 'required',
            'file' => 'required'
        );
    }
    
    //GET
    function list(){
        return view('main.pasien.list')
        ->with('pasien', Pasien::paginate(10))
        ->with('dokter', Dokter::all())
        ->with('active', $this->active);
    }

    //GET
    function add(){
        return view('main.pasien.add')
        ->with('tanggal',Carbon::now()->format('Y-m-d'));
    }

    //GET
    function search(Request $request){
        if($request->no_rekam_medis == null && $request->nama == null && $request->tanggal_lahir == null){
            $pasien = Pasien::paginate(10);
        }else if($request->no_rekam_medis == null && $request->nama == null){
            $pasien = Pasien::where('tanggal_lahir', $request->tanggal_lahir)->paginate(10);
        }else if($request->no_rekam_medis == null && $request->tanggal_lahir == null){
            $pasien = Pasien::where('nama','LIKE', '%'.$request->nama.'%')->paginate(10);
        }else if($request->nama == null && $request->tanggal_lahir == null){
            $pasien = Pasien::where('no_rekam_medis','LIKE', '%'.$request->no_rekam_medis.'%')->paginate(10);
        }else if($request->no_rekam_medis == null){
            $pasien = Pasien::where('nama','LIKE', '%'.$request->nama.'%')->where('tanggal_lahir', $request->tanggal_lahir)->paginate(10);
        }else if($request->nama == null){
            $pasien = Pasien::where('no_rekam_medis','LIKE', '%'.$request->no_rekam_medis.'%')->where('tanggal_lahir', $request->tanggal_lahir)->paginate(10);
        }else if($request->tanggal_lahir == null){
            $pasien = Pasien::where('no_rekam_medis','LIKE', '%'.$request->no_rekam_medis.'%')->where('nama','LIKE', '%'.$request->nama.'%')->paginate(10);
        }else{
            $pasien = Pasien::where('no_rekam_medis','LIKE', '%'.$request->no_rekam_medis.'%')->where('nama','LIKE', '%'.$request->nama.'%')->where('tanggal_lahir', $request->tanggal_lahir)->paginate(10);
        }

        return view('main.pasien.list')
        ->with('pasien', $pasien)
        ->with('dokter', Dokter::all())
        ->with('active', $this->active);
    }

    //GET
    function detail($id){
        $pasien = Pasien::find($id);
        $kunjungan = Kunjungan::where('id_pasien',$id)->orderBy('tanggal', 'desc')->paginate(20);
        $file = FileStorage::where('id_pasien',$id)->orderBy('tanggal', 'desc')->paginate(20);
        // dd($file);
        $dokter = Dokter::all();
        if($pasien){
            return view('main.pasien.detail')
            ->with('pasien', $pasien)
            ->with('kunjungan', $kunjungan)
            ->with('dokter', $dokter)
            ->with('tanggal',Carbon::now()->format('Y-m-d'))
            ->with('file', $file)
            ->with('active', $this->active);
        }else {
            return Redirect::to(route('pasien-list'));
        }
        
    }
    
    function detailKunjunganSearch(Request $request, $id){
        $pasien = Pasien::find($id);
        $file = FileStorage::where('id_pasien',$id)->orderBy('tanggal', 'desc')->paginate(20);
        $kunjungan = [];
        if(!$request->tanggal && !$request->diagnosa){
            $kunjungan = Kunjungan::where('id_pasien',$id)
            ->orderBy('tanggal', 'desc')
            ->paginate(20);    
        }else if(!$request->tanggal){
            $kunjungan = Kunjungan::where('id_pasien',$id)
            ->where('diagnosa', 'LIKE', '%'.$request->diagnosa.'%')
            ->orderBy('tanggal', 'desc')
            ->paginate(20);
        }else if(!$request->diagnosa){
            $kunjungan = Kunjungan::where('id_pasien',$id)
            ->where('tanggal', $request->tanggal)
            ->orderBy('tanggal', 'desc')
            ->paginate(20);
        }else{
            $kunjungan = Kunjungan::where('id_pasien',$id)
            ->where('tanggal', $request->tanggal)
            ->where('diagnosa', 'LIKE', '%'.$request->diagnosa.'%')
            ->orderBy('tanggal', 'desc')
            ->paginate(20);
        }
        
        $dokter = Dokter::all();
        if($pasien){
            return view('main.pasien.detail')
            ->with('pasien', $pasien)
            ->with('kunjungan', $kunjungan)
            ->with('dokter', $dokter)
            ->with('tanggal',Carbon::now()->format('Y-m-d'))
            ->with('file', $file)
            ->with('active', $this->active);
        }else {
            return Redirect::to(route('pasien-list'));
        }
        
    }

    //POST
    function store(Request $request){
        $validator = Validator::make($request->all(), $this->rules);
        if($validator->fails()){
            return Redirect::to(route('pasien-add'))->withErrors(['error' => 'Data yang anda masukkan tidak valid atau sudah terdaftar']);
        }else{
            $save = Pasien::create($request->except('_token'));
            $dataOdontogram = array_map(function($v){return[
                'gigi'=>$v,
                'depan'=>['text'=>'Normal', 'id'=>'normal'],
                'kiri'=>['text'=>'Normal', 'id'=>'normal'],
                'tengah'=>['text'=>'Normal', 'id'=>'normal'],
                'kanan'=>['text'=>'Normal', 'id'=>'normal'],
                'belakang'=>['text'=>'Normal', 'id'=>'normal'],
                'block'=>['text'=>'-', 'id'=>'none'],
            ];},[18,17,16,15,14,13,12,11,21,22,23,24,25,26,27,28,55,54,53,52,51,61,62,63,64,65,85,84,83,82,81,71,72,73,74,75,48,47,46,45,44,43,42,41,31,32,33,34,35,36,37,38]);
            if($save){
                $saveOdontogram = Odontogram::create(['id_pasien'=>$save->id, 'odontogram'=>json_encode($dataOdontogram)]);
                if($saveOdontogram){
                    return Redirect::to(route('pasien-add'))->with('msg', 'Data berhasil disimpan'); 
                }else{
                    return Redirect::to(route('pasien-add'))->withErrors(['error' => 'Gagal menyimpan data']);
                }
            }else{
                return Redirect::to(route('pasien-add'))->withErrors(['error' => 'Gagal menyimpan data']);
            }
        }
    }

    //POST
    function edit(Request $request){
        $validator = Validator::make($request->all(), $this->rulesEdit);
        if($validator->fails()){
            return Redirect::to(route('pasien-detail', $request->id))->withErrors(['error' => 'Data yang anda masukkan tidak valid atau sudah terdaftar']);
        }else{
            $pasien = Pasien::find($request->id);
            $pasien->no_rekam_medis = $request->no_rekam_medis;
            $pasien->nama = $request->nama;
            $pasien->tanggal = $request->tanggal;
            $pasien->alamat = $request->alamat;
            $pasien->tanggal_lahir = $request->tanggal_lahir;
            $pasien->jenis_kelamin = $request->jenis_kelamin;
            $pasien->pekerjaan = $request->pekerjaan;
            if($pasien->save()){
                return Redirect::to(route('pasien-detail', $request->id))->with('msg', 'Data berhasil disimpan');
            }else{
                return Redirect::to(route('pasien-detail', $request->id))->withErrors(['error' => 'Gagal menyimpan data']);
            }
        }
        
    }

    //POST
    function remove(Request $request){
        $pasien = Pasien::findOrFail($request->id);
        $kunjungan = Kunjungan::where('id_pasien', $request->id)->get();
        $odontogram = Odontogram::where('id_pasien', $request->id)->get();
        // dd([$pasien, $kunjungan, $odontogram]);
        foreach($kunjungan as $v){
            $v->delete();
        }

        foreach($odontogram as $v){
            $v->delete();
        }
        if($pasien->delete()){
            return Redirect::to(route('pasien-list'))->with('msg', 'Data berhasil dihapus');
        }
    }

    function upload(Request $request){
        $validator = Validator::make($request->all(), $this->rulesUpload);
        if($validator->fails()){
            return Redirect::to(route('pasien-detail', $request->id_pasien))->withErrors(['error' => 'Data yang anda masukkan tidak valid']);
        }else{
            $pasien = Pasien::find($request->id_pasien);
            $file = $request->file('file');
            $dateFileName = $file->getClientOriginalName().now();
            $hashFileName = md5($dateFileName);
            $finalFilename = $hashFileName.'.'.$file->getClientOriginalExtension();
            $directory = 'pasien/'.$pasien->no_rekam_medis; 
            $file->move(storage_path($directory), $finalFilename);
            $save = FileStorage::insert(array(
                'keterangan' => $request->keterangan,
                'file_name' => $file->getClientOriginalName(),
                'tanggal' => $request->tanggal,
                'directory' => $directory.'/'.$finalFilename,
                'id_pasien' => $request->id_pasien
            ));
            if($save){
                return Redirect::to(route('pasien-detail', $request->id_pasien))->with('msg', 'Data berhasil disimpan'); 
            }else{
                return Redirect::to(route('pasien-detail', $request->id_pasien))->withErrors(['error' => 'Gagal menyimpan data']);
            }
        }
    }

    function viewFile($id){
        $file = FileStorage::find($id);
        $path = storage_path($file->directory);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;

    }

    function removeFile(Request $request){
        $file = FileStorage::find($request->id);
        unlink(storage_path($file->directory));
        $file->delete();
        return Redirect::to(route('pasien-detail', $request->id_pasien))->with('msg', 'Data berhasil dihapus');
    }
}
