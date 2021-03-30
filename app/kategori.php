<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class kategori extends Model
{
    //

    protected $table = 'kategori';

    protected $primaryKey = 'id_kategori'; 
     protected $fillable = array('nama_kategori');
     public $timestamps = false;
        public function barang()
    {
        return $this->hasMany('App\barang');
    }
}
