<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pembelian extends Model
{
    //
     protected $table = 'pembelian';
    protected $primaryKey = 'idpembelian'; 
     protected $fillable = array('idsuplier','tanggal','tipepembelian','totalpembelian','tgllunasbeli','sisahutang');
    // public $timestamps = false;
       public function suplier()
    {
        return $this->belongsTo('App\suplier','idsuplier')->withDefault();
    }

      public function user()
    {
        return $this->belongsTo('App\User','iduser')->withDefault();
    }
         public function dpembelian()
    {
    	return $this->hasMany('App\dpembelian', 'idpembelian');
       
    }
    public function cicilan()
    {
        return $this->hasMany('App\cicilan_pembelian', 'idpembelian');
       
    }
    public function returbeli()
    {
        return $this->hasMany('App\returbeli', 'idpembelian');
       
    }
    public function totalpembelian(){
        $total = 0;
        foreach($this->dpembelian as $dp){
          $total += ($dp->jumlah * $dp->harga);
        }
        return $total;
    }
    public function sisahutang(){
        if($this->tipepembelian == "Tunai"){
            return 0;
        }
        else{
            
            $sisa = $this->totalpembelian();
            foreach($this->cicilan as  $cicil){
              $sisa = $sisa - $cicil->jumlah;
            }
            foreach($this->returbeli as $r){
              $sisa = $sisa - $r->totalrpembelian();
            }

            if($sisa < 0){
              $sisa = 0;
            }
            return $sisa;
        }
    }


}
