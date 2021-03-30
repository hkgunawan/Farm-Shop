<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cicilan_pembelian extends Model
{
    //
     protected $table = 'cicilan_pembelian';
    protected $primaryKey = 'idcbeli'; 
     protected $fillable = array('idcbeli','idpembelian','jumlah','tanggal');
     public $timestamps = false;
       public function pembelian()
    {
        return $this->belongsTo('App\pembelian','idpembelian')->withDefault();
    }
      public function user()
    {
        return $this->belongsTo('App\User','iduser')->withDefault();
    }
     
}