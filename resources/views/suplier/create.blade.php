@extends('layouts.app')
@section('content')

<div class="container mtb">

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Tambahkan suplier</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('suplier.index') }}"> Back</a>
            </div>
        </div>
    </div>



<form action="{{route('suplier.store') }}" method="POST" enctype="multipart/form-data">
  
       <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Nama:</strong>
          <input type="text" class="form-control" name="nama" id="nama" placeholder="nama suplier">
            </div> 
  <div class="form-group">
                <strong>Telepon:</strong>
          <input type="text" class="form-control" name="telepon" id="telepon" placeholder="telepon ">
            </div> 


          <div class="form-group">
             <strong>Keterangan:</strong>
            <textarea class="form-control" id="keterangan" name="keterangan" id="mytextarea"></textarea>
            </div>
             <div class="form-group">
                <strong>alamat:</strong>
          <input type="text" class="form-control" name="alamat" id="alamat" placeholder="alamat">
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