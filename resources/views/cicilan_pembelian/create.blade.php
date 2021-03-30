@extends('layouts.app')
@section('content')

<div class="container mtb">

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Tambahkan Cicilan</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('pembelian.index') }}"> Back</a>
            </div>
        </div>
    </div>



<form action="{{route('cicilan_pembelian.store') }}" method="POST" enctype="multipart/form-data">
  
       <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">


        
             <div class="form-group">
       <strong>Tanggal:</strong>
       <p><input type="text" id="tanggal" name="tanggal" class="datepicker" value="<?php echo date("Y-m-d"); ?>"></p>
     </div>

  <div class="form-group">
                <strong>Pembelian:</strong>
          <select name="idpembelian" id="idpembelian" class="form-control" required="">
            @foreach($pembelians as $pembelian)
              @if ($pembelian->sisahutang() > 0)
            <option data-sisahutang="{{  $pembelian->sisahutang() }}" value="{{ $pembelian->idpembelian }}" >id {{ $pembelian->idpembelian}}, nota supplier {{ $pembelian->notasupplier}}, {{ $pembelian->suplier->nama}}  sisa hutang {{ number_format($pembelian->sisahutang(),0,",",".") }}</option>
              @endif
            @endforeach
          </select>
            </div> 



        </div>
        
        <div class="col-xs-12 col-sm-12 col-md-12 text-left">
             
              <div class="form-group">
                <strong>Total:</strong>
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
        if($("#idpembelian option:selected").length > 0){
          sisahutang = $("#idpembelian option:selected").attr("data-sisahutang");
          $("#jumlah").val(sisahutang);
          $("#jumlah").attr("max",sisahutang);
        }
       }

       changeMaxBayar();

       $("#idpembelian").change(function(){
          changeMaxBayar();
       });
     
       $("#idpembelian").chosen({

       });
      
    });
</script>
@endsection