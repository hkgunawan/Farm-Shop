@extends('layouts.app')
@section('content')

<div class="container mtb">

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Tambahkan barang</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('barang.index') }}"> Back</a>
            </div>
        </div>
    </div>



<form action="{{route('barang.store') }}" method="POST" enctype="multipart/form-data">
  
       <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Nama:</strong>
          <input type="text" class="form-control" name="nama" id="nama" placeholder="nama barang">
            </div> 
               <div class="form-group">
      <label>Gambar:</label>
      
      <input type="file" name="gambar" id="gambar">
      
    </div>
            <div class="form-group">
             <strong>Keterangan:</strong>
            <textarea class="form-control" id="keterangan" name="keterangan" id="mytextarea"></textarea>
            </div>
            <div class="form-group">
             <strong>Kategori:</strong>
             <select  class="form-control" id="id_kategori" name="id_kategori">


             @foreach ($Items as $Item)
  <option value="{{$Item->id_kategori}}"  > {{$Item->nama_kategori}} </option>
  @endforeach
</select>

            </div>
              <div class="form-group">
                <strong>harga_average:</strong>
          <input type="number" class="form-control" name="harga_average" id="harga_average" placeholder="harga_average">
            </div>
               <div class="form-group">
                <strong>harga_pedagang:</strong>
          <input type="number" class="form-control" name="harga_pedagang" id="harga_pedagang" placeholder="harga_pedagang">
            </div>

                <div class="form-group">
                <strong>harga_eceran:</strong>
          <input type="number" class="form-control" name="harga_eceran" id="harga_eceran" placeholder="harga_eceran">
            </div>

                <div class="form-group">
                <strong>harga_bon:</strong>
          <input type="number" class="form-control" name="harga_bon" id="harga_bon" placeholder="harga_bon">
            </div>

    <div class="form-group">
                <strong>stok:</strong>
          <input type="number" class="form-control" name="stok" id="stok" placeholder="stok">
            </div>

    <div class="form-group">
                <strong>stokmin:</strong>
          <input type="number" class="form-control" name="stokmin" id="stokmin" placeholder="stokmin">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </div>
    </div>
         
         </form>

</div>
@endsection

@section('script')


@include('partials.tinymce.javascript')

@endsection