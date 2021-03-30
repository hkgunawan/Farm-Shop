<?php

namespace App\Http\Controllers;
use Auth;

use App\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests;
use App\Http\Controllers\Controller;


class usercontroller extends Controller
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
            $Items= user::orderBy('name','asc')->paginate(5);
            return view('user.index',compact('Items'))
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
            return view('user.create');
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
                'username' => 'required',
                'password' => 'required',
                'name' => 'required',
                'alamat' => 'required',
                'role' => 'required',
                'telepon' => 'required',
            ]);
            $new_user = user::create($request->all());

            $new_user->password = bcrypt($new_user->password);
            $new_user->aktif = 1;
            $new_user ->save();





            return redirect()->route('user.index')
            ->with('success','user Berhasil dibuat');
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

            $items=user::all();
            $task = user::findOrFail($id);


            return view('user.edit',compact('items'))->withTask($task);
            return view('user.edit');
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
                'name' => 'required',
                
            ]);



            $update = user::find($id);
            $update->name=$request->name;
            $update->alamat=$request->alamat;
            $update->telepon=$request->telepon;
            $update->role=$request->role;



            if($request->password != ""){
                $update->password=bcrypt($request->password);
                
            }

            $update->save(); 


            return redirect()->route('user.index')
            ->with('success','user Berhasil di edit');
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
            $dihapus = user::find($id);

            $dihapus->aktif=0;
            if($dihapus->gambar != "")
            {
                Storage::delete($dihapus->gambar); 


            }
            //user::destroy($id);

            $dihapus->save(); 


            return redirect()->route('user.index')
            ->with('success','user Berhasil di delete');
        }

        public function reaktif($id)
        {

         if (Auth::guest())
            {

                return redirect('/home');
            }
            else if (Auth::user()->role!=1 && Auth::user()->aktif!=1) {

                return redirect('/home');
            }
            $dihapus = user::find($id);

            $dihapus->aktif=1;
            if($dihapus->gambar != "")
            {
                Storage::delete($dihapus->gambar); 


            }
            //user::destroy($id);

            $dihapus->save(); 


            return redirect()->route('user.index')
            ->with('success','user Berhasil di delete');
        }
    }
