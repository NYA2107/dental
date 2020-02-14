<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    //
    protected $table = "kunjungan";
    protected $fillable = ['tanggal', 'anamnesa', 'diagnosa', 'tindakan', 'biaya', 'id_pasien', 'id_dokter'];

    public function pasien(){
        return $this->belongsTo('App\Pasien', 'id_pasien', 'id');
    }

    public function dokter(){
        return $this->belongsTo('App\Dokter', 'id_dokter', 'id');
    }
}
