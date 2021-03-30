<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\pelanggan;
use App\barang;
use App\pembelian;
use App\dpembelian;
use DB;

class laporancontroller extends Controller
{
    //
    public function laporanpembelian(Request $request)
    {

        if (Auth::guest())
            {

                return redirect('/home');
            }
            else if (Auth::user()->role!=3 && Auth::user()->aktif!=1) {

                return redirect('/home');
            }

            $tgl_awal = "2017-11-01";
            $tgl_akhir = "2018-02-28";
            if($request->tgl_awal){
                $tgl_awal = $request->tgl_awal;
            }
            if($request->tgl_akhir){
                $tgl_akhir = $request->tgl_akhir;
            }
            $i = 0;

            $laporan =DB::table('pembelian')
            ->leftJoin('dpembelian', 'pembelian.idpembelian', '=', 'dpembelian.idpembelian')
            ->leftJoin('suplier', 'pembelian.idsuplier', '=', 'suplier.idsuplier')
            ->leftJoin('barang', 'dpembelian.idbarang', '=', 'barang.idbarang')
            ->leftJoin('users', 'pembelian.iduser', '=', 'users.id')
            ->select('pembelian.idpembelian','pembelian.tanggal','pembelian.idsuplier','pembelian.notasupplier','suplier.nama as namasuplier', 'dpembelian.idbarang','barang.nama as namabarang','dpembelian.jumlah', 'dpembelian.harga','users.name as namauser')
            ->whereBetween('pembelian.tanggal', [$tgl_awal, $tgl_akhir])
            ->orderBy('pembelian.tanggal','asc')
            ->get();
            $i = 0;
            return view('laporan.laporanpembelian',compact('laporan','i','tgl_awal','tgl_akhir'));
        }



        public function laporanstok(Request $request)
        { 

         $Items= barang::orderBy('id_kategori','asc')->paginate(5);
         return view('laporan.laporanstok',compact('Items'))
         ->with('i', ($request->input('page', 1) - 1) * 5);
     }


     public function laporanpenjualan(Request $request)
     {

        if (Auth::guest())
            {

                return redirect('/home');
            }
            else if (Auth::user()->role!=3 && Auth::user()->aktif!=1) {

                return redirect('/home');
            }

            $tgl_awal = "2017-11-01";
            $tgl_akhir = "2018-02-28";
            if($request->tgl_awal){
                $tgl_awal = $request->tgl_awal;
            }
            if($request->tgl_akhir){
                $tgl_akhir = $request->tgl_akhir;
            }
            $laporan = DB::table('penjualan')
            ->leftJoin('dpenjualan', 'penjualan.idpenjualan', '=', 'dpenjualan.idpenjualan')
            ->leftJoin('pelanggan', 'penjualan.idpelanggan', '=', 'pelanggan.idpelanggan')
            ->leftJoin('barang', 'dpenjualan.idbarang', '=', 'barang.idbarang')
            ->leftJoin('users', 'penjualan.iduser', '=', 'users.id')
            ->select('penjualan.idpenjualan','penjualan.tanggal','penjualan.idpelanggan','pelanggan.nama as namapelanggan', 'dpenjualan.idbarang','barang.nama as namabarang','dpenjualan.jumlah', 'dpenjualan.harga','dpenjualan.potongan','users.name as namauser')
            ->whereBetween('penjualan.tanggal', [$tgl_awal, $tgl_akhir])
            ->orderBy('penjualan.tanggal','asc')
            ->get();
            $i = 0;
            return view('laporan.laporanpenjualan',compact('laporan','i','tgl_awal','tgl_akhir'));
        }

