@extends('layouts.app')

@section('content')

<div class="container mtb">
 <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Laporan piutang</h2>
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
      @php $i = 0 @endphp
      @php $saldo = $saldo_awal @endphp
<div class="table-responsive">
    <table class="table table-border table-stripped ">

        <tr>
       
            <th>tanggal</th>
            <th>keterangan </th>
            <th>pelanggan </th>
            <th>user </th>
            <th>jumlah</th>
            <th>tipe </th>
            <th>saldo</th>
        </tr>
        <tr>
            <th colspan="6">Saldo Awal</th>
            <td  align="right">Rp. {{ number_format($saldo_awal,0,",",".") }}</th>
        </tr>
        @php $tgtemp = ""; @endphp
    @foreach ($laporan as $data)
        @php $saldo += $data->jumlah @endphp
    <tr>
  


        <td>@if ($tgtemp !=  $data->tanggal) {{ $data->tanggal}} @endif</td>
        <td>
            @if ($data->transaksi == "Penjualan")
                 <a href="penjualan/detail/{{ $data->kodetransaksi }}">nota {{ $data->nota }}</a>
            @else
                 <a href="cicilan_penjualan/detail/{{ $data->kodetransaksi }}">nota {{ $data->nota }}</a>
            @endif
        </td>
        <td>{{ $data->nama}}</td>
        <td>{{ $data->namauser}} </td>
         <td  align="right">Rp. {{ number_format($data->jumlah,0,",",".")}}</td>
        <td>{{ $data->tipe}} </td>
         <td  align="right">Rp. {{ number_format($saldo,0,",",".")}}</td>
   
        
        @php $tgtemp = $data->tanggal; @endphp
    </tr>
    @endforeach
        <tr>
            <th colspan="6">Saldo Akhir</th>
            <th  align="right" style="text-align:right;">Rp. {{ number_format($saldo,0,",",".") }}</th>
        </tr>
    </table>
    </div>
</div>


@endsection
@section('script')


@include('partials.datepicker.javascript')

@endsection