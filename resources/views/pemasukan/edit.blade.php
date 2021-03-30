@extends('layouts.app')

@section('content')

<div class="container mtb">

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit pemasukan</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('pemasukan.index') }}"> Back</a>
            </div>
        </div>
    </div>
   @include('partials.alerts.errors')


<form action="{{route('pemasukan.update',$task->idpemasukan)}}" method="POST" enctype="multipart/form-data">

    {{ method_field('PATCH') }}
 
  
  <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
                 <div class="form-group">
       <strong>Tanggal:</strong>
       <p><input type="text" id="tanggal" name="tanggal" class="datepicker" value="{{$task->tanggal}}"></p>
     </div>
               
            <div class="form-group">
             <strong>Keterangan:</strong>
            <textarea class="form-control" id="keterangan" name="keterangan" id="keterangan">{{$task->keterangan}}</textarea>
            </div>
      

                <div class="form-group">
                <strong>jumlahpemasukan:</strong>
          <input type="number" class="form-control" name="jumlahpemasukan" id="jumlahpemasukan" placeholder="jumlahpemasukan" value="{{$task->jumlahpemasukan}}">
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
@include('partials.datepicker.javascript')
@endsection