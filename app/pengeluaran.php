<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pengeluaran extends Model
{
    //
     protected $table = 'pengeluaran';
     public $timestamps = false;
       protected $primaryKey = 'idpengeluaran'; 
         public function user()
    {
        return $this->belongsTo('App\User','iduser')->withDefault();
    }
     protected $fillable = array('idpengeluaran','tanggal','jumlahpengeluaran','keterangan');
}
