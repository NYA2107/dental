<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Odontogram extends Model
{
    //
    protected $table = "odontogram";
    protected $fillable = ['odontogram', 'id_pasien'];

    public function pasien(){
        return $this->belongsTo('App\Pasien', 'id_pasien', 'id');
    }
}
