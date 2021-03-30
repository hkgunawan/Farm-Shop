<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class barang extends Model
{
    //
    protected $table = 'barang';

    protected $primaryKey = 'idbarang'; 
     protected $fillable = array('gambar','nama','id_kategori','keterangan','harga_pedagang','harga_eceran','harga_bon','harga_average','stok','stokmin');
      public function kategori()
    {
        return $this->belongsTo('App\kategori','id_kategori')->withDefault();
    }
}
