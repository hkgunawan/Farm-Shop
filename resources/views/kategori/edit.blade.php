@extends('layouts.app')

@section('content')

<div class="container mtb">

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit kategori</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('kategori.index') }}"> Back</a>
            </div>
        </div>
    </div>
   @include('partials.alerts.errors')


<form action="{{route('kategori.update',$task->id_kategori)}}" method="POST" enctype="multipart/form-data">

    {{ method_field('PATCH') }}
 
  
  <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            
               <div class="form-group">
                <strong>Nama:</strong>
          <input type="text" class="form-control" name="nama_kategori" id="nama_kategori" placeholder="nama kategori" value="{{$task->nama_kategori}}">
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