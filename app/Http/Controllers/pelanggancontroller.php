<?php

    namespace App\Http\Controllers;


    use App\pelanggan;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Storage;

    use App\Http\Requests;
    use App\Http\Controllers\Controller;
use Auth;

    class pelanggancontroller extends Controller
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
            $Items= pelanggan::orderBy('nama','asc')->paginate(5);
            return view('pelanggan.index',compact('Items'))
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
           return view('pelanggan.create');
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
            $new_pelanggan = pelanggan::create($request->all());
            //nti $new_pelanggan e br bs km update image e

            return redirect()->route('pelanggan.index')
            ->with('success','pelanggan Berhasil dibuat');
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

           $items=pelanggan::all();
           $task = pelanggan::findOrFail($id);


           return view('pelanggan.edit',compact('items'))->withTask($task);
           return view('pelanggan.edit');
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



           $update = pelanggan::find($id);
           $update->nama=$request->nama;
           $update->alamat=$request->alamat;
           $update->telepon=$request->telepon;
         


         $update->save(); 



         return redirect()->route('pelanggan.index')
         ->with('success','pelanggan Berhasil di edit');
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

           if (Auth::guest())
            {

                return redirect('/home');
            }
             else if (Auth::user()->role!=1 && Auth::user()->aktif!=1) {

                return redirect('/home');
             }
            $dihapus = pelanggan::find($id);
            if($dihapus->gambar != "")
            {
                Storage::delete($dihapus->gambar); 


            }
            pelanggan::destroy($id);
            return redirect()->route('pelanggan.index')
            ->with('success','pelanggan Berhasil di delete');
        }
    }
