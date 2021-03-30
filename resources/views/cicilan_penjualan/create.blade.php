@extends('layouts.app')
@section('content')

<div class="container mtb">

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Tambahkan cicilan penjualan</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('cicilan_penjualan.index') }}"> Back</a>
            </div>
        </div>
    </div>



<form action="{{route('cicilan_penjualan.store') }}" method="POST" enctype="multipart/form-data">
  
       <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">


        
             <div class="form-group">
       <strong>Tanggal:</strong>
       <p><input type="text" id="tanggal" name="tanggal" class="datepicker" value="<?php echo date("Y-m-d"); ?>"></p>
     </div>

  <div class="form-group">
                <strong>penjualan:</strong>
          <select name="idpenjualan" id="idpenjualan" class="form-control" required="">
           @foreach($penjualans as $penjualan)
            @if(!isset($penjualan->tgllunasjual))
            <option data-sisapiutang="{{  $penjualan->sisapiutang() }}" value="{{ $penjualan->idpenjualan }}" >id {{ $penjualan->idpenjualan}}, nota supplier {{ $penjualan->notasupplier}}, {{ $penjualan->pelanggan->nama}}  sisa piutang {{ number_format($penjualan->sisapiutang(),0,",",".") }}</option>
            @endif
            @endforeach
     
          </select>
            </div> 



        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-left">
             
              <div class="form-group">
                <strong>Tipe:</strong>
                <select name="tipe" id="tipe" class="form-control">
                  <option value="cicilan">cicilan</option>
                  <option value="pengampunan">pengampunan</option>
                </select>
            </div> 
        </div>
        
        <div class="col-xs-12 col-sm-12 col-md-12 text-left">
             
              <div class="form-group">
                <strong>total:</strong>
                <input type="number" id="jumlah" name="jumlah"  value="0" class="form-control" >
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


@include('partials.datepicker.javascript')

<script>
    $(function(){
       
       changeMaxBayar = function(){
        if($("#idpenjualan option:selected").length > 0){
          sisapiutang = $("#idpenjualan option:selected").attr("data-sisapiutang");
          $("#jumlah").val(sisapiutang);
          $("#jumlah").attr("max",sisapiutang);
        }
       }

       changeMaxBayar();

       $("#idpenjualan").change(function(){
          changeMaxBayar();
       });
     
       $("#idpenjualan").chosen({

       });
    });
</script>
@endsection