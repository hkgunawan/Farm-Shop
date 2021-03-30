@extends('layouts.app')
@section('content')
<div class=" container">
<h3>Cicilan Hutang</h3>
<table class="table">
  <tr>
    <td width="300">Tanggal</td>
    <td>: {{ $items->tanggal }}</td>
  </tr>
  <tr>
    <td>Suplier</td>
    <td>:  @if($items->pembelian->idsuplier) 
           {{ $items->pembelian->suplier->nama}}
           @else
           eceran
           @endif</td>
  </tr>
  <tr>
    <td>Nota Suplier</td>
    <td>: {{ $items->pembelian->notasupplier}}</td>
  </tr>
  <tr>
    <td >Total</td>
    <td>: Rp {{ number_format($items->jumlah) }}</td>
  </tr>
  <tr>
    <td >Hutang Awal</td>
    <td>: Rp {{ number_format($items->pembelian->totalpembelian(),0) }}</td>
  </tr>
  <tr>
    <td >Informasi Cicilan Pembelian Ini</td>
    <td><table class="table table-bordered">
        <thead>
          <tr>
            <th>Id Cicilan</th>
            <th>Tanggal</th>
            <th style="text-align:right;">Jumlah Cicilan</th>
          </tr>
        </thead>
        <tbody>
          @foreach($items->pembelian->cicilan as $dcicilan)
          <tr>
            <td>{{ $dcicilan->idcbeli }}</td>
            <td>{{ $dcicilan->tanggal }}</td>
            <td style="text-align:right;">Rp {{ number_format($dcicilan->jumlah,0) }}</td>
          </tr>
          @endforeach
        </tbody>
    </table></td>
  </tr>
  <tr>
    <td >Sisa Hutang</td>
    <td>: Rp {{ number_format($items->pembelian->sisahutang(),0) }}</td>
  </tr>

  <tr>
    <td >Detail Pembelian</td>
    <td><table class="table table-bordered">
        <thead>
          <tr>
            <th>Barang</th>
            <th>Jumlah</th>
            <th style="text-align:right;">Harga</th>
            <th style="text-align:right;">Sub Total</th>
          </tr>
        </thead>
        <tbody>
          @foreach($items->pembelian->dpembelian as $dpembelian)
          <tr>
            <td>{{ $dpembelian->barang->nama }}</td>
            <td>{{ $dpembelian->jumlah }}</td>
             <td style="text-align:right;">Rp {{ number_format($dpembelian->harga,0) }}</td>
             <td style="text-align:right;">Rp {{ number_format($dpembelian->jumlah*$dpembelian->harga,0) }}</td>
          </tr>
          @endforeach
        </tbody>
    </table></td>
  </tr>
</table>
<a href="/cicilan_pembelian" class="btn btn-danger">Back</a>
</div>

@endsection

@section('script')
@endsection