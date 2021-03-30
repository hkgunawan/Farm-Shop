@extends('layouts.app')
@section('content')

<div class="container mtb">

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Tambahkan pemasukan</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('pemasukan.index') }}"> Back</a>
            </div>
        </div>
    </div>



<form action="{{route('pemasukan.store') }}" method="POST" enctype="multipart/form-data">
  
       <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
     <div class="form-group">
       <strong>Tanggal:</strong>
       <p><input type="text" id="tanggal" name="tanggal" class="datepicker"></p>
     </div>
               
            <div class="form-group">
             <strong>Keterangan:</strong>
            <textarea class="form-control" id="keterangan" name="keterangan" id="mytextarea"></textarea>
            </div>
      

                <div class="form-group">
                <strong>total:</strong>
          <input type="number" class="form-control" name="jumlahpemasukan" id="jumlahpemasukan" placeholder="jumlahpemasukan">
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