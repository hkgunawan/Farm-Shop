<?php

namespace App\Http\Controllers;

use Auth;
use App\cicilan_penjualan;
use App\penjualan;
use App\pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests;
use App\Http\Controllers\Controller;


class cicilan_penjualancontroller extends Controller
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


                    $Items= cicilan_penjualan::orderBy('idcjual','DESC')->paginate(5);
                return view('cicilan_penjualan.index',compact('Items'))
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


                $penjualans = penjualan::all();
                return view('cicilan_penjualan.create',compact('penjualans'));
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
                'idpenjualan' => 'required',
                'tanggal' => 'required',

            ]);
               $new_cicilan_penjualan = new cicilan_penjualan();
               $new_cicilan_penjualan->tanggal = $request->tanggal;
               $new_cicilan_penjualan->jumlah = $request->jumlah;
               $new_cicilan_penjualan->tipe = $request->tipe;
               $new_cicilan_penjualan->iduser = Auth::user()->id;
               $new_cicilan_penjualan->save();

           //kurangi penjualan



            return redirect()->route('cicilan_penjualan.index')
            ->with('success','cicilan_penjualan Berhasil dibuat');
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
               $items=cicilan_penjualan::all();
               $task = cicilan_penjualan::findOrFail($id);


               return view('cicilan_penjualan.edit',compact('items'))->withTask($task);
               return view('cicilan_penjualan.edit');
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



                $update = cicilan_penjualan::find($id);
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



             return redirect()->route('cicilan_penjualan.index')
             ->with('success','cicilan_penjualan Berhasil di edit');
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
                $dihapus = cicilan_penjualan::find($id);
                if($dihapus->gambar != "")
                {
                    Storage::delete($dihapus->gambar); 


                }
                cicilan_penjualan::destroy($id);
                return redirect()->route('cicilan_penjualan.index')
                ->with('success','cicilan_penjualan Berhasil di delete');
            }
            else  {

                return redirect('/home');
            }
            
        }


        public function detail($id)
        {
            //

         $items = cicilan_penjualan::findOrFail($id);


         return view('cicilan_penjualan.detail',compact('items'));
     }
 }
