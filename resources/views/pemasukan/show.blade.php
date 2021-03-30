@extends('layouts.app')

@section('content')

<div class="container mtb">

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Pemasukan</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('pemasukan.index') }}"> Back</a>
            </div>
        </div>
    </div>
   @include('partials.alerts.errors')


    {{ method_field('PATCH') }}
 
  
  <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">

            <table class="table">
              <tr>
                <td width="100">Tanggal</td>
                <td>: {{ $task->tanggal }}</td>
              </tr>
              <tr>
                <td >Keterangan</td>
                <td>: {{ $task->keterangan }}</td>
              </tr>
              <tr>
                <td >Total</td>
                <td>:{{ number_format($task->jumlahpemasukan,0,",",".")}}</td>
              </tr>
            </table>
                
                
        </div>

               

    </div>


</div>
@endsection

@section('script')

@include('partials.tinymce.javascript')
@include('partials.datepicker.javascript')
@endsection