<?php

namespace App\Http\Controllers;


use App\pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests;
use App\Http\Controllers\Controller;



class pengeluarancontroller extends Controller
{
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index(Request $request)
        {
            $Items= pengeluaran::orderBy('idpengeluaran','DESC')->paginate(5);
            return view('pengeluaran.index',compact('Items'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            //
         return view('pengeluaran.create');
     }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function store(Request $request)
        {
            
            $this->validate($request, [
                'keterangan' => 'required',
                'tanggal' => 'required',
                'jumlahpengeluaran' => 'required',
                

                
            ]);


            $new_pengeluaran = pengeluaran::create($request->all());

            //nti $new_pengeluaran e br bs km update image e


            return redirect()->route('pengeluaran.index')
            ->with('success','Kategori Berhasil dibuat');
        }

        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function show($id)
        {

           $items=pengeluaran::all();
           $task = pengeluaran::findOrFail($id);

           
           return view('pengeluaran.show',compact('items'))->withTask($task);
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function edit($id)
        {
            //lanjutkan copy yg ini + update

           $items=pengeluaran::all();
           $task = pengeluaran::findOrFail($id);

           
           return view('pengeluaran.edit',compact('items'))->withTask($task);
           return view('pengeluaran.edit');
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
            
           $this->validate($request, [
               'keterangan' => 'required',
               'tanggal' => 'required',
               'jumlahpengeluaran' => 'required',

               
           ]);



           $update = pengeluaran::find($id);
           $update->tanggal=$request->tanggal;
           $update->keterangan=$request->keterangan;
           $update->jumlahpengeluaran=$request->jumlahpengeluaran;


           $update->save(); 



           return redirect()->route('pengeluaran.index')
           ->with('success','pengeluaran Berhasil di edit');
       }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function destroy($id)
        {
            //
            $dihapus = pengeluaran::find($id);
            
            pengeluaran::destroy($id);
            return redirect()->route('pengeluaran.index')
            ->with('success','pengeluaran Berhasil di delete');
        }
    }
