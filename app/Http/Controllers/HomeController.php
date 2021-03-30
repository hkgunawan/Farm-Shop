<?php

namespace App\Http\Controllers;

use App\barang;
use App\pembelian;
use App\penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response 
     */
    public function index()
    {
        //disini buat data urk reminder
        $ReminderStok = barang::whereraw('stokmin > stok')->get();
        //transaksi 30 hari yang lalu atau sebelum itu
        $tanggal = date("Y-m-d",time()+(10*86400));

        $ReminderHutang = pembelian::whereraw("tgllunasbeli !=null and jatuhtempo <= '$tanggal'")->get();
        $ReminderPiutang = penjualan::whereraw("tgllunasjual !=null and jatuhtempo <= '$tanggal'")->get();

        return view('home',compact('ReminderStok','ReminderHutang','ReminderPiutang'));
    }
}
