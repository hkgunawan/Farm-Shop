<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class dpenjualan extends Model
{
    //
     protected $table = 'dpenjualan';
    protected $primaryKey = 'iddpenjualan'; 
     protected $fillable = array('idpenjualan','idbarang','jumlah','harga','potongan');
     public $timestamps = false;


             public function penjualan()
    {
        return $this->belongsTo('App\penjualan','idpenjualan')->withDefault();
    }
         public function barang()
    {
        return $this->belongsTo('App\barang','idbarang')->withDefault();
    }

    public function drjual()
    {
        return $this->hasMany('App\drjual', 'iddpenjualan');
       
    }
    public function jumlahretur(){
         $total = 0;
        foreach($this->drjual as $dp){
          $total += $dp->jumlah;
        }
        return $total;
    }
    public function subtotal(){
        return (($this->jumlah * $this->harga) - $this->potongan);
    }
    
}
