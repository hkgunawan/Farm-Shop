<?php

namespace App\Http\Controllers;


use Auth;
use App\pelanggan;
use App\barang;
use App\penjualan;
use App\dpenjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests;
use App\Http\Controllers\Controller;


class penjualancontroller extends Controller
{
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index(Request $request)
        {
            if (Auth::guest())
                {

                    return redirect('/home');
                }
                else if ((Auth::user()->role==3 && Auth::user()->aktif==1) or (Auth::user()->role==2 && Auth::user()->aktif==1) ) 
                { //kene
                 $Items= penjualan::orderBy('idpenjualan','DESC')->paginate(5);
                 return view('penjualan.index',compact('Items'))
                 ->with('i', ($request->input('page', 1) - 1) * 5);
             }
             else  {

                return redirect('/home');
            }

            
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            if (Auth::guest())
                {

                    return redirect('/home');
                }
                else if ((Auth::user()->role==3 && Auth::user()->aktif==1) or (Auth::user()->role==2 && Auth::user()->aktif==1) ) 
                { //kene
                   $pelanggans = pelanggan::orderBy('nama','ASC')->get();
                   $barangs = barang::orderBy('nama','ASC')->get();
                   return view('penjualan.create',compact('pelanggans','barangs'));

               }
               else  {

                return redirect('/home');
            }

            

        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function store(Request $request)
        {
         if (Auth::guest())
            {

                return redirect('/home');
            }
            else if ((Auth::user()->role==3 && Auth::user()->aktif==1) or (Auth::user()->role==2 && Auth::user()->aktif==1) ) 
                { //kene
                   $this->validate($request, [
                    'idpelanggan' => 'required',
                    'tanggal' => 'required',

                ]);
                   
                   $new_penjualan = new penjualan();
                   $new_penjualan->tanggal = $request->tanggal;
                   if($request->idpelanggan != "0"){

                    $new_penjualan->idpelanggan = $request->idpelanggan;
                }
                $new_penjualan->tipepenjualan = $request->tipepenjualan;
            //$new_penjualan->totalpenjualan = $request->totalpenjualan;
                if($request->tipepenjualan == "Tunai"){
                //$new_penjualan->sisapiutang = 0;
                    $new_penjualan->tgllunasjual = $request->tanggal;
                }
                else{
                //$new_penjualan->sisapiutang = $request->totalpenjualan;
                    $new_penjualan->jatuhtempo = $request->jatuhtempo;
                //$new_penjualan->jatuhtempo = date("Y-m-d",time()+(30*24*3600));
                }
                $new_penjualan->iduser = Auth::user()->id;
                $new_penjualan->save();

                $data_idbarang=$request->idbarang;
                for($i=0; $i<count($data_idbarang); $i++){
                    $idbarang = $request->idbarang[$i];
                    $jumlah = $request->jumlah[$i];
                    $harga = $request->harga[$i];
                    $potongan = $request->potongan[$i];
                    $subtotal = $request->subtotal[$i];


                    $updatestok = barang::find($idbarang);
                    $updatestok->stok = $updatestok->stok - $jumlah;
                    $updatestok->save();

                    $dpenjualan = new dpenjualan();
                    $dpenjualan->idbarang = $idbarang;
                    $dpenjualan->idpenjualan = $new_penjualan->idpenjualan;
                    $dpenjualan->jumlah = $jumlah;
                    $dpenjualan->harga = $harga;
                    $dpenjualan->potongan = $potongan;
                //$dpenjualan->subtotal = $subtotal;
                    $dpenjualan->hpp = $updatestok->harga_average;
                    $dpenjualan->save();


                }


                

                return redirect()->route('penjualan.index')
                ->with('success','penjualan Berhasil dibuat');
            }
            else  {

                return redirect('/home');
            }

            
        }

        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function show($id)
        {
            //
        }
        public function cetak($id)
        {
            //

         $items = penjualan::findOrFail($id);
         $details = dpenjualan::whereraw("idpenjualan = '$id'")->get();

         
         return view('penjualan.cetak',compact('items','details'));
     }
     public function detail($id)
     {
            //

         $items = penjualan::findOrFail($id);
         $details = dpenjualan::whereraw("idpenjualan = '$id'")->get();

         
         return view('penjualan.detail',compact('items','details'));
     }



     public function pengampunan($id)
     {
            //

         $items = penjualan::findOrFail($id);
         $items->tgllunasjual = date("Y-m-d");
         $items->save();

         
         return redirect()->route('penjualan.index')
         ->with('success','pengampunan berhasil diberikan');
     }
        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function edit($id)
        {
            if (Auth::guest())
                {

                    return redirect('/home');
                }
                else if ((Auth::user()->role==3 && Auth::user()->aktif==1) or (Auth::user()->role==2 && Auth::user()->aktif==1) ) 
                { //kene

                 $items=penjualan::all();
                 $task = penjualan::findOrFail($id);

                 
                 return view('penjualan.edit',compact('items'))->withTask($task);
             }
             else  {

                return redirect('/home');
            }


            
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, $id)
        {
           if (Auth::guest())
            {

                return redirect('/home');
            }
            else if ((Auth::user()->role==3 && Auth::user()->aktif==1) or (Auth::user()->role==2 && Auth::user()->aktif==1) ) 
                { //kene
                  $this->validate($request, [
                    'keterangan' => 'required',
                    'nama' => 'required',
                    'jenis' => 'required',
                    'stokmin' => 'required',
                    'harga_bon' => 'required',
                    'harga_eceran' => 'required',
                    'harga_pedagang' => 'required',
                    'stok' => 'required',

                    
                ]);



                  $update = penjualan::find($id);
                  $update->nama=$request->nama;
                  $update->keterangan=$request->keterangan;
                  $update->jenis=$request->jenis;
                  $update->stokmin=$request->stokmin;
                  $update->harga_bon=$request->harga_bon;
                  $update->harga_eceran=$request->harga_eceran;
                  $update->harga_pedagang=$request->harga_pedagang;
                  $update->stok=$request->stok;

                  if($request->file('gambar'))
                  {
                    if($update->gambar)
                    {
                       Storage::delete($update->gambar); 
                   }
                   $file = $request->file('gambar');
                   $file->move('assets/img/berita', $file->getClientOriginalName());
                   $update->gambar = 'assets/img/berita/' . $file->getClientOriginalName();
               }


               $update->save(); 



               return redirect()->route('penjualan.index')
               ->with('success','penjualan Berhasil di edit');
           }
           else  {

            return redirect('/home');
        }

        
    }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function destroy($id)
        {
          if (Auth::guest())
            {

                return redirect('/home');
            }
            else if ((Auth::user()->role==3 && Auth::user()->aktif==1) or (Auth::user()->role==2 && Auth::user()->aktif==1) ) 
                { //kene
                   $dihapus = penjualan::find($id);
                   if($dihapus->gambar != "")
                   {
                    Storage::delete($dihapus->gambar); 
                    

                }
                penjualan::destroy($id);
                return redirect()->route('penjualan.index')
                ->with('success','penjualan Berhasil di delete');
            }
            else  {

                return redirect('/home');
            }

            
        }
    }
