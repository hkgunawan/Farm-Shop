@extends('layouts.app')

@section('content')

<div class="container mtb">
 <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>returbeli</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('returbeli.create') }}"> Create returbeli</a>
            </div>
        </div>
    </div>
        


<div class="table-responsive">
    <table class="table">
        <tr>
            <th >idretur</th>
           <th >tanggal</th>

            <th >nota suplier</th>
            <th >suplier</th>
           
            <th >totalrpembelian</th>
                 <th >user</th>
            <th >detail</th>

        </tr>
       
    @foreach ($Items as $product)
    <tr>
          <td>{{ $product->idrpembelian}}</td>
        <td>{{ $product->tanggal}} </td>
        
        <td>{{ $product->pembelian->notasupplier}}</td>
        <td>{{ $product->pembelian->suplier->nama}}</td>
       
         <td align="right">Rp. {{ number_format($product->totalrpembelian(),0) }}</td>
          <th >{{ $product->user->name}}</th>
    
        <td><a class="btn btn-warning" href="/returbeli/detail/{{ $product->idrpembelian }}">Detail</a></td>
    </tr>
       
    @endforeach
    </table>
    </div>
    {!! $Items->render() !!}
</div>


@endsection