<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    //
    protected $table = "dokter";
    protected $fillable = ['nama'];

    public function kunjungan(){
        return $this->hasMany('App\Kunjungan', 'id_dokter', 'id');
    }
}
