<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class penjualan extends Model
{
    //
     protected $table = 'penjualan';
    protected $primaryKey = 'idpenjualan'; 
     protected $fillable = array('idpelanggan','tanggal','tipepenjualan','totalpenjualan','tgllunasjual','sisapiutang');
     public $timestamps = false;
     public function pelanggan()
    {
        return $this->belongsTo('App\pelanggan','idpelanggan')->withDefault();
    }
      public function user()
    {
        return $this->belongsTo('App\User','iduser')->withDefault();
    }
         public function dpenjualan()
    {
        return $this->hasMany('App\dpenjualan', 'idpenjualan');
       
    }
    public function cicilan()
    {
        return $this->hasMany('App\cicilan_penjualan', 'idpenjualan');
       
    }
    public function returjual()
    {
        return $this->hasMany('App\returjual', 'idpenjualan');
       
    }

    public function totalpenjualan()
    {
       $total = 0;
       foreach($this->dpenjualan as $dp)
       {
        $total += (($dp->jumlah * $dp->harga) - $dp->potongan);
       }
       return $total;
    }
    public function sisapiutang(){
        if($this->tipepenjualan == "Tunai"){
          return 0;
        }
        else
        {
          
          $sisa = $this->totalpenjualan();
          foreach($this->cicilan as  $cicil){
            $sisa = $sisa - $cicil->jumlah;
          }
         /* foreach($this->returjual as $r){
            $sisa = $sisa - $r->totalrpejualan();
          }*/

          if($sisa < 0){
            $sisa = 0;
          }
          return $sisa;
        }
    }
}
