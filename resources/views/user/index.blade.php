@extends('layouts.app')

@section('content')

<div class="container mtb">
 <div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>user</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('user.create') }}"> Create user</a>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table class="table">
        <tr>
          
            <th>nama</th>

            <th >alamat</th>
            <th >telepon</th>
            <th >Role</th>
            <th >Aktif</th>
            <th ></th>

        </tr>
        @foreach ($Items as $product)
        <tr>
           
            <td>{{ $product->name}}</td>
            <td>{{ $product->alamat}}</td>
            <td>{{ $product->telepon}}</td>
            <td>
                @if ($product->role==1)
                Admin
                @elseif($product->role==2)
                Karyawan
                @else
                Owner
                @endif
            </td>
            <td>
                @if ($product->aktif==1)
                Aktif
                @else
                Tidak Aktif
                @endif
            </td>

            <td>
                @if ($product->aktif==1)
              <form method="POST" 
              action="{{ route('user.destroy',$product->id) }}">
              <div class="pull-left">  
                <button class="btn btn-danger">nonaktif</button>
                {{ method_field('DELETE') }}
                <input type="hidden" name="_token" 
                value="{{ csrf_token() }}">
            </div>
        </form> 


        <a class="btn btn-primary" href="{{ route('user.edit',$product->id) }}">Edit</a>
                @else

             
        <a class="btn btn-danger" href="user/reaktif/{{$product->id}}">reaktif</a>
                @endif


    </td>
</tr>
@endforeach
</table>
</div>
{!! $Items->render() !!}
</div>


@endsection