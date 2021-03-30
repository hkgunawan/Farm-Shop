@extends('layouts.app')

@section('content')

<div class="container mtb">

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit barang</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('barang.index') }}"> Back</a>
            </div>
        </div>
    </div>
   @include('partials.alerts.errors')


<form action="{{route('barang.update',$task->idbarang)}}" method="POST" enctype="multipart/form-data">

    {{ method_field('PATCH') }}
 
  
  <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            
               <div class="form-group">
                <strong>Nama:</strong>
          <input type="text" class="form-control" name="nama" id="nama" placeholder="nama barang" value="{{$task->nama}}">
            </div> 
               <div class="form-group">
      <label>Gambar:</label>
      
    <img 
      class="img-responsive" src="{{ asset($task->gambar) }}" alt="">
    </div>
               <div class="form-group">
      <label>Upload Ulang Gambar:</label>
      
      <input type="file" name="gambar" id="gambar">
      
    </div>
            <div class="form-group">
             <strong>Keterangan:</strong>
            <textarea class="form-control" id="keterangan" name="keterangan" id="mytextarea" >{{$task->nama}}</textarea>
            </div>
             <div class="form-group">
                <strong>jenis:</strong>
          <input type="text" class="form-control" name="jenis" id="jenis" placeholder="jenis" value="{{$task->jenis}}">
            </div>
              <div class="form-group">
                <strong>harga_pedagang:</strong>
          <input type="number" class="form-control" name="harga_pedagang" id="harga_pedagang" placeholder="harga_pedagang" value="{{$task->harga_pedagang}}">
            </div>

                <div class="form-group">
                <strong>harga_eceran:</strong>
          <input type="number" class="form-control" name="harga_eceran" id="harga_eceran" placeholder="harga_eceran" value="{{$task->harga_eceran}}">
            </div>

                <div class="form-group">
                <strong>harga_bon:</strong>
          <input type="number" class="form-control" name="harga_bon" id="harga_bon" placeholder="harga_bon" value="{{$task->harga_bon}}">
            </div>

    <div class="form-group">
                <strong>stok:</strong>
          <input type="number" class="form-control" name="stok" id="stok" placeholder="stok" value="{{$task->stok}}">
            </div>

    <div class="form-group">
                <strong>stokmin:</strong>
          <input type="number" class="form-control" name="stokmin" id="stokmin" placeholder="stokmin" value="{{$task->stokmin}}">
            </div>
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