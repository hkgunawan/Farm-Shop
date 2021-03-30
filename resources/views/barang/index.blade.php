@extends('layouts.app')

@section('content')

<div class="container mtb">
 <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Barang</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('barang.create') }}"> Create barang</a>
            </div>
        </div>
    </div>
      
<div class="table-responsive">
    <table class="table">
        <tr>
           
            <th>nama</th>
          
            <th >kategori</th>
            <th >hargapedagang</th>
            <th >harga eceran</th>
            <th >harga bon</th>
            <th >stok</th>
            <th >stokmin</th>
            <th ></th>
        </tr>
    @foreach ($Items as $product)
    <tr> 
       
        <td>{{ $product->nama}}</td>
        <td>{{ $product->kategori->nama_kategori}}</td>
         <td  align="right">Rp. {{ number_format($product->harga_pedagang,0,",",".") }}</th> 
         <td  align="right">Rp. {{ number_format($product->harga_eceran,0,",",".") }}</th> 
        <td  align="right">Rp. {{ number_format($product->harga_bon,0,",",".") }}</th> 
        <td>{{ $product->stok}}</td>
        <td>{{ $product->stokmin}}</td>
        <td>
          <form method="POST" 
          action="{{ route('barang.destroy',$product->idbarang) }}">
        <div class="pull-left">  
        <button class="btn btn-danger">Delete</button>
             {{ method_field('DELETE') }}
           <input type="hidden" name="_token" 
           value="{{ csrf_token() }}">
           </div>
             </form> 

           
            <a class="btn btn-primary" href="{{ route('barang.edit',$product->idbarang) }}">Edit</a>


          
        </td>
    </tr>
    @endforeach
    </table>
    </div>
    {!! $Items->render() !!}
</div>


@endsection