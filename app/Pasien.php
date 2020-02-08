<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    //
    protected $table = "pasien";
    protected $fillable = ['nama', 'no_rekam_medis', 'tanggal', 'alamat', 'usia', 'jenis_kelamin', 'pekerjaan'];
}