        public function laporankas(Request $request)
        {
         if (Auth::guest())
            {

                return redirect('/home');
            }
            else if ((Auth::user()->role==3 && Auth::user()->aktif==1) or (Auth::user()->role==2 && Auth::user()->aktif==1) ) 
                { //kene
                 $tgl_awal = "2017-11-01";
                 $tgl_akhir = "2018-02-28";
                 if($request->tgl_awal){
                    $tgl_awal = $request->tgl_awal;
                }
                if($request->tgl_akhir){
                    $tgl_akhir = $request->tgl_akhir;
                }


                $saldo_awal = 0;

                $cekawal1 = DB::select(
                    "(select sum((jumlah*harga) - potongan) as jumlah from penjualan inner join dpenjualan on penjualan.idpenjualan=dpenjualan.idpenjualan where tanggal < '$tgl_awal' and tipepenjualan='Tunai')");
                foreach($cekawal1 as $awal1){
                    if(isset($awal1->jumlah)){
                        $saldo_awal += $awal1->jumlah;
                    }
                }

                $cekawal2 = DB::select("(select sum(jumlah) as jumlah from cicilan_penjualan where tanggal < '$tgl_awal' )");
                foreach($cekawal2 as $awal2){
                    if(isset($awal2->jumlah)){
                        $saldo_awal += $awal2->jumlah;
                    }
                }


                $cekawal2 = DB::select("(select sum(jumlah*harga) as jumlah from retur_pembelian inner join drbeli on retur_pembelian.idrpembelian=drbeli.idrpembelian where tanggal < '$tgl_awal' )");
                foreach($cekawal2 as $awal2){
                    if(isset($awal2->jumlah)){
                        $saldo_awal += $awal2->jumlah;
                    }
                }


                $cekawal1 = DB::select(
                    "(select sum(jumlah*harga) as jumlah from pembelian inner join dpembelian on pembelian.idpembelian=dpembelian.idpembelian where tanggal < '$tgl_awal' and tipepembelian='Tunai')");
                foreach($cekawal1 as $awal1){
                    if(isset($awal1->jumlah)){
                        $saldo_awal -= $awal1->jumlah;
                    }
                }

                $cekawal2 = DB::select("(select sum(jumlah) as jumlah from cicilan_pembelian where tanggal < '$tgl_awal' )");
                foreach($cekawal2 as $awal2){
                    if(isset($awal2->jumlah)){
                        $saldo_awal -= $awal2->jumlah;
                    }
                }


               /* $cekawal2 = DB::select("(select sum(jumlah*harga) as jumlah from retur_penjualan inner join drjual on retur_penjualan.idrpenjualan=drjual.idrpenjualan where tanggal < '$tgl_awal' )");
                foreach($cekawal2 as $awal2){
                    if(isset($awal2->jumlah)){
                        $saldo_awal -= $awal2->jumlah;
                    }
                }*/


                $cekawal2 = DB::select("(select sum(jumlahpengeluaran) as jumlah from pengeluaran where tanggal < '$tgl_awal' )");
                foreach($cekawal2 as $awal2){
                    if(isset($awal2->jumlah)){
                        $saldo_awal -= $awal2->jumlah;
                    }
                }


                $cekawal2 = DB::select("(select sum(jumlahpemasukan) as jumlah from pemasukan where tanggal < '$tgl_awal' )");
                foreach($cekawal2 as $awal2){
                    if(isset($awal2->jumlah)){
                        $saldo_awal += $awal2->jumlah;
                    }
                }

                $laporan = DB::select(
                    "select * from
                    (

                     (select tanggal,'Penjualan' as transaksi, penjualan.idpenjualan as kodetransaksi,sum((jumlah*harga)-potongan) as masuk, 0 as keluar,users.name,case when pelanggan.nama is null then 'eceran' else pelanggan.nama end as namaorang from penjualan left join pelanggan on penjualan.idpelanggan=pelanggan.idpelanggan left join users on penjualan.iduser=users.id 
                     left join dpenjualan on penjualan.idpenjualan=dpenjualan.idpenjualan
                     where tanggal >= '$tgl_awal' and tanggal <= '$tgl_akhir' and tipepenjualan='Tunai'
                     group by penjualan.idpenjualan,tanggal,penjualan.idpenjualan,users.name,pelanggan.nama,jumlah)
                     union all
                     (select a.tanggal,'Pembayaran Piutang' as transaksi,a.idcjual as kodetransaksi, a.jumlah as masuk, 0 as keluar, b.name,case when c.nama is null then 'eceran' else c.nama end as namaorang from cicilan_penjualan a inner join users b on a.iduser=b.id left join penjualan x on a.idpenjualan=x.idpenjualan left join pelanggan c on x.idpelanggan=c.idpelanggan where a.tanggal >= '$tgl_awal' and a.tanggal <= '$tgl_akhir')
                     union all
                     (select a.tanggal,'Retur Pembelian' as transaksi,a.idrpembelian as kodetransaksi, sum(d.jumlah*d.harga) as masuk, 0 as keluar, b.name,c.nama as namaorang from retur_pembelian a inner join users b on a.iduser=b.id left join pembelian x on a.idpembelian=x.idpembelian left join suplier c on x.idsuplier=c.idsuplier inner join drbeli d on a.idrpembelian=d.idrpembelian where a.tanggal >= '$tgl_awal' and a.tanggal <= '$tgl_akhir'
                     group by a.tanggal,a.idrpembelian,b.name,c.nama
                 )
                 union all
                 (select a.tanggal,'Pembelian' as transaksi,a.idpembelian as kodetransaksi, 0 as masuk, sum(d.jumlah*d.harga) as keluar, b.name,c.nama as namaorang from pembelian a inner join users b on a.iduser=b.id left join suplier c on a.idsuplier=c.idsuplier inner join dpembelian d on a.idpembelian=d.idpembelian where tanggal >= '$tgl_awal' and tanggal <= '$tgl_akhir' and tipepembelian='Tunai'
                 group by a.tanggal,a.idpembelian,b.name,c.nama
             )

             union all
             (select a.tanggal,'Pembayaran Hutang' as transaksi,a.idcbeli as kodetransaksi, 0 as masuk, a.jumlah as keluar, b.name,c.nama as namaorang from cicilan_pembelian a inner join users b on a.iduser=b.id left join pembelian x on a.idpembelian=x.idpembelian left join suplier c on x.idsuplier=c.idsuplier  where a.tanggal >= '$tgl_awal' and a.tanggal <= '$tgl_akhir')
             union all
             
         (select a.tanggal,'Pengeluaran' as transaksi,a.idpengeluaran as kodetransaksi, 0 as masuk, a.jumlahpengeluaran as keluar, b.name,'' as namaorang from pengeluaran a inner join users b on a.iduser=b.id where a.tanggal >= '$tgl_awal' and a.tanggal <= '$tgl_akhir')
         union all
         (select a.tanggal,'Pemasukan' as transaksi,a.idpemasukan as kodetransaksi, a.jumlahpemasukan as masuk, 0 as keluar, b.name, '' as namaorang from pemasukan a inner join users b on a.iduser=b.id where a.tanggal >= '$tgl_awal' and a.tanggal <= '$tgl_akhir')

     ) tmp order by tanggal desc

     "
 );


/*
(select a.tanggal,'Retur Penjualan' as transaksi,a.idrpenjualan as kodetransaksi, 0 as masuk, sum(d.jumlah*d.harga) as keluar, b.name,case when c.nama is null then 'eceran' else c.nama end as namaorang from retur_penjualan a inner join users b on a.iduser=b.id left join penjualan x on a.idpenjualan=x.idpenjualan left join pelanggan c on x.idpelanggan=c.idpelanggan inner join drjual d on a.idrpenjualan=d.idrpenjualan where a.tanggal >= '$tgl_awal' and a.tanggal <= '$tgl_akhir'
             group by a.tanggal,a.idrpenjualan,b.name,c.nama
         )
         union all
*/
                return view('laporan.laporankas',compact('laporan','tgl_awal','tgl_akhir','saldo_awal'));
            }
            else  {

                return redirect('/home');
            }



        }

