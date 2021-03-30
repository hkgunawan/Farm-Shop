@extends('layouts.app')

@section('content')

<div class="container mtb">
   <div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>pembelian </h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('pembelian.create') }}"> Create pembelian</a>
            </div >
        </div>
    </div>

    <div class="table-responsive">
        <table class="table">
            <tr>
                 <th>idpembelian</th>
              <th >tanggal</th>

             
                <th >Suplier</th>
                
                <th >tipepembelian</th>
                <th >totalpembelian</th>
                <th >tgllunasbeli</th>
                <th >sisapiutang</th>
            @if(Auth::user()->role==1)
                <th>User</th>
            @endif
                <th >detail</th>
            </tr>
            @foreach ($Items as $product)
            <tr>

                <td>{{ $product->idpembelian}}</td>
              <td>{{ $product->tanggal}}</td>

                <td>{{ $product->suplier->nama}}</td>
               
                <td>{{ $product->tipepembelian}}</td>
                <td align="right">Rp. {{ number_format($product->totalpembelian(),0) }}</td>
                <td>{{ $product->tgllunasbeli}}</td>
                <td align="right">Rp. {{ number_format($product->sisahutang(),0) }}</td>

            @if(Auth::user()->role==1)
                <td>{{ $product->user->username}}</td>
            @endif
                <td><a class="btn btn-warning" href="/pembelian/detail/{{ $product->idpembelian }}">Detail</a></td>

</tr>
@endforeach
</table>
</div>
{!! $Items->render() !!}
</div>


@endsection