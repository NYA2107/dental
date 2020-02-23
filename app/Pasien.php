<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    //
    protected $table = "pasien";
    protected $fillable = ['nama', 'no_rekam_medis', 'tanggal', 'alergi_obat', 'riwayat_penyakit', 'alamat', 'tanggal_lahir', 'jenis_kelamin', 'pekerjaan'];

    public function kunjungan(){
        return $this->hasMany('App\Kunjungan', 'id_pasien', 'id');
    }

    public function odontogram(){
        return $this->hasMany('App\Odontogram', 'id_pasien', 'id');
    }

    public function antrian(){
        return $this->hasMany('App\Antrian', 'id_pasien', 'id');
    }

    public function file(){
        return $this->hasMany('App\FileStorage', 'id_pasien', 'id');
    }
}
