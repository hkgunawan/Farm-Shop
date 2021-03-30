@extends('layouts.app')

@section('content')

<div class="container mtb">
 <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>cicilan_pembelian</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('cicilan_pembelian.create') }}"> Create cicilan_pembelian</a>
            </div>
        </div>
    </div>


<div class="table-responsive">
    <table class="table">
        <tr>
             <th>idcicilan</th>
              <th >tanggal</th>
           
            <th>nota supllier</th>
            <th>suplier</th>
            <th style="text-align:right;">total</th>
            <th>user</th>
        
                <th >detail</th>
        </tr>
    @foreach ($Items as $product)
    <tr>
        <th>{{$product->idcbeli}}</th>
               <td>{{ $product->tanggal}}</td>
         
        <td>{{ $product->pembelian->notasupplier}}</td>
        <td>{{ $product->pembelian->suplier->nama}}</td>
         <td align="right">Rp. {{ number_format($product->jumlah,0) }}</td>
          <th>{{ $product->user->name}}</th>
    


        <td>
           
            <a class="btn btn-primary" href="cicilan_pembelian/detail/{{$product->idcbeli }}">Detail</a>

          
        </td>
    </tr>
    @endforeach
    </table>
    </div>
    {!! $Items->render() !!}
</div>


@endsection