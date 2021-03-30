@extends('layouts.app')
@section('content')

<div class="container mtb">

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Tambahkan pembelian</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('pembelian.index') }}"> Back</a>
            </div>
        </div>
    </div>



<form action="{{route('pembelian.store') }}" method="POST" enctype="multipart/form-data">
  
       <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">


        
             <div class="form-group">
       <strong>Tanggal:</strong>
       <p><input type="text" id="tanggal" name="tanggal" class="datepicker" value="{{ date("Y-m-d") }}"></p>
     </div>


             <div class="form-group">
       <strong>Nota Supplier:</strong>
       <p><input type="text" id="notasupplier" required name="notasupplier" class="" value=""></p>
     </div>
  <div class="form-group">
                <strong>suplier:</strong>
          <select name="idsuplier" id="idsuplier" class="form-control">
            @foreach($supliers as $suplier)
            <option value="{{ $suplier->idsuplier }}" >{{ $suplier->nama}}</option>
            @endforeach
          </select>
            </div> 

              <div class="form-group">
                <strong>Tipe pembelian:</strong>
          <select name="tipepembelian" id="tipepembelian" class="form-control">
           
            <option value="Tunai" >Tunai</option>
            <option id="opt1" value="Kredit" >Kredit</option>

          </select>
            </div> 


        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-left">
            <h3>Detail pembelian</h3>
             <div class="form-group">
              <strong>Barang:</strong>
              <select  id="idbarang" class="form-control">
                @foreach($barangs as $barang)
                <option value="{{ $barang->idbarang }}" data-nama="{{ $barang->nama}}" data-hargaeceran="{{ $barang->harga_eceran }}" data-hargapedagang="{{ $barang->harga_pedagang }}" data-hargabon="{{ $barang->harga_bon }}" data-stok="{{ $barang->stok }}" data-hargaaverage="{{ $barang->harga_average }}">{{ $barang->nama}}, stok {{ $barang->stok}}</option>
                @endforeach
              </select>
            </div> 
              <div class="form-group">
                <strong>Jumlah:</strong>
                <input type="number" id="jumlah" class="form-control" >
            </div> 
            <div class="form-group">
                <button type="button" class="btn btn-primary" onclick="addBarang()">Add Detail</button>
            </div> 
            <div class="form-group">
              <table class="table table-bordered table-stripped">
                  <thead>
                    <tr>
                      <th>Kode Barang</th>
                      <th>Nama Barang</th>
                      <th>Jumlah</th>
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
                <input type="number" id="totalpembelian" name="totalpembelian" readonly value="0" class="form-control" >
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

        addBarang = function(){
            if($("#idbarang").val() != "" && $("#jumlah").val() != ""){
              idbarang=$("#idbarang").val();
              namabarang = $("#idbarang option:selected").attr("data-nama");
              jumlah = parseInt($("#jumlah").val());
              harga = $("#idbarang option:selected").attr("data-hargaaverage");;
              
              subtotal = jumlah * harga;
              stok = $("#idbarang option:selected").attr("data-stok");

              ada = false;
              for(i=0; i<n; i++){
                if($("#idbarang_"+i).length > 0){
                  if(idbarang == $("#idbarang_"+i).val()){
                    alert('barang sudah ada');
                    ada = true;
                    return false;
                  }
                }
              }

              s = '<tr id="baris_'+n+'">';
              s = s + '<td><input type="text" readonly id="idbarang_'+n+'" name="idbarang[]" class="form-control" value="'+idbarang+'"></td>';
              s = s + '<td><input type="text" readonly id="namabarang_'+n+'" name="namabarang[]" class="form-control" value="'+namabarang+'"></td>';
              //s = s + '<td><input type="text" readonly id="stok_'+n+'" name="stok[]" class="form-control" value="'+stok+'">';
              s = s + '<td><input type="number" onchange="editBarang('+n+')"  id="jumlah_'+n+'" name="jumlah[]" class="form-control" value="'+jumlah+'"></td>';
              s = s + '<td><input type="number" onchange="editBarang('+n+')"  id="harga_'+n+'" name="harga[]" class="form-control" value="'+harga+'">';
              s = s + '</td>';
              s = s + '<td><input type="text" readonly id="subtotal_'+n+'" name="subtotal[]" class="form-control" value="'+subtotal+'"></td>';
              s = s + '<td><button type="button" class="btn btn-danger" onclick="deleteBarang('+n+')" > X </button></td>';

              n++;
              $("#data_detail").append(s);
              hitungTotal();
            }
            else{
              alert("Data belum lengkap");
            }
        }
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
          var totalpembelian = 0;
          for(i=0; i<n; i++){
            if($("#idbarang_"+i).length > 0){
              subtotal = parseInt($("#subtotal_"+i).val());
              totalpembelian = totalpembelian + subtotal;
            }
          }
          $("#totalpembelian").val(totalpembelian);
        }

       $("#idbarang").chosen({

       });

       $("#idsuplier").chosen({

       });
       
      
    });
</script>
@endsection