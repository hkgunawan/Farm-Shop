<?php

namespace App\Http\Controllers;

use Auth;
use App\pelanggan;
use App\barang;
use App\returbeli;
use App\pembelian;
use App\drbeli;
use App\dpembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests;
use App\Http\Controllers\Controller;


class returbelicontroller extends Controller
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
            {  $Items= returbeli::orderBy('idrpembelian','DESC')->paginate(5);
            return view('returbeli.index',compact('Items'))
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
            { $pembelians = pembelian::all();
                return view('returbeli.create',compact('pembelians'));
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
            {   $this->validate($request, [
                'idpembelian' => 'required',
                'tanggal' => 'required',

            ]);

//jika sudah habis -> lunas
            $new_returbeli = new returbeli();
            $new_returbeli->tanggal= $request->tanggal;
            
            $new_returbeli->idpembelian = $request->idpembelian;
            //$new_returbeli->totalrpembelian = $request->totalreturbeli;
            
            $new_returbeli->iduser = Auth::user()->id;
            $new_returbeli->save();

            //intergrasi ke hutang
            $tpembelian = pembelian::find($new_returbeli->idpembelian);
            if($tpembelian->sisahutang() > 0){
                /*$tpembelian->sisahutang = $tpembelian->sisahutang - $new_returbeli->totalrpembelian;
                //potong hutang senilai retur, tapi tidak boleh minus
                if($tpembelian->sisahutang < 0){
                    $tpembelian->sisahutang = 0;
                }*/

                //jika sudah habis -> lunas
                if($tpembelian->sisahutang() <= 0){
                    $tpembelian->tgllunasbeli = $new_returbeli->tanggal;
                }
                $tpembelian->save();
            }

            $data_idbarang=$_POST["idbarang"];
            for($i=0; $i<count($data_idbarang); $i++){
                $idbarang = $_POST["idbarang"][$i];
                $jumlah = $_POST["jumlah"][$i];
                $harga = $_POST["harga"][$i];
                //$subtotal = $_POST["subtotal"][$i];

                $dreturbeli = new drbeli();
                $dreturbeli->idbarang = $idbarang;
                $dreturbeli->idrpembelian = $new_returbeli->idrpembelian;
                $dreturbeli->jumlah = $jumlah;
                $dreturbeli->harga = $harga;
                //$dreturbeli->subtotal = $subtotal;
                $dreturbeli->save();



                //integrasi ke stok
                $updatestok = barang::find($idbarang);
                $updatestok->stok = $updatestok->stok - $dreturbeli->jumlah;
                $updatestok->save();
            }


            return redirect()->route('returbeli.index')
            ->with('success','returbeli Berhasil dibuat');
        }
        else  {

            return redirect('/home');
        }



    }

    public function ajax($id){
            //berfungsi mengeluarkan detail barang dari pembelian berdasar id
        $s = "";
        $dpembelians = dpembelian::where("idpembelian","=",$id)->get();
        $n = 0;
        foreach($dpembelians as $dpembelian){
            $brg = barang::find($dpembelian->idbarang);
            $s = $s.'<tr id="baris_'.$n.'">';
            $s = $s.'<td><input type="text" readonly id="idbarang_'.$n.'" name="idbarang[]" class="form-control" value="'.$dpembelian->idbarang.'"></td>';
            $s = $s.'<td><input type="text" readonly id="namabarang_'.$n.'" name="namabarang[]" class="form-control" value="'.$brg->nama.'"></td>';
            $s = $s.'<td><input type="text" readonly id="jumlahbeli_'.$n.'" name="jumlahbeli[]" class="form-control" value="'.$dpembelian->jumlah.'"></td>';
            $s = $s.'<td><input type="number" onchange="editBarang('.$n.')"  id="jumlah_'.$n.'" name="jumlah[]" min="1" max="'.$dpembelian->jumlah.'" class="form-control" value="0"></td>';
            $s = $s.'<td><input type="text" readonly id="harga_'.$n.'" name="harga[]" class="form-control" value="'.$dpembelian->harga.'">';
            $s = $s.'</td>';
            $s = $s.'<td><input type="text" readonly id="subtotal_'.$n.'" name="subtotal[]" class="form-control" value="0"></td>';
            $s = $s.'<td><button type="button" class="btn btn-danger" onclick="deleteBarang('.$n.')" > X </button></td>';
            $n++;
        }
        $s = $s.'<input type="hidden" name="n" id="n" value="'.$n.'" />';

        echo $s;
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
                {  $items=returbeli::all();
                 $task = returbeli::findOrFail($id);


                 return view('returbeli.edit',compact('items'))->withTask($task);
                 return view('returbeli.edit');
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



            $update = returbeli::find($id);
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



           return redirect()->route('returbeli.index')
           ->with('success','returbeli Berhasil di edit');
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
            { $dihapus = returbeli::find($id);
                if($dihapus->gambar != "")
                {
                    Storage::delete($dihapus->gambar); 


                }
                returbeli::destroy($id);
                return redirect()->route('returbeli.index')
                ->with('success','returbeli Berhasil di delete');
            }
            else  {

                return redirect('/home');
            }

        }




        public function detail($id)
        {
            //

         $items = returbeli::findOrFail($id);
         $details = drbeli::whereraw("idrpembelian = '$id'")->get();


         return view('returbeli.detail',compact('items','details'));
     }
 }
