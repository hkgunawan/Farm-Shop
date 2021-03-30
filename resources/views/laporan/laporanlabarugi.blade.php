@extends('layouts.app')

@section('content')

<div class="container mtb">
 <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Laporan laba rugi</h2>
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
      @php $laba_penjualan = $penjualan - $hpp @endphp
      @php $laba = $laba_penjualan - $pengeluaran @endphp
<div class="table-responsive">
    <table class="table table-border table-stripped ">
        <tr>
            <th>Penjualan</th>
             <td  align="right">Rp. {{ number_format($penjualan,0,",",".") }}</th>
        </tr>
        <tr>
            <th>Dikurangi: Harga Pokok Penjualan</th>
         <td  align="right">Rp. {{ number_format($hpp,0,",",".") }}</th>
        </tr>
        <tr>
            <th>Laba Penjualan</th>
             <td  align="right">Rp. {{ number_format($laba_penjualan,0,",",".") }}</th>
        </tr>
        <tr>
            <th></th>
            <td></td>
        </tr>
        <tr>
            <th>Pengeluaran</th>
              <td  align="right">Rp. {{ number_format($pengeluaran,0,",",".") }}</th>
        </tr>
        <tr>
            <th></th>
             <td  align="right">-------------------- -</td>
        </tr>
        <tr>
            <th>Laba</th>
           <td  align="right">Rp. {{ number_format($laba,0,",",".") }}</th>
        </tr>
    </table>
    </div>
</div>


@endsection
@section('script')


@include('partials.datepicker.javascript')

@endsection