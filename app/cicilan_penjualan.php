<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cicilan_penjualan extends Model
{
    //
     protected $table = 'cicilan_penjualan';
    protected $primaryKey = 'idcjual'; 
     protected $fillable = array('idcjual','idpenjualan','jumlah','tanggal','tipe');
     public $timestamps = false;

       public function penjualan()
    {
        return $this->belongsTo('App\penjualan','idpenjualan')->withDefault();
    }
      public function user()
    {
        return $this->belongsTo('App\User','iduser')->withDefault();
    }
}