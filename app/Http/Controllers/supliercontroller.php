<?php

namespace App\Http\Controllers;

use auth;
use App\suplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests;
use App\Http\Controllers\Controller;


class supliercontroller extends Controller
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
             else if (Auth::user()->role!=1 && Auth::user()->aktif!=1) {

                return redirect('/home');
             }
            $Items= suplier::orderBy('nama','ASC')->paginate(5);
            return view('suplier.index',compact('Items'))
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

           if (Auth::guest())
            {

                return redirect('/home');
            }
             else if (Auth::user()->role!=1 && Auth::user()->aktif!=1) {

                return redirect('/home');
             }
         return view('suplier.create');
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
             else if (Auth::user()->role!=1 && Auth::user()->aktif!=1) {

                return redirect('/home');
             }
            $this->validate($request, [
                'nama' => 'required',

            ]);
            $new_suplier = suplier::create($request->all());
            //nti $new_suplier e br bs km update image e


            return redirect()->route('suplier.index')
            ->with('success','suplier Berhasil dibuat');
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
             else if (Auth::user()->role!=1 && Auth::user()->aktif!=1) {

                return redirect('/home');
             }

           $items=suplier::all();
           $task = suplier::findOrFail($id);


           return view('suplier.edit',compact('items'))->withTask($task);
           return view('suplier.edit');
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
             else if (Auth::user()->role!=1 && Auth::user()->aktif!=1) {

                return redirect('/home');
             }

           $this->validate($request, [
            'nama' => 'required',


            ]);



           $update = suplier::find($id);
           $update->nama=$request->nama;
           $update->keterangan=$request->keterangan;
           $update->alamat=$request->alamat;
           $update->telepon=$request->telepon;
         


         $update->save(); 



         return redirect()->route('suplier.index')
         ->with('success','suplier Berhasil di edit');
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
             else if (Auth::user()->role!=1 && Auth::user()->aktif!=1) {

                return redirect('/home');
             }
            $dihapus = suplier::find($id);
            if($dihapus->gambar != "")
            {
                Storage::delete($dihapus->gambar); 


            }
            suplier::destroy($id);
            return redirect()->route('suplier.index')
            ->with('success','suplier Berhasil di delete');
        }
    }
