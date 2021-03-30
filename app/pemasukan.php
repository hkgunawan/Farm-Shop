<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pemasukan extends Model
{
    //
     protected $table = 'pemasukan';
     public $timestamps = false;
       protected $primaryKey = 'idpemasukan'; 
     protected $fillable = array('idpemasukan','tanggal','jumlahpemasukan','keterangan');
       public function user()
    {
        return $this->belongsTo('App\User','iduser')->withDefault();
    }
}
