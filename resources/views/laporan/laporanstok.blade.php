@extends('layouts.app')

@section('content')

<div class="container mtb">
 <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Laporan Stok</h2>
            </div>
        </div>
    </div>
      
<div class="table-responsive">
    <table class="table">
        <tr>
            <th>No</th>
            <th>nama</th>
          
            <th >kategori</th>
            <th >hargapedagang</th>
            <th >harga eceran</th>
            <th >harga bon</th>
            <th >stok</th>
        </tr>
    @foreach ($Items as $product)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $product->nama}}</td>
        <td>{{ $product->kategori->nama_kategori}}</td>
        <td>{{ $product->harga_pedagang}}</td>
        <td>{{ $product->harga_eceran}}</td>
        <td>{{ $product->harga_bon}}</td>
        <td>{{ $product->stok}}</td>
    </tr>
    @endforeach
    </table>
    </div>
    {!! $Items->render() !!}
</div>


@endsection