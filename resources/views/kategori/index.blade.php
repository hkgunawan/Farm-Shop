@extends('layouts.app')

@section('content')

<div class="container mtb">
 <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>kategori</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('kategori.create') }}"> Create kategori</a>
            </div>
        </div>
    </div>
      
<div class="table-responsive">
    <table class="table">
        <tr>
       
            <th>nama</th>
          
        </tr>
    @foreach ($Items as $product)
    @php

    @endphp
    <tr>

        <td>{{ $product->nama_kategori}}</td>
        <td>
          <form method="POST" 
          action="{{ route('kategori.destroy',$product->id_kategori) }}">
        <div class="pull-left">  
        <button class="btn btn-danger">Delete</button>
             {{ method_field('DELETE') }}
           <input type="hidden" name="_token" 
           value="{{ csrf_token() }}">
           </div>
             </form> 

           
            <a class="btn btn-primary" href="{{ route('kategori.edit',$product->id_kategori) }}">Edit</a>


          
        </td>
    </tr>
    @endforeach
    </table>
    </div>
    {!! $Items->render() !!}
</div>


@endsection