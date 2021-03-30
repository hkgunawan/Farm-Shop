<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class dpembelian extends Model
{
    //
     protected $table = 'dpembelian';
    protected $primaryKey = 'idpembelian'; 
     protected $fillable = array('idpembelian','idbarang','jumlah','harga','subtotal');
     public $timestamps = false;


             public function pembelian()
    {
        return $this->belongsTo('App\pembelian','idpembelian')->withDefault();
    }
         public function barang()
    {
        return $this->belongsTo('App\barang','idbarang')->withDefault();
    }
    
    public function subtotal(){
        return ($this->jumlah * $this->harga);
    }
}

