<?php

namespace App\Http\Controllers;


use Auth;
use App\pelanggan;
use App\barang;
use App\returjual;
use App\penjualan;
use App\pengeluaran;
use App\drjual;
use App\dpenjualan;
use App\cicilan_penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests;
use App\Http\Controllers\Controller;


class returjualcontroller extends Controller
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
                 $Items= returjual::orderBy('idrpenjualan','DESC')->paginate(5);
                 return view('returjual.index',compact('Items'))
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
                   return view('returjual.create',compact('penjualans'));
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

                 $new_returjual = new returjual();
                 $new_returjual->tanggal = $request->tanggal;
                 
                 $new_returjual->idpenjualan = $request->idpenjualan;
            //$new_returjual->totalrpenjualan = $request->totalreturjual;
                 
                 $new_returjual->iduser = Auth::user()->id;
                 $new_returjual->save();

                  $data_idbarang=$_POST["idbarang"];
                for($i=0; $i<count($data_idbarang); $i++){
                    $idbarang = $_POST["idbarang"][$i];
                    $jumlah = $_POST["jumlah"][$i];
                    $harga = $_POST["harga"][$i];
                    $subtotal = $_POST["subtotal"][$i];
                    $iddpenjualan = $_POST["iddpenjualan"][$i];

                    $dreturjual = new drjual();
                    $dreturjual->idbarang = $idbarang;
                    $dreturjual->idrpenjualan = $new_returjual->idrpenjualan;
                    $dreturjual->jumlah = $jumlah;
                    $dreturjual->harga = $harga;
                    $dreturjual->iddpenjualan = $iddpenjualan;
                    //$dreturjual->subtotal = $subtotal;
                    $dreturjual->save();

                    //update dpenjualan
                    /*$updatedjual = dpenjualan::find($iddpenjualan);
                    $updatedjual->jumlahretur = $updatedjual->jumlahretur + $dreturjual->jumlah;
                    $updatedjual->save();*/


                    //integrasi ke stok
                    $updatestok = barang::find($idbarang);
                    $updatestok->stok = $updatestok->stok + $dreturjual->jumlah;
                    $updatestok->save();
                }


            //intergrasi ke piutang
                 $tpenjualan = penjualan::find($new_returjual->idpenjualan);
           
                $jumlahpotongpiutang = 0;
                $sisapiutang = $tpenjualan->sisapiutang();

                if($tpenjualan->sisapiutang() >= $new_returjual->totalrpenjualan()){
                    $jumlahpotongpiutang = $new_returjual->totalrpenjualan();
                }
                else{
                    $jumlahpotongpiutang = $tpenjualan->sisapiutang();
                }
                $bayartunai =  $new_returjual->totalrpenjualan() - $jumlahpotongpiutang;

                if($jumlahpotongpiutang > 0){

                   $new_cicilan_penjualan = new cicilan_penjualan();
                   $new_cicilan_penjualan->tanggal = $request->tanggal;
                   $new_cicilan_penjualan->idpenjualan =  $request->idpenjualan;
                   $new_cicilan_penjualan->jumlah = $jumlahpotongpiutang;
                   $new_cicilan_penjualan->tipe = "retur";
                   $new_cicilan_penjualan->iduser = Auth::user()->id;
                   $new_cicilan_penjualan->save();
                }
                if($bayartunai > 0){

                   $new_pengeluaran = new pengeluaran();
                   $new_pengeluaran->tanggal = $request->tanggal;
                   $new_pengeluaran->jumlahpengeluaran = $bayartunai;
                   $new_pengeluaran->keterangan = "ganti uang retur penjualan atas penjualan id ".$tpenjualan->idpenjualan." customer ".$tpenjualan->pelanggan->nama;
                   $new_pengeluaran->iduser = Auth::user()->id;
                   $new_pengeluaran->save();


                 $new_returjual->idpengeluaran =  $new_pengeluaran->idpengeluaran;
                 $new_returjual->save();
                }

                if($tpenjualan->sisapiutang() <= 0){
                    $tpenjualan->tgllunasjual = $new_returjual->tanggal;
                }
                $tpenjualan->save();
            //}

               


            return redirect()->route('returjual.index')
            ->with('success','returjual Berhasil dibuat');
        }
        else  {

            return redirect('/home');
        }


        
    }

    public function ajax($id){
          
        $s = "";
        $dpenjualans = dpenjualan::where("idpenjualan","=",$id)->get();
        $n = 0;
        foreach($dpenjualans as $dpenjualan){
            $brg = barang::find($dpenjualan->idbarang);

            $maxretur = $dpenjualan->jumlah - $dpenjualan->jumlahretur();
            if($brg->stok < $maxretur){
                $maxretur = $brg->stok;
            }

            $s = $s.'<tr id="baris_'.$n.'">';
            $s = $s.'<td><input type="text" readonly id="idbarang_'.$n.'" name="idbarang[]" class="form-control" value="'.$dpenjualan->idbarang.'"><input type="hidden" readonly id="iddpenjualan_'.$n.'" name="iddpenjualan[]" class="form-control" value="'.$dpenjualan->iddpenjualan.'"></td>';
            $s = $s.'<td><input type="text" readonly id="namabarang_'.$n.'" name="namabarang[]" class="form-control" value="'.$brg->nama.'"></td>';
            $s = $s.'<td><input type="text" readonly id="stokbarang_'.$n.'" name="stoknarang[]" class="form-control" value="'.$brg->stok.'"></td>';
            $s = $s.'<td><input type="text" readonly id="jumlahjual_'.$n.'" name="jumlahjual[]" class="form-control" value="'.($dpenjualan->jumlah - $dpenjualan->jumlahretur()).'"></td>';
            $s = $s.'<td><input type="number" onchange="editBarang('.$n.')"  id="jumlah_'.$n.'" name="jumlah[]" min="1" max="'.$maxretur.'" class="form-control" value="0"></td>';
            $s = $s.'<td><input type="text" readonly id="harga_'.$n.'" name="harga[]" class="form-control" value="'.$dpenjualan->harga.'">';
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
                else if ((Auth::user()->role==3 && Auth::user()->aktif==1) or (Auth::user()->role==2 && Auth::user()->aktif==1) ) 
                { //kene
                 $items=returjual::all();
                 $task = returjual::findOrFail($id);

                 
                 return view('returjual.edit',compact('items'))->withTask($task);
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



                   $update = returjual::find($id);
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



               return redirect()->route('returjual.index')
               ->with('success','returjual Berhasil di edit');
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
                  $dihapus = returjual::find($id);
                  if($dihapus->gambar != "")
                  {
                    Storage::delete($dihapus->gambar); 
                    

                }
                returjual::destroy($id);
                return redirect()->route('returjual.index')
                ->with('success','returjual Berhasil di delete');
            }
            else  {

                return redirect('/home');
            }

            
        }



        public function detail($id)
        {
            //

         $items = returjual::findOrFail($id);
         $details = drjual::whereraw("idrpenjualan = '$id'")->get();

         
         return view('returjual.detail',compact('items','details'));
     }
 }
