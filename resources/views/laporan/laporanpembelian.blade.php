@extends('layouts.app')

@section('content')

<div class="container mtb">
 <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Laporan pembelian</h2>
            </div>
        </div>
    </div>

    <form action="" class="form-horizontal" method="get">
        <div class="form-group">
            <strong>Periode</strong>
            <input type="text" name="tgl_awal" id="tgl_awal" class="datepicker" value="{{ $tgl_awal }}" />
            s/d 
            <input type="text" name="tgl_akhir" id="tgl_akhir" class="datepicker" value="{{ $tgl_akhir }}" />
            <input type="submit" class="btn btn-primary" value="Cek Tanggal"/>
        </div>
    </form>
      
        @php $tgtemp = ""; @endphp
      @php $total = 0 @endphp
<div class="table-responsive">
    <table class="table table-border table-stripped ">
        <tr>
            <th>tanggal</th>
            <th>kode pembelian</th>
            
            
            <th>nama supplier</th>
                <th>user</th>
           
            <th>nama barang</th>
            <th>jumlah</th>
            <th>harga</th>
            <th>subtotal</th>
     
        </tr>
        @php $tgtemp = ""; @endphp
    @foreach ($laporan as $data)
        @php $total += ($data->jumlah*$data->harga) @endphp
    <tr>

         <td>@if ($tgtemp !=  $data->tanggal) {{ $data->tanggal}} @endif</td>
        <td><a href="pembelian/detail/{{ $data->idpembelian}}">{{ $data->idpembelian}} {{ $data->notasupplier}}</a></td>
       
        
        <td>{{ $data->namasuplier}}</td>
            <th>{{$data->namauser}}</th>
        <td>{{ $data->namabarang}}</td>
        <td>{{ $data->jumlah}}</td>
         <td align="right">Rp. {{ number_format($data->harga,0) }}</td>
         <td align="right">Rp. {{ number_format($data->jumlah*$data->harga,0) }}</td>
    
        @php $tgtemp = $data->tanggal; @endphp
        
    </tr>
    @endforeach
        <tr>
            <th colspan="7">TOTAL</th>
          <th style="text-align:right;"align="right">Rp. {{ number_format($total,0) }}</th>
        </tr>
    </table>
    </div>
</div>


@endsection
@section('script')


@include('partials.datepicker.javascript')

@endsection