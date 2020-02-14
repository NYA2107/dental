<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileStorage extends Model
{
    //
    protected $table = "file_storage";
    protected $fillable = ['keterangan', 'directory', 'id_pasien'];

    public function pasien(){
        return $this->belongsTo('App\Pasien', 'id_pasien', 'id');
    }
}
