@extends('layouts.app')

@section('content')

<div class="container mtb">
 <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>pemasukan</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('pemasukan.create') }}"> Create pemasukan</a>
            </div>
        </div>
    </div>
      
<div class="table-responsive">
    <table class="table">
        <tr>
            <th>kode pemasukan</th>
        <th >tanggal</th>
            
          
            <th >total</th>
           
            <th >keterangan eceran</th>
        <th >user</th>
        </tr>
    @foreach ($Items as $product)
    <tr>
       <td>{{ $product->idpemasukan}}</td>

     <td>{{ $product->tanggal}}</td>
   
        <td align="right">Rp. {{ number_format( $product->jumlahpemasukan,0) }}</td>
      
        
        <td>    
            <p style="text-align=justify" >{!!$product->keterangan!!}</p>

        </td>
   <th >{{ $product->user->name}}</th>
   
        <td>
          <form method="POST" 
          action="{{ route('pemasukan.destroy',$product->idpemasukan) }}">
        <div class="pull-left">  
        <button class="btn btn-danger">Delete</button>
             {{ method_field('DELETE') }}
           <input type="hidden" name="_token" 
           value="{{ csrf_token() }}">
           </div>
             </form> 

           
            <a class="btn btn-primary" href="{{ route('pemasukan.edit',$product->idpemasukan) }}">Edit</a>


            <a class="btn btn-primary" href="{{ route('pemasukan.show',$product->idpemasukan) }}">Detail</a>

          
        </td>
    </tr>
    @endforeach
    </table>
    </div>
    {!! $Items->render() !!}
</div>


@endsection