<?php

namespace App\Http\Controllers;

use Auth;
use App\cicilan_pembelian;
use App\pembelian;
use App\suplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests;
use App\Http\Controllers\Controller;


class cicilan_pembeliancontroller extends Controller
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
             else if (Auth::user()->role==3 && Auth::user()->aktif==1)
            {
               $Items= cicilan_pembelian::orderBy('idcbeli','DESC')->paginate(5);
               return view('cicilan_pembelian.index',compact('Items'))
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
             else if (Auth::user()->role==3 && Auth::user()->aktif==1)
            {
                $pembelians = pembelian::all();
                return view('cicilan_pembelian.create',compact('pembelians'));
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
             else if (Auth::user()->role==3 && Auth::user()->aktif==1)
            { 
                $this->validate($request, [
                    'idpembelian' => 'required',
                    'tanggal' => 'required',

                ]);
                
                $new_cicilan_pembelian = new cicilan_pembelian();
                $new_cicilan_pembelian->tanggal = $request->tanggal;
                $new_cicilan_pembelian->idpembelian = $request->idpembelian;
                $new_cicilan_pembelian->jumlah = $request->jumlah;
                $new_cicilan_pembelian->iduser = Auth::user()->id;
                $new_cicilan_pembelian->save();

                
                $pembelian = pembelian::find($request->idpembelian);
                
                if($pembelian->sisahutang() <= 0){
                    $pembelian->tgllunasbeli = $request->tanggal;
                }
                $pembelian->save();



                return redirect()->route('cicilan_pembelian.index')
                ->with('success','cicilan_pembelian Berhasil dibuat');
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
             else if (Auth::user()->role==3 && Auth::user()->aktif==1)
            { 
              $items=cicilan_pembelian::all();
              $task = cicilan_pembelian::findOrFail($id);

              
              return view('cicilan_pembelian.edit',compact('items'))->withTask($task);
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
             else if (Auth::user()->role==3 && Auth::user()->aktif==1)
            {   
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



                $update = cicilan_pembelian::find($id);
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



               return redirect()->route('cicilan_pembelian.index')
               ->with('success','cicilan_pembelian Berhasil di edit');
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
             else if (Auth::user()->role==3 && Auth::user()->aktif==1)
            { 
                $dihapus = cicilan_pembelian::find($id);
                if($dihapus->gambar != "")
                {
                    Storage::delete($dihapus->gambar); 
                    

                }
                cicilan_pembelian::destroy($id);
                return redirect()->route('cicilan_pembelian.index')
                ->with('success','cicilan_pembelian Berhasil di delete');
            }
            else  {

                return redirect('/home');
            }

            
        }



        public function detail($id)
        {
            

         $items = cicilan_pembelian::findOrFail($id);

         
         return view('cicilan_pembelian.detail',compact('items'));
     }
 }
