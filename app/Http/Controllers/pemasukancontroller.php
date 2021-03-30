<?php

namespace App\Http\Controllers;


use App\pemasukan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests;
use App\Http\Controllers\Controller;



class pemasukancontroller extends Controller
{
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index(Request $request)
        {
            $Items= pemasukan::orderBy('idpemasukan','DESC')->paginate(5);
            return view('pemasukan.index',compact('Items'))
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
           return view('pemasukan.create');
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
                'jumlahpemasukan' => 'required',
                

                
            ]);


            $new_pemasukan = pemasukan::create($request->all());

            //nti $new_pemasukan e br bs km update image e


            return redirect()->route('pemasukan.index')
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
            //

         $items=pemasukan::all();
         $task = pemasukan::findOrFail($id);

         
         return view('pemasukan.show',compact('items'))->withTask($task);
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

         $items=pemasukan::all();
         $task = pemasukan::findOrFail($id);

         
         return view('pemasukan.edit',compact('items'))->withTask($task);
         return view('pemasukan.edit');
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
             'jumlahpemasukan' => 'required',

             
         ]);



         $update = pemasukan::find($id);
         $update->tanggal=$request->tanggal;
         $update->keterangan=$request->keterangan;
         $update->jumlahpemasukan=$request->jumlahpemasukan;


         $update->save(); 



         return redirect()->route('pemasukan.index')
         ->with('success','pemasukan Berhasil di edit');
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
            $dihapus = pemasukan::find($id);
            
            pemasukan::destroy($id);
            return redirect()->route('pemasukan.index')
            ->with('success','pemasukan Berhasil di delete');
        }
    }
