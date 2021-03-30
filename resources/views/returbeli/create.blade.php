@extends('layouts.app')
@section('content')

<div class="container mtb">

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Tambahkan returbeli</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('returbeli.index') }}"> Back</a>
            </div>
        </div>
    </div>



<form action="{{route('returbeli.store') }}" method="POST" enctype="multipart/form-data">
  
       <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">


        
             <div class="form-group">
       <strong>Tanggal:</strong>
       <p><input type="text" id="tanggal" name="tanggal" class="datepicker" 
         value="{{ date("Y-m-d") }}"></p>
     </div>

  <div class="form-group">
                <strong>pembelian:</strong>
          <select name="idpembelian" id="idpembelian" class="form-control" required="">
              <option value="">Pilih Nota pembelian</option>
            @foreach($pembelians as $pembelian)
            <option data-sisapiutang="{{  $pembelian->sisapiutang }}" value="{{ $pembelian->idpembelian }}" >id {{ $pembelian->idpembelian}}, nota supplier {{ $pembelian->notasupplier}} {{$pembelian->suplier->nama}}</option>
            @endforeach
          </select>
            </div> 




        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-left">
            <h3>Detail returbeli</h3>
             
            <div class="form-group">
              <table class="table table-bordered table-stripped">
                  <thead>
                    <tr>
                      <th>Kode Barang</th>
                      <th>Nama Barang</th>
                      <th>Jumlah beli</th>
                      <th>Jumlah Retur</th>
                      <th>Harga</th>
                      <th>Sub Total</th>
                      <th>Hapus</th>
                    </tr>
                  </thead>
                  <tbody id="data_detail">

                  </tbody>
              </table>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-left">
             
              <div class="form-group">
                <strong>Total:</strong>
                <input type="number" id="totalreturbeli" name="totalreturbeli" readonly value="0" class="form-control" >
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
       
        var n=0;

        
        editBarang=function(i){
          jumlah = parseInt($("#jumlah_"+i).val());
          harga = parseInt($("#harga_"+i).val());
          subtotal = jumlah * harga;
          $("#subtotal_"+i).val(subtotal);
          hitungTotal();

        }
        deleteBarang=function(i){
          $("#baris_"+i).remove();
          hitungTotal();
        }

        hitungTotal = function(){
          var totalreturbeli = 0;
          for(i=0; i<n; i++){
            if($("#idbarang_"+i).length > 0){
              subtotal = parseInt($("#subtotal_"+i).val());
              totalreturbeli = totalreturbeli + subtotal;
            }
          }
          $("#totalreturbeli").val(totalreturbeli);
        }

         cekpembelian = function(){
           $.get("/returbeli/ajax/"+$("#idpembelian").val(),function(data){
              $("#data_detail").html(data);
              n = $("#n").val();
              hitungTotal();
           });
        };

        cekpembelian();
        $("#idpembelian").change(function(r){
          cekpembelian();
        });
      
       $("#idpembelian").chosen({

       });
    });
</script>
@endsection