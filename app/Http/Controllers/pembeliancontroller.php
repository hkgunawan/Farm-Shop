<?php

namespace App\Http\Controllers;

use Auth;
use App\suplier;
use App\barang;
use App\pembelian;
use App\dpembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests;
use App\Http\Controllers\Controller;


class pembeliancontroller extends Controller
{
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index(Request $request)
        {   if (Auth::guest())
            {

                return redirect('/home');
            }
             else if (Auth::user()->role==3 && Auth::user()->aktif==1)
            { $Items= pembelian::orderBy('idpembelian','DESC')->paginate(5);
            return view('pembelian.index',compact('Items'))
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
                {$supliers = suplier::all();
                    $barangs = barang::orderBy('nama','ASC')->get();
                    return view('pembelian.create',compact('supliers','barangs'));
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
            {$this->validate($request, [
                'idsuplier' => 'required',
                'tanggal' => 'required',

            ]);
            $new_pembelian = new pembelian();
            $new_pembelian->tanggal = $request->tanggal;
            $new_pembelian->notasupplier = $request->notasupplier;
            if($request->idsuplier != "0"){

                $new_pembelian->idsuplier = $request->idsuplier;
            }
            $new_pembelian->tipepembelian = $request->tipepembelian;
           //$new_pembelian->totalpembelian = $request->totalpembelian;
            if($request->tipepembelian == "Tunai"){
            //$new_pembelian->sisahutang = 0;
                $new_pembelian->tgllunasbeli = $request->tanggal;
            }
            else{
            //$new_pembelian->sisahutang = $request->totalpembelian;
                $new_pembelian->jatuhtempo = date("Y-m-d",time()+(30*24*3600));
            }
            $new_pembelian->iduser = Auth::user()->id;
            $new_pembelian->save();

            $data_idbarang=$_POST["idbarang"];
            for($i=0; $i<count($data_idbarang); $i++){
                $idbarang = $_POST["idbarang"][$i];
                $jumlah = $_POST["jumlah"][$i];
                $harga = $_POST["harga"][$i];
                //$subtotal = $_POST["subtotal"][$i];

                $dpembelian = new dpembelian();
                $dpembelian->idbarang = $idbarang;
                $dpembelian->idpembelian = $new_pembelian->idpembelian;
                $dpembelian->jumlah = $jumlah;
                $dpembelian->harga = $harga;
                //$dpembelian->subtotal = $subtotal;
                $dpembelian->save();


                $updatestok = barang::find($idbarang);
                $updatestok->harga_average = ( ($updatestok->harga_average * $updatestok->stok) +  ($jumlah * $harga) ) / ($updatestok->stok + $jumlah);
                $updatestok->stok = $updatestok->stok + $dpembelian->jumlah;
                $updatestok->save();
            }


            return redirect()->route('pembelian.index')
            ->with('success','pembelian Berhasil dibuat');
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

        public function detail($id)
        {
            //

         $items = pembelian::findOrFail($id);
         $details = dpembelian::whereraw("idpembelian = '$id'")->get();

         
         return view('pembelian.detail',compact('items','details'));
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
            { $items=pembelian::all();
               $task = pembelian::findOrFail($id);

               
               return view('pembelian.edit',compact('items'))->withTask($task);
               return view('pembelian.edit');
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
            { $this->validate($request, [
                'keterangan' => 'required',
                'nama' => 'required',
                'jenis' => 'required',
                'stokmin' => 'required',
                'harga_bon' => 'required',
                'harga_eceran' => 'required',
                'harga_pedagang' => 'required',
                'stok' => 'required',

                
            ]);



            $update = pembelian::find($id);
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



         return redirect()->route('pembelian.index')
         ->with('success','pembelian Berhasil di edit');
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
            {$dihapus = pembelian::find($id);
                if($dihapus->gambar != "")
                {
                    Storage::delete($dihapus->gambar); 
                    

                }
                pembelian::destroy($id);
                return redirect()->route('pembelian.index')
                ->with('success','pembelian Berhasil di delete');
            }
            else  {

                return redirect('/home');
            }
            
        }
    }
