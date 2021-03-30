@extends('layouts.app')

@section('content')
<div class="container">

@if (Auth::guest())

@elseif(Auth::user()->role==1 or Auth::user()->role==3)
@if (Auth::user()->aktif==1)
                      

    <legend>Dashboard</legend>
    <div class="row">
        <div class="col-md-12">
         <h3>Reminder Stok Minimal</h3>

            <table class="table table-border table-stripped ">
                <tr>
                    <th>Id Barang</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Stok Akhir</th>
                    <th>Stok Minimal</th>
             
                </tr>
            @foreach ($ReminderStok as $data)
            <tr>
          

                <td>{{ $data->idbarang}}</td>
                <td>{{ $data->nama}}</td>
                <td>{{ $data->kategori->nama_kategori}}</td>
                <td>{{ $data->stok}}</td>
                <td>{{ $data->stokmin}}</td>
                
            </tr>
            @endforeach
            </table>
         <br><br>

         <h3>Reminder Hutang Belum Dibayar</h3>
            <table class="table table-border table-stripped ">
                <tr>
                    <th>Id Pembelian</th> 
                    <th >Suplier</th>
                    <th >Tanggal</th>
                    <th >Total</th>
                    <th >Sisa Hutang</th>
                    <th >Jatuh Tempo</th>
             
                </tr>
            @foreach ($ReminderHutang as $data)
            <tr>
          
                <td>{{ $data->idpembelian}}</td>
                <td>{{ $data->suplier->nama}}</td>
                <td>{{ $data->tanggal}}</td>
                 <td align="right">Rp. {{ number_format($data->totalpembelian,0) }}</td>
                <td align="right">Rp. {{ number_format($data->sisahutang,0) }}</td>
                <td>{{ $data->jatuhtempo}}</td>
                
            </tr>
            @endforeach
            </table>
         <br><br>

         <h3>Reminder Piutang Belum Lunas</h3>
          <table class="table table-border table-stripped ">
                <tr>
                    <th> idpenjualan</th> 
                    <th >pelanggan</th>
                    <th >Tanggal</th>
                    <th >Total</th>
                    <th >Sisa piutang</th>
                    <th >Jatuh Tempo</th>
             
                </tr>
 @foreach ($ReminderPiutang as $data)
            <tr>
          
                <td>{{ $data->idpenjualan}}</td>
                <td>{{ $data->pelanggan->nama}}</td>
                <td>{{ $data->tanggal}}</td>
                 <td align="right">Rp. {{ number_format($data->totalpenjualan,0) }}</td>
                 <td align="right">Rp. {{ number_format($data->sisapiutang,0) }}</td>
                <td>{{ $data->jatuhtempo}}</td>
                
            </tr>
            @endforeach

         <br><br>
        </div>

    </div>
     @endif
     @endif
</div>
@endsection
