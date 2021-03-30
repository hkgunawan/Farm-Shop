<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pelanggan extends Model
{
    //
     protected $table = 'pelanggan';

       protected $primaryKey = 'idpelanggan'; 
     protected $fillable = array('telepon','nama','alamat');
     public $timestamps = false;
     
}
