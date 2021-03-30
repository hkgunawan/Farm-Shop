@extends('layouts.app')
@section('content')

<div class="container mtb">

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Tambahkan penjualan</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('penjualan.index') }}"> Back</a>
            </div>
        </div>
    </div>



<form action="{{route('penjualan.store') }}" method="POST" enctype="multipart/form-data">
  
       <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">


        
             <div class="form-group">
       <strong>Tanggal:</strong>
       <p><input type="text" id="tanggal" name="tanggal" class="datepicker" 
        value="{{ date("Y-m-d") }}  "></p>
     </div>

  <div class="form-group">
                <strong>Pelanggan:</strong>
          <select name="idpelanggan" id="idpelanggan" class="form-control">
             <option value="0" >eceran</option>
            @foreach($pelanggans as $pelanggan)
            <option value="{{ $pelanggan->idpelanggan }}" >{{ $pelanggan->nama}}</option>
            @endforeach
          </select>
            </div> 

              <div class="form-group">
                <strong>Tipe Penjualan:</strong>
          <select name="tipepenjualan" id="tipepenjualan" class="form-control">
           
            <option value="Tunai" >Tunai</option>
            <option id="opt1" value="Kredit" >Kredit</option>

          </select>
            </div> 


             <div class="form-group div-kredit" >
       <strong>Tanggal Jatuh Tempo:</strong>
       <p><input type="text" id="jatuhtempo" name="jatuhtempo" class="datepicker" value="{{ date("Y-m-d",time()+(2*30*86400)) }}"></p>
     </div>


        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-left">
            <h3>Detail Penjualan</h3>
             <div class="form-group">
              <strong>Barang:</strong>
              <select id="idbarang" class="form-control">
                @foreach($barangs as $barang)
                <option value="{{ $barang->idbarang }}" data-nama="{{ $barang->nama}}" data-hargaeceran="{{ $barang->harga_eceran }}" data-hargapedagang="{{ $barang->harga_pedagang }}" data-hargabon="{{ $barang->harga_bon }}" data-stok="{{ $barang->stok }}">{{ $barang->nama}}, stok {{ $barang->stok}}</option>
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
                      <th>Potongan</th>
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
                <input type="number" id="totalpenjualan" name="totalpenjualan" readonly value="0" class="form-control" >
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
              hargabon = parseInt($("#idbarang option:selected").attr("data-hargabon"));
              hargaeceran = parseInt($("#idbarang option:selected").attr("data-hargaeceran"));
              hargapedagang = parseInt($("#idbarang option:selected").attr("data-hargapedagang"));
              harga = 0;
              if($("#idpelanggan").val() == "0"){
                harga = hargaeceran;
              }
              else{
                if($("#tipepenjualan").val() == "Kredit"){
                  harga = hargabon;
                }
                else{
                  harga = hargapedagang;
                }
              }
              stok = $("#idbarang option:selected").attr("data-stok");
              if(parseInt(stok) < jumlah){
                alert("Jumlah harus lebih kecil dari stok");
                return false;
              }
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

              subtotal = jumlah * harga;
              s = '<tr id="baris_'+n+'">';
              s = s + '<td><input type="text" readonly id="idbarang_'+n+'" name="idbarang[]" class="form-control" value="'+idbarang+'"></td>';
              s = s + '<td><input type="text" readonly id="namabarang_'+n+'" name="namabarang[]" class="form-control" value="'+namabarang+'"></td>';
              //s = s + '<td><input type="text" readonly id="stok_'+n+'" name="stok[]" class="form-control" value="'+stok+'">';
              s = s + '<td><input type="number" onchange="editBarang('+n+')"  id="jumlah_'+n+'" name="jumlah[]" class="form-control" value="'+jumlah+'"></td>';
              s = s + '<td><input type="text" readonly id="harga_'+n+'" name="harga[]" class="form-control" value="'+harga+'">';
              s = s + '<input type="hidden" readonly id="hargabon_'+n+'" name="hargabon[]" class="form-control" value="'+hargabon+'">';
              s = s + '<input type="hidden" readonly id="hargaeceran_'+n+'" name="hargaeceran[]" class="form-control" value="'+hargaeceran+'">';
              s = s + '<input type="hidden" readonly id="hargapedagang_'+n+'" name="hargapedagang[]" class="form-control" value="'+hargapedagang+'">';
              s = s + '</td>';
              s = s + '<td><input type="number"  onchange="editBarang('+n+')"  required id="potongan_'+n+'" name="potongan[]" class="form-control" value="0"></td>';
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
          potongan = parseInt($("#potongan_"+i).val());
          subtotal = (jumlah * harga) - potongan;
          $("#subtotal_"+i).val(subtotal);
          hitungTotal();

        }
        deleteBarang=function(i){
          $("#baris_"+i).remove();
          hitungTotal();
        }

        changeHarga = function(){
          var hrg = "";
          if($("#idpelanggan").val() == "0"){
            hrg = "hargaeceran";
          }
          else{
            if($("#tipepenjualan").val() == "Kredit"){
              hrg = "hargabon";
            }
            else{
              hrg = "hargapedagang";
            }
          }

          for(i=0; i<n; i++){
            if($("#idbarang_"+i).length > 0){
              $("#harga_"+i).val($("#"+hrg+"_"+i).val());
              editBarang(i);
            }
          }
          hitungTotal();

        }

        hitungTotal = function(){
          var totalpenjualan = 0;
          for(i=0; i<n; i++){
            if($("#idbarang_"+i).length > 0){
              subtotal = parseInt($("#subtotal_"+i).val());
              totalpenjualan = totalpenjualan + subtotal;
            }
          }
          $("#totalpenjualan").val(totalpenjualan);
        }

         cekpelanggan = function(){
            if($("#idpelanggan").val() == "0"){
                $("#tipepenjualan").val("Tunai");
                $("#opt1").attr("disabled","disabled");
                changeHarga();
            }
            else{
                $("#opt1").removeAttr("disabled");
                changeHarga();
            }
        };

        cekpelanggan();
        $("#idpelanggan").change(function(r){
          cekpelanggan();
        });

        cektipepenjualan = function(){
            if($("#tipepenjualan").val() == "Kredit"){
                 $(".div-kredit").show();
                changeHarga();
            }
            else{
                 $(".div-kredit").hide();
                changeHarga();
            }
        };

        cektipepenjualan();
        $("#tipepenjualan").change(function(r){
          cektipepenjualan();
        });
      
        $("#idbarang").chosen({

        });

        $("#idpelanggan").chosen({

        });
    });
</script>
@endsection