        public function laporanlabarugi(Request $request)
        {

            if (Auth::guest())
                {

                    return redirect('/home');
                }
                else if (Auth::user()->role!=1 && Auth::user()->aktif!=1) {

                    return redirect('/home');
                }
                $tgl_awal = "2017-11-01";
                $tgl_akhir = "2018-02-28";
                if($request->tgl_awal){
                    $tgl_awal = $request->tgl_awal;
                }
                if($request->tgl_akhir){
                    $tgl_akhir = $request->tgl_akhir;
                }
                $penjualan = 0;
                $hpp = 0;
                $pengeluaran = 0;
                $laporan1 = DB::table('penjualan')
                ->leftJoin('dpenjualan', 'penjualan.idpenjualan', '=', 'dpenjualan.idpenjualan')
                ->select('penjualan.idpenjualan','penjualan.tanggal','penjualan.idpelanggan', 'dpenjualan.idbarang','dpenjualan.jumlah', 'dpenjualan.harga','dpenjualan.hpp','dpenjualan.potongan')
                ->whereBetween('penjualan.tanggal', [$tgl_awal, $tgl_akhir])
                ->get();

                foreach($laporan1 as $data){
                    $penjualan += (($data->jumlah * $data->harga) - $data->potongan);
                    $hpp += ($data->jumlah * $data->hpp);
                }

                $laporan2 = DB::table('pengeluaran')
                ->whereBetween('pengeluaran.tanggal', [$tgl_awal, $tgl_akhir])
                ->get();

                foreach($laporan2 as $data){
                    $pengeluaran += $data->jumlahpengeluaran;
                }

                return view('laporan.laporanlabarugi',compact('penjualan','hpp','pengeluaran','tgl_awal','tgl_akhir'));
            }

