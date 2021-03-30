<?php

    namespace App\Http\Controllers;

    use Auth;
    use App\barang;
    use App\kategori;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Storage;

    use App\Http\Requests;
    use App\Http\Controllers\Controller;


    class barangcontroller extends Controller
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
             else{

                  $Items= barang::orderBy('nama','asc')->paginate(5);
                    return view('barang.index',compact('Items'))
                    ->with('i', ($request->input('page', 1) - 1) * 5);
             }

       


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
           
             
            $Items=kategori::all();
             return view('barang.create',compact('Items'));
       
            

       
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
                'id_kategori' => 'required',
                'stokmin' => 'required',
                'harga_bon' => 'required',
                'harga_eceran' => 'required',
                'harga_average' => 'required',
                'harga_pedagang' => 'required',
                'stok' => 'required',


                
            ]);
           $new_barang = barang::create($request->all());



   if($request->file('gambar'))
   {
    $file = $request->file('gambar');
    $file->move('assets/img/barang', $new_barang->idbarang.".jpg");
    $new_barang->gambar = 'assets/img/barang/' . $new_barang->idbarang.".jpg";
     $new_barang ->save();
}
        


            return redirect()->route('barang.index')
            ->with('success','Barang Berhasil dibuat');
        }

        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function show($id)
        {
          
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

             $items=kategori::all();
         $task = barang::findOrFail($id);

 
         return view('barang.edit',compact('items'))->withTask($task);
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
                'keterangan' => 'required',
                'nama' => 'required',
                'id_kategori' => 'required',
                'stokmin' => 'required',
                'harga_bon' => 'required',
                'harga_eceran' => 'required',
                'harga_pedagang' => 'required',
                'stok' => 'required',

                
            ]);



$update = barang::find($id);
  $update->nama=$request->nama;
   $update->keterangan=$request->keterangan;
    $update->id_kategori=$request->id_kategori;
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
$file->move('assets/img/barang', $file->getClientOriginalName());
   $update->gambar = 'assets/img/barang/' . $file->getClientOriginalName();
}


$update->save(); 



      return redirect()->route('barang.index')
                        ->with('success','barang Berhasil di edit');
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
            $dihapus = barang::find($id);
            if($dihapus->gambar != "")
            {
                Storage::delete($dihapus->gambar); 
              

            }
            barang::destroy($id);
            return redirect()->route('barang.index')
                        ->with('success','barang Berhasil di delete');
        }
    }
