@extends('layouts.app')

@section('content')

<div class="container mtb">
 <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Laporan kas</h2>
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
      
        @php $tgtemp = ""; @endphp
      @php $i=0; @endphp
      @php $saldo = $saldo_awal @endphp
      @php $totalmasuk = 0; $totalkeluar = 0; @endphp
<div class="table-responsive">
    <table class="table table-border table-stripped ">
        <tr>
             <th>tanggal</th>
           
            <th>transaksi</th>
            <th>kode transaksi</th>
           
            <th>pelanggan/supplier</th>
             <th>user</th>
            <th>kas masuk</th>
            <th>kas keluar</th>
            <th>saldo</th>
            
        </tr>
        <tr>
            <th colspan="7">Saldo Awal</th>
  <td  align="right">Rp. {{ number_format($saldo,0,",",".") }}</th>
        </tr>
    @foreach ($laporan as $data)
        @php $saldo += $data->masuk; $saldo -= $data->keluar; @endphp
        @php $totalmasuk += $data->masuk; $totalkeluar += $data->keluar; @endphp
    <tr>
  
    <td>@if ($tgtemp !=  $data->tanggal) {{ $data->tanggal}} @endif</td>
    
        <td>{{ $data->transaksi}}</td>
        <td>
            @if ($data->transaksi == "Pembelian")
             <a href="pembelian/detail/{{ $data->kodetransaksi}}">{{ $data->kodetransaksi}}</a>
            @elseif  ($data->transaksi == "Pembayaran Hutang")
             <a href="cicilan_pembelian/detail/{{ $data->kodetransaksi}}">{{ $data->kodetransaksi}}</a>
            @elseif  ($data->transaksi == "Retur Pembelian")
             <a href="returbeli/detail/{{ $data->kodetransaksi}}">{{ $data->kodetransaksi}}</a>
            @elseif ($data->transaksi == "Penjualan")
             <a href="penjualan/detail/{{ $data->kodetransaksi}}">{{ $data->kodetransaksi}}</a>
            @elseif  ($data->transaksi == "Pembayaran Piutang")
             <a href="cicilan_penjualan/detail/{{ $data->kodetransaksi}}">{{ $data->kodetransaksi}}</a>
            @elseif  ($data->transaksi == "Retur Penjualan")
             <a href="returjual/detail/{{ $data->kodetransaksi}}">{{ $data->kodetransaksi}}</a>
            @elseif  ($data->transaksi == "Pengeluaran")
             <a href="{{ route('pengeluaran.show',$data->kodetransaksi) }}">{{ $data->kodetransaksi}}</a>
            @elseif  ($data->transaksi == "Pemasukan")
             <a href="{{ route('pemasukan.show',$data->kodetransaksi) }}">{{ $data->kodetransaksi}}</a>
            @endif
        </td>
         <td>{{$data->namaorang}}</td>
        <td>{{$data->name}}</td>
       
         <td  align="right">@if ($data->masuk != 0) 
               Rp. {{ number_format($data->masuk,0,",",".") }}
            @else
                -
        @endif</td>
         <td  align="right">@if ($data->keluar != 0) 
                Rp.{{ number_format($data->keluar,0,",",".") }}
            @else
                -
        @endif</td>
         <td  align="right">Rp. {{ number_format($saldo,0,",",".") }}</th>
        
        @php $tgtemp = $data->tanggal; @endphp
        
    </tr>
    @endforeach
    <tr>
            <th colspan="6">Total</th>
             <td  align="right">Rp. {{ number_format($totalmasuk,0,",",".") }}</th>
             <td  align="right">Rp. {{ number_format($totalkeluar,0,",",".") }}</th>
          
        </tr>
        <tr>
            <th colspan="7">Saldo Akhir</th>
             <td  align="right">Rp. {{ number_format($saldo,0,",",".") }}</th>
        </tr>
        
    </table>
    </div>
</div>


@endsection
@section('script')


@include('partials.datepicker.javascript')

@endsection