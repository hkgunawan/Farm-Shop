<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class returjual extends Model
{
    //
     protected $table = 'retur_penjualan';
    protected $primaryKey = 'idrpenjualan'; 
     protected $fillable = array('idrpenjualan','idpenjualan','jumlah','tanggal');
     public $timestamps = false;
       public function user()
    {
        return $this->belongsTo('App\User','iduser')->withDefault();
    }
     
    public function penjualan()
    {
        return $this->belongsTo('App\penjualan','idpenjualan')->withDefault();
    }
     public function drjual()
    {
        return $this->hasMany('App\drjual', 'idrpenjualan');
       
    }
     
    public function totalrpenjualan(){
        $total = 0;
        foreach($this->drjual as $dp){
          $total += ($dp->jumlah * $dp->harga);
        }
        return $total;
    }
}
