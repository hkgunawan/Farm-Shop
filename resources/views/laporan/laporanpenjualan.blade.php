@extends('layouts.app')

@section('content')

<div class="container mtb">
 <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Laporan penjualan</h2>
            </div>
        </div>
    </div>

    <form action="" class="form-horizontal" method="get">
        <div class="form-group">
            <strong>Periode</strong>
            <input type="text" name="tgl_awal" id="tgl_awal" class="datepicker" value="{{ $tgl_awal }}" />
            s/d 
            <input type="text" name="tgl_akhir" id="tgl_akhir" class="datepicker" value="{{ $tgl_akhir }}" />
            <input type="submit" class="btn btn-primary" value="Cek Tanggal"/>
        </div>
    </form>
      
      @php $total = 0 @endphp
<div class="table-responsive">
    <table class="table table-border table-stripped ">
        <tr>
                  <th>tanggal</th>
            <th>kode penjualan</th>
      
           
            <th>nama pelanggan</th>
            <th>user</th>
            <th>nama barang</th>
            <th>jumlah</th>
            <th>harga</th>
            <th>potongan</th>
            <th>subtotal</th>
     
        </tr>
        @php $tgtemp = ""; @endphp
    @foreach ($laporan as $data)
        @php $subtotal = ($data->jumlah*$data->harga)-$data->potongan; @endphp
        @php $total += $subtotal @endphp
    <tr>
  

        <td>@if ($tgtemp !=  $data->tanggal) {{ $data->tanggal}} @endif</td>
        <td><a href="penjualan/detail/{{ $data->idpenjualan}}">{{ $data->idpenjualan}}</a></td>
        
       
        <td>
            @if($data->namapelanggan==null)
            eceran
            @else
            {{ $data->namapelanggan}}
            @endif
        </td>
        <th>{{ $data->namauser}}</th>
        <td>{{ $data->namabarang}}</td>
        <td>{{ $data->jumlah}}</td> 
        <td align="right">Rp. {{ number_format($data->harga,0) }}</td>
        <td align="right">Rp. {{ number_format($data->potongan,0) }}</td>
     <td align="right">Rp. {{ number_format($subtotal,0) }}</td>
   
        @php $tgtemp = $data->tanggal; @endphp
        
    </tr>
    @endforeach
        <tr>
            <th colspan="8">TOTAL</th>
        <th align="right" style="text-align: :right;">Rp. {{ number_format($total,0) }}</td>
        </tr>
    </table>
    </div>
</div>


@endsection
@section('script')


@include('partials.datepicker.javascript')

@endsection