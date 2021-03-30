<?php

namespace App\Http\Controllers;

use App\kategori;
use Illuminate\Http\Request;
use Auth;

class kategoricontroller extends Controller
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
            $Items= kategori::orderBy('nama_kategori','asc')->paginate(5);
            return view('kategori.index',compact('Items'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
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
             else if (Auth::user()->role!=1 && Auth::user()->aktif!=1) {

                return redirect('/home');
             }
           return view('kategori.create');
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
                'nama_kategori' => 'required',

                
            ]);
           $new_kategori = kategori::create($request->all());




            return redirect()->route('kategori.index')
            ->with('success','kategori Berhasil dibuat');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //


           if (Auth::guest())
            {

                return redirect('/home');
            }
             else if (Auth::user()->role!=1 && Auth::user()->aktif!=1) {

                return redirect('/home');
             }
           $items=kategori::all();
         $task = kategori::findOrFail($id);

 
         return view('kategori.edit',compact('items'))->withTask($task);
            return view('kategori.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\kategori  $kategori
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
                'nama_kategori' => 'required',
            ]);



$update = kategori::find($id);
  $update->nama_kategori=$request->nama_kategori;

  

$update->save(); 



      return redirect()->route('kategori.index')
                        ->with('success','kategori Berhasil di edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\kategori  $kategori
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
        $dihapus = kategori::find($id);
            
            kategori::destroy($id);
            return redirect()->route('kategori.index')
                        ->with('success','kategori Berhasil di delete');
    }
}
