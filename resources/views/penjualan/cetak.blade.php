<h3>Nota Penjualan</h3>
<table border="0">
  <tr>
    <td width="100">Kd. Transaksi</td>
    <td>: {{ $items->idpenjualan }}</td>
  </tr>
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
<table width="500" border="1" cellspacing="0" cellpadding="5">
  <tr>
    <th>Barang</th>
    <th>Qty</th>
    <th>Harga</th>
    <th>Potongan</th>
    <th>Subtotal</th>
  </tr>
        @php $total= 0 @endphp
    @foreach ($details as $product)

        @php $total += $product->subtotal @endphp
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
      <th align="right">Rp {{ number_format($total,0) }}</th>
    </tr>
</table>
<script>
  window.print();
  document.location.href='/penjualan/';
</script>