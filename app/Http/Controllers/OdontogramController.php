<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Odontogram;

class OdontogramController extends Controller
{
    //
    function get($id_pasien){
        $odontogram = Odontogram::where('id_pasien', $id_pasien)->first();
        if($odontogram){
            return [
                'id' => $odontogram->id,
                'id_pasien' => $odontogram->id_pasien,
                'odontogram' => json_decode($odontogram->odontogram)
            ];
        }
    }

    function set(Request $request){
        $odontogram = Odontogram::where('id_pasien', (int)$request->id_pasien)->first();
        $odontogram->odontogram = json_encode($request->odontogram);
        if($odontogram->save()){
            return ['msg'=>'success'];
        }else{
            return ['msg'=>'fail'];
        }
    }
}
