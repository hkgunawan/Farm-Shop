<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class drbeli extends Model
{
    //
     protected $table = 'drbeli';

    protected $primaryKey = 'iddrbeli'; 
     protected $fillable = array('iddrbeli','idrpembelian','idbarang','jumlah','harga');
     public $timestamps = false;

             public function returbeli()
    {
        return $this->belongsTo('App\returbeli','idrpembelian')->withDefault();
    }
         public function barang()
    {
        return $this->belongsTo('App\barang','idbarang')->withDefault();
    }
    public function subtotal(){
        return $this->jumlah * $this->harga;
    }

}
