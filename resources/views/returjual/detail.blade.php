@extends('layouts.app')
@section('content')
<div class=" container">
<h3>Retur Penjualan</h3>
<table class="table">
  <tr>
    <td width="100">Tanggal</td>
    <td>: {{ $items->tanggal }}</td>
  </tr>
  <tr>
    <td>Customer</td>
    <td>:  @if($items->penjualan->idpelanggan) 
           {{ $items->penjualan->pelanggan->nama}}
           @else
           eceran
           @endif</td>
  </tr>
  <tr>
    <td>Kode Penjualan</td>
    <td>: {{ $items->idpenjualan }}</td>
  </tr>
  <tr>
      <td>Kode Pengeluaran</td>
     <td >@if($items->idpengeluaran==null)
                -
            @else
                <a href="{{ route('pengeluaran.show',$items->idpengeluaran) }}">{{ $items->idpengeluaran}}</a>
            @endif
          </td>
  </tr>
</table>
<h4>Detail Barang</h4>
<table class="table table-bordered">
  <tr>
    <th>Barang</th>
    <th>Qty</th>
    <th>Harga</th>
    <th>Subtotal</th>
  </tr>
        @php $total= 0 @endphp
    @foreach ($details as $product)

        @php $total += $product->subtotal() @endphp
    <tr>
      <td>{{ $product->barang->nama }}</td>
      <td align="right">{{ $product->jumlah }}</td>
      <td align="right">Rp {{ number_format($product->harga,0) }}</td>
      <td align="right">Rp {{ number_format($product->subtotal(),0) }}</td>
    </tr>
    @endforeach
    <tr>
      <th align="right" colspan="3">TOTAL</th>
      <th align="right" style="text-align:right;">Rp {{ number_format($total,0) }}</th>
    </tr>
  </table>
<a href="/penjualan" class="btn btn-danger">Back</a>
</div>

@endsection

@section('script')
@endsection