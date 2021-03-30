@extends('layouts.app')

@section('content')

<div class="container mtb">
 <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>suplier</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('suplier.create') }}"> Create suplier</a>
            </div>
        </div>
    </div>
      
<div class="table-responsive">
    <table class="table">
        <tr>
            
            <th>nama</th>
            <th>alamat</th>
            <th>telepon</th>
        </tr>
    @foreach ($Items as $suplier)
    <tr>
      
        <td>{{ $suplier->nama}}</td>
        <td>{{ $suplier->alamat}}</td>
        <td>{{ $suplier->telepon}}</td>
        <td>
          <form method="POST" 
          action="{{ route('suplier.destroy',$suplier->idsuplier) }}">
        <div class="pull-left">  
        <button class="btn btn-danger">Delete</button>
             {{ method_field('DELETE') }}
           <input type="hidden" name="_token" 
           value="{{ csrf_token() }}">
           </div>
             </form> 

           
            <a class="btn btn-primary" href="{{ route('suplier.edit',$suplier->idsuplier) }}">Edit</a>


          
        </td>
    </tr>
    @endforeach
    </table>
    </div>
    {!! $Items->render() !!}
</div>


@endsection