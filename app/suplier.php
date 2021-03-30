<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class suplier extends Model
{
    //
     protected $table = 'suplier';
       protected $primaryKey = 'idsuplier'; 
     protected $fillable = array('telepon','nama','alamat','keterangan');
     public $timestamps = false;
}
