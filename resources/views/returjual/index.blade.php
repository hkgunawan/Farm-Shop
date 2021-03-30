@extends('layouts.app')

@section('content')

<div class="container mtb">
 <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>returjual</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('returjual.create') }}"> Create returjual</a>
            </div>
        </div>
    </div>


<div class="table-responsive">
    <table class="table">
        <tr>
             <th >idrjual</th>
           
           <th >tanggal</th>
  <th >idpenjualan</th>
           
            <th >pelanggan</th>
           
            <th >totalrpenjualan</th>
            <th >idpengeluaran</th>
            <th >user</th>
            <th >detail</th>

        </tr>
    @foreach ($Items as $product)
    <tr>
        <td>{{ $product->idrpenjualan}}</td>
         

         <td>{{ $product->tanggal}}</td>
        
       <td>{{ $product->idpenjualan}}</td>
        <td >
            @if($product->penjualan->idpelanggan==null)
            eceran
            @else
            {{ $product->penjualan->pelanggan->nama}}
        @endif</th>
       
        <td align="right">Rp. {{ number_format( $product->totalrpenjualan(),0) }}</td>
          <th >@if($product->idpengeluaran==null)
                -
            @else
                <a href="{{ route('pengeluaran.show',$product->idpengeluaran) }}">{{ $product->idpengeluaran}}</a>
            @endif
          </th>
          <th > {{ $product->user->name}}</th>

        <td><a class="btn btn-warning" href="/returjual/detail/{{ $product->idrpenjualan }}">Detail</a></td>
    </tr>
    @endforeach
    </table>
    </div>
    {!! $Items->render() !!}
</div>


@endsection