            public function laporanpiutang(Request $request)
            {
                if (Auth::guest())
                    {

                        return redirect('/home');
                    }
                    else if (Auth::user()->role!=1 && Auth::user()->aktif!=1) {

                        return redirect('/home');
                    }
                    $tgl_awal = "2017-11-01";
                    $tgl_akhir = "2018-02-28";
                    if($request->tgl_awal){
                        $tgl_awal = $request->tgl_awal;
                    }
                    if($request->tgl_akhir){
                        $tgl_akhir = $request->tgl_akhir;
                    }
                    $saldo_awal = 0;

                    $cekawal1 = DB::select(
                        "(select sum((jumlah*harga)-potongan) as jumlah from penjualan 
                        inner join dpenjualan on penjualan.idpenjualan=dpenjualan.idpenjualan
                        where tanggal < '$tgl_awal' and tipepenjualan='Kredit')");
                    foreach($cekawal1 as $awal1){
                        if(isset($awal1->jumlah)){
                            $saldo_awal += $awal1->jumlah;
                        }
                    }

                    $cekawal2 = DB::select("(select sum(jumlah) as jumlah from cicilan_penjualan where tanggal < '$tgl_awal' )");
                    foreach($cekawal2 as $awal2){
                        if(isset($awal2->jumlah)){
                            $saldo_awal -= $awal2->jumlah;
                        }
                    }

                    $laporan = DB::select(
                        "select * from
                        (
                          (select tanggal,'Penjualan' as transaksi, penjualan.idpenjualan as nota, penjualan.idpelanggan, pelanggan.nama,penjualan.idpenjualan as kodetransaksi,sum((jumlah*harga)-potongan) as jumlah,users.name as namauser,'kredit' as tipe from penjualan left join pelanggan on penjualan.idpelanggan=pelanggan.idpelanggan left join users on penjualan.iduser=users.id 
                          left join dpenjualan on penjualan.idpenjualan=dpenjualan.idpenjualan
                          where tanggal >= '$tgl_awal' and tanggal <= '$tgl_akhir' and tipepenjualan='Kredit'
                          group by penjualan.idpenjualan,tanggal,penjualan.idpenjualan,penjualan.idpelanggan,nama,name)
                          union all
                          (select cicilan_penjualan.tanggal,'Pembayaran Piutang' as transaksi, penjualan.idpelanggan as nota, penjualan.idpelanggan, pelanggan.nama,idcjual as kodetransaksi, -1*jumlah as jumlah,users.name as namauser,cicilan_penjualan.tipe from cicilan_penjualan left join penjualan on cicilan_penjualan.idpenjualan=penjualan.idpenjualan left join pelanggan on penjualan.idpelanggan=pelanggan.idpelanggan left join users on cicilan_penjualan.iduser=users.id where cicilan_penjualan.tanggal >= '$tgl_awal' and cicilan_penjualan.tanggal <= '$tgl_akhir')
                      )tmp order by tanggal

                      "
                  );


                    return view('laporan.laporanpiutang',compact('laporan','tgl_awal','tgl_akhir','saldo_awal'));
                }

                public function laporanpiutang2	(Request $request)
                {
                    if (Auth::guest())
                        {

                            return redirect('/home');
                        }
                        else if (Auth::user()->role!=1 && Auth::user()->aktif!=1) {

                            return redirect('/home');
                        }

                        $tgl_awal = "2017-11-01";
                        $tgl_akhir = "2018-02-28";
                        if($request->tgl_awal){
                            $tgl_awal = $request->tgl_awal;
                        }
                        if($request->tgl_akhir){
                            $tgl_akhir = $request->tgl_akhir;
                        }
                        $laporan = DB::table('penjualan')
                        ->leftJoin('pelanggan', 'penjualan.idpelanggan', '=', 'pelanggan.idpelanggan')
                        ->select('penjualan.*','pelanggan.nama as namapelanggan')
                        ->where('penjualan.tipepenjualan','=','Kredit')
                        ->whereBetween('penjualan.tanggal', [$tgl_awal, $tgl_akhir])
                        ->get();
                        $i = 0;
                        return view('laporan.laporanpiutang',compact('laporan','i','tgl_awal','tgl_akhir'));
                    }

