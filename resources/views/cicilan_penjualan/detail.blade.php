@extends('layouts.app')
@section('content')
<div class=" container">
<h3>Cicilan piutang</h3>
<table class="table">
  <tr>
    <td width="300">Tanggal</td>
    <td>: {{ $items->tanggal }}</td>
  </tr>
  <tr>
    <td>pelanggan</td>
    <td>:  @if($items->penjualan->idpelanggan) 
           {{ $items->penjualan->pelanggan->nama}}
           @else
           eceran
           @endif</td>
  </tr>
  <tr>
    <td>Nota penjualan</td>
    <td>: {{ $items->penjualan->idpenjualan}}</td>
  </tr>
  <tr>
    <td>Tipe</td>
    <td>: {{ $items->tipe}}</td>
  </tr>
  <tr>
    <td >Total</td>
    <td>: Rp {{ number_format($items->jumlah) }}</td>
  </tr>
  <tr>
    <td >piutang Awal</td>
    <td>: Rp {{ number_format($items->penjualan->totalpenjualan(),0) }}</td>
  </tr>
  <tr>
    <td >Informasi Cicilan penjualan Ini</td>
    <td><table class="table table-bordered">
        <thead>
          <tr>
            <th>Id Cicilan</th>
            <th>Tanggal</th>
            <th>Tipe</th>
            <th style="text-align:right;">Jumlah Cicilan</th>
          </tr>
        </thead>
        <tbody>
          @foreach($items->penjualan->cicilan as $dcicilan)
          <tr>
            <td>{{ $dcicilan->idcjual }}</td>
            <td>{{ $dcicilan->tanggal }}</td>
            <td>{{ $dcicilan->tipe }}</td>
            <td style="text-align:right;">Rp {{ number_format($dcicilan->jumlah,0) }}</td>
          </tr>
          @endforeach
        </tbody>
    </table></td>
  </tr>
  <tr>
    <td >Sisa piutang</td>
    <td>: Rp {{ number_format($items->penjualan->sisapiutang(),0) }}</td>
  </tr>

  <tr>
    <td >Detail penjualan</td>
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
          @foreach($items->penjualan->dpenjualan as $dpenjualan)
          <tr>
            <td>{{ $dpenjualan->barang->nama }}</td>
            <td>{{ $dpenjualan->jumlah }}</td>
            <td style="text-align:right;">Rp {{ number_format($dpenjualan->harga,0) }}</td>
            <td style="text-align:right;">Rp {{ number_format($dpenjualan->subtotal(),0) }}</td>
          </tr>
          @endforeach
        </tbody>
    </table></td>
  </tr>
</table>
<a href="/cicilan_penjualan" class="btn btn-danger">Back</a>
</div>

@endsection

@section('script')
@endsection