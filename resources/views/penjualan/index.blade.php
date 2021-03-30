@extends('layouts.app')

@section('content')

<div class="container mtb">
 <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>penjualan</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('penjualan.create') }}"> Create penjualan</a>
            </div>
        </div>
    </div>

<div class="table-responsive">
    <table class="table">
        <tr>
            <th >idpenjualan</th>
               <th >tanggal</th>
               

            <th>pelanggan</th>
        
            <th >tipepenjualan</th>
            <th >totalpenjualan</th>
            <th >tgllunasjual</th>
            <th >sisapiutang</th>
            <th >user</th>
            <th>detail</th>
            <th >cetak</th>

        </tr>
    @foreach ($Items as $product)
    <tr>
          <td>{{ $product->idpenjualan}}</td>
    <td>{{ $product->tanggal}}</td>
   
 
        <td>
           @if($product->idpelanggan) 
           {{ $product->pelanggan->nama}}
           @else
           eceran
           @endif
        </td>
       
        <td>{{ $product->tipepenjualan}}</td>
        <td align="right"> Rp.{{number_format($product->totalpenjualan())}}</td>
        
        <td>{{ $product->tgllunasjual}}</td>
        <td align="right"> Rp.{{number_format($product->sisapiutang())}}<br>
            @if($product->sisapiutang() > 0 && !isset($product->tgllunasjual) && Auth::user()->role==3 )
<a class="btn btn-danger"  href="/penjualan/pengampunan/{{ route('cicilan_penjualan.create') }}">Pengampunan</a>
            @endif
        </td>
        <td> {{ $product->user->username}}</td>
        <td><a class="btn btn-warning" href="/penjualan/detail/{{ $product->idpenjualan }}">Detail</a></td>
        <td><a class="btn btn-primary" href="/penjualan/cetak/{{ $product->idpenjualan }}">Cetak</a></td>
    </tr>
    @endforeach
    </table>
    </div>
    {!! $Items->render() !!}
</div>


@endsection