                    public function laporanhutang(Request $request)
                    {
                        if (Auth::guest())
                            {

                                return redirect('/home');
                            }
                            else if (Auth::user()->role!=1 && Auth::user()->aktif!=1) {

                                return redirect('/home');
                            }
                            $tgl_awal = "2017-11-01";
                            $tgl_akhir = "2018-02-28";
                            if($request->tgl_awal){
                                $tgl_awal = $request->tgl_awal;
                            }
                            if($request->tgl_akhir){
                                $tgl_akhir = $request->tgl_akhir;
                            }
                            $saldo_awal = 0;

                            $cekawal1 = DB::select(
                                "(select sum(jumlah*harga) as jumlah from pembelian 
                                inner join dpembelian on pembelian.idpembelian=dpembelian.idpembelian
                                where tanggal < '$tgl_awal' and tipepembelian='Kredit')");
                            foreach($cekawal1 as $awal1){
                                if(isset($awal1->jumlah)){
                                    $saldo_awal += $awal1->jumlah;
                                }
                            }

                            $cekawal2 = DB::select("(select sum(jumlah) as jumlah from cicilan_pembelian where tanggal < '$tgl_awal' )");
                            foreach($cekawal2 as $awal2){
                                if(isset($awal2->jumlah)){
                                    $saldo_awal -= $awal2->jumlah;
                                }
                            }

                            $laporan = DB::select(
                                "select * from
                                (
                                 (select tanggal,'Pembelian' as transaksi, pembelian.notasupplier as nota, pembelian.idsuplier, suplier.nama,pembelian.idpembelian as kodetransaksi,sum(jumlah*harga) as jumlah,users.name as namauser from pembelian left join suplier on pembelian.idsuplier=suplier.idsuplier left join users on pembelian.iduser=users.id 
                                 left join dpembelian on pembelian.idpembelian=dpembelian.idpembelian
                                 where tanggal >= '$tgl_awal' and tanggal <= '$tgl_akhir' and tipepembelian='Kredit'
                                 group by pembelian.idpembelian,tanggal,notasupplier,idsuplier,nama,name)
                                 union all
                                 (select cicilan_pembelian.tanggal,'Pembayaran Hutang' as transaksi, pembelian.notasupplier as nota, pembelian.idsuplier, suplier.nama,idcbeli as kodetransaksi, -1*jumlah as jumlah,users.name as namauser from cicilan_pembelian left join pembelian on cicilan_pembelian.idpembelian=pembelian.idpembelian left join suplier on pembelian.idsuplier=suplier.idsuplier left join users on cicilan_pembelian.iduser=users.id where cicilan_pembelian.tanggal >= '$tgl_awal' and cicilan_pembelian.tanggal <= '$tgl_akhir')
                             ) tmp order by tanggal

                             "
                         );


                            return view('laporan.laporanhutang',compact('laporan','tgl_awal','tgl_akhir','saldo_awal'));
                        }

                        public function laporanhutang2(Request $request)
                        {
                            if (Auth::guest())
                                {

                                    return redirect('/home');
                                }
                                else if (Auth::user()->role!=1 && Auth::user()->aktif!=1) {

                                    return redirect('/home');
                                }
                                $tgl_awal = "2017-11-01";
                                $tgl_akhir = "2018-02-28";
                                if($request->tgl_awal){
                                    $tgl_awal = $request->tgl_awal;
                                }
                                if($request->tgl_akhir){
                                    $tgl_akhir = $request->tgl_akhir;
                                }
                                $laporan = DB::table('pembelian')
                                ->leftJoin('suplier', 'pembelian.idsuplier', '=', 'suplier.idsuplier')
                                ->select('pembelian.*','suplier.nama as namasuplier')
                                ->where('pembelian.tipepembelian','=','Kredit')
                                ->whereBetween('pembelian.tanggal', [$tgl_awal, $tgl_akhir])
                                ->get();
                                $i = 0;
                                return view('laporan.laporanhutang',compact('laporan','i','tgl_awal','tgl_akhir'));
                            }

                        }
