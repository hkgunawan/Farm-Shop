@extends('layouts.app')
@section('content')
<div class=" container">
<h3>Penjualan</h3>
<table class="table">
  <tr>
    <td width="100">Tanggal</td>
    <td>: {{ $items->tanggal }}</td>
  </tr>
  <tr>
    <td>Customer</td>
    <td>:  @if($items->idpelanggan) 
           {{ $items->pelanggan->nama}}
           @else
           eceran
           @endif</td>
  </tr>
  <tr>
    <td>Tipe Penjualan</td>
    <td>: {{ $items->tipepenjualan}}</td>
  </tr>
</table>
<h4>Detail Barang</h4>
<table class="table table-bordered">
  <tr>
    <th>Barang</th>
    <th>Qty</th>
    <th>Harga</th>
    <th>Potongan</th>
    <th>Subtotal</th>
  </tr>
        @php $total= 0 @endphp
    @foreach ($details as $product)

        @php $total += $product->subtotal() @endphp
    <tr>
      <td>{{ $product->barang->nama }}</td>
      <td align="right">{{ $product->jumlah }}</td>
      <td align="right">Rp {{ number_format($product->harga,0) }}</td>
      <td align="right">Rp {{ number_format($product->potongan,0) }}</td>
      <td align="right">Rp {{ number_format($product->subtotal(),0) }}</td>
    </tr>
    @endforeach
    <tr>
      <th align="right" colspan="4">TOTAL</th>
      <td style="text-align:right;">Rp {{ number_format($total,0) }}</th>
    </tr>
  </table>


<h4>Cicilan</h4>
<table class="table table-bordered">
  <tr>
    <th>Id</th>
    <th>Tgl</th>
    <th>Total</th>
  </tr>
    @foreach ($items->cicilan as $product)

    <tr>
      <td><a href="../../cicilan_penjualan/detail/{{ $product->idcjual}}">{{ $product->idcjual }}</a></td>
      <td align="right">{{ $product->tanggal }}</td>
      <td align="right">Rp {{ number_format($product->jumlah,0) }}</td>
    </tr>
    @endforeach
  </table>

<h4>Retur</h4>
<table class="table table-bordered">
  <tr>
    <th>Id</th>
    <th>Tgl</th>
    <th>Total</th>
  </tr>
    @foreach ($items->returjual as $product)

    <tr>
      <td><a href="../../returjual/detail/{{ $product->idrpenjualan}}">{{ $product->idrpenjualan }}</a></td>
      <td align="right">{{ $product->tanggal }}</td>
      <td align="right">Rp {{ number_format($product->totalrpenjualan(),0) }}</td>
    </tr>
    @endforeach
  </table>
<a href="/penjualan" class="btn btn-danger">Back</a>
</div>

@endsection

@section('script')
@endsection