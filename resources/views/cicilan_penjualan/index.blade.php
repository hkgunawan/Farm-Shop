@extends('layouts.app')

@section('content')

<div class="container mtb">
 <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>cicilan_penjualan</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('cicilan_penjualan.create') }}"> Create cicilan_penjualan</a>
            </div>
        </div>
    </div>


<div class="table-responsive">
    <table class="table">
        <tr>


            <th>idcjual</th>
             <th >tanggal</th>
<th>idpenjualan</th>
                  <th>pelanggan</th>
            <th >total</th>
            <th >tipe</th>
          <th >user</th>
                <th >detail</th>
        </tr>
    @foreach ($Items as $product)
    <tr>

          <th>{{ $product->idcjual}}</th>
     <td>{{ $product->tanggal}}</td>
           <td>{{ $product->idpenjualan}}</td>
   
        <td>{{ $product->penjualan->pelanggan->nama}}</td>

        <td align="right">Rp. {{ number_format($product->jumlah,0) }}</td>
           <td>{{ $product->tipe}}</td>
       
 <th >{{ $product->user->name}}</th>
        <td>
           
            <a class="btn btn-primary" href="cicilan_penjualan/detail/{{$product->idcjual }}">Detail</a>

          
        </td>
    </tr>
    @endforeach
    </table>
    </div>
    {!! $Items->render() !!}
</div>


@endsection