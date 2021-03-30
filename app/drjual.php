<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class drjual extends Model
{
    //
     protected $table = 'drjual';
    protected $primaryKey = 'iddrjual'; 
     protected $fillable = array('iddrjual','idrpenjualan','idbarang','jumlah','harga','iddpenjualan');
     public $timestamps = false;
        public function returjual()
    {
        return $this->belongsTo('App\returjual','idrpenjualan')->withDefault();
    }
         public function barang()
    {
        return $this->belongsTo('App\barang','idbarang')->withDefault();
    }
         public function dpenjualan()
    {
        return $this->belongsTo('App\dpenjualan','iddpenjualan')->withDefault();
    }
    public function subtotal(){
        return $this->jumlah * $this->harga;
    }

}
