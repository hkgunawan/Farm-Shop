@extends('layouts.app')

@section('content')

<div class="container mtb">

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit pelanggan</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('pelanggan.index') }}"> Back</a>
            </div>
        </div>
    </div>
   @include('partials.alerts.errors')


<form action="{{route('pelanggan.update',$task->idpelanggan)}}" method="POST" enctype="multipart/form-data">

    {{ method_field('PATCH') }}
 
  
  <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            
               <div class="form-group">
                <strong>Nama:</strong>
          <input type="text" class="form-control" name="nama" id="nama" placeholder="nama suplier" value="{{$task->nama}}">
            </div> 
    </div>
     <div class="form-group">
                <strong>Telepon:</strong>
          <input type="text" class="form-control" name="telepon" id="telepon" placeholder="telepon " value="{{$task->telepon}}">
            </div> 

             <div class="form-group">
                <strong>alamat:</strong>
          <input type="text" class="form-control" name="alamat" id="alamat" placeholder="alamat" value="{{$task->alamat}}">
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