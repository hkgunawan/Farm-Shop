<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class returbeli extends Model
{
    //
     protected $table = 'retur_pembelian';
         protected $primaryKey = 'idrpembelian'; 
     protected $fillable = array('idrpembelian','idpembelian','jumlah','tanggal');
     public $timestamps = false;
  public function user()
    {
        return $this->belongsTo('App\User','iduser')->withDefault();
    }
         public function pembelian()
    {
        return $this->belongsTo('App\pembelian','idpembelian')->withDefault();
    }
    public function drbeli()
    {
        return $this->hasMany('App\drbeli', 'idrpembelian');
       
    }
     
    public function totalrpembelian(){
        $total = 0;
        foreach($this->drbeli as $dp){
          $total += ($dp->jumlah * $dp->harga);
        }
        return $total;
    }
}
