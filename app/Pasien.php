<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    //
    protected $table = "pasien";
    protected $fillable = ['nama', 'no_rekam_medis', 'tanggal', 'alamat', 'tanggal_lahir', 'jenis_kelamin', 'pekerjaan'];

    public function kunjungan(){
        return $this->hasMany('App\Kunjungan', 'id_pasien', 'id');
    }

    public function file(){
        return $this->hasMany('App\FileStorage', 'id_pasien', 'id');
    }
}
