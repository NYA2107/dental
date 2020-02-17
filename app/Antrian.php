<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    //
    protected $table = "antrian";
    protected $fillable = ['antrian'];

    public function antrian(){
        return $this->belongsTo('App\Pasien', 'id_pasien', 'id');
    }
}
