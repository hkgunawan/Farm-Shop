<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', 'HomeController@index');
Route::post('/login', 'Auth\LoginController@login');

Route::get('/laporanpembelian', 'laporancontroller@laporanpembelian');
Route::get('/laporanpenjualan', 'laporancontroller@laporanpenjualan');
Route::get('/laporankas', 'laporancontroller@laporankas');
Route::get('/laporanhutang', 'laporancontroller@laporanhutang');
Route::get('/laporanpiutang', 'laporancontroller@laporanpiutang');
Route::get('/laporanlabarugi', 'laporancontroller@laporanlabarugi');

Route::group(['middleware' => 'admin'], function () {   

});
/*
Route::get('/', function () {
    return view('welcome');
});*/

//disini masukkan yang ke barang, coba cek dr yang lama (tapi yg bentuk 1 package )




Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/returjual/ajax/{id}', 'returjualcontroller@ajax');
Route::get('/returbeli/ajax/{id}', 'returbelicontroller@ajax');
Route::get('/penjualan/cetak/{id}', 'penjualancontroller@cetak');
Route::get('/pembelian/detail/{id}', 'pembeliancontroller@detail');
Route::get('/penjualan/detail/{id}', 'penjualancontroller@detail');
Route::get('/penjualan/pengampunan/{id}', 'penjualancontroller@pengampunan');
Route::get('/returjual/detail/{id}', 'returjualcontroller@detail');
Route::get('/returbeli/detail/{id}', 'returbelicontroller@detail');
Route::get('/cicilan_penjualan/detail/{id}', 'cicilan_penjualancontroller@detail');
Route::get('/cicilan_pembelian/detail/{id}', 'cicilan_pembeliancontroller@detail');
Route::get('/user/reaktif/{id}', 'usercontroller@reaktif');

Route::resource('barang', 'barangcontroller');
Route::resource('suplier', 'supliercontroller');
Route::resource('user', 'usercontroller');
Route::resource('pelanggan', 'pelanggancontroller');
Route::resource('penjualan', 'penjualancontroller');
Route::resource('cicilan_penjualan', 'cicilan_penjualancontroller');
Route::resource('returjual', 'returjualcontroller');
Route::resource('returbeli', 'returbelicontroller');
Route::resource('cicilan_pembelian', 'cicilan_pembeliancontroller');
Route::resource('pembelian', 'pembeliancontroller');
Route::resource('pengeluaran', 'pengeluarancontroller');  
Route::resource('pemasukan', 'pemasukancontroller');  
Route::resource('kategori', 'kategoricontroller');  
    Route::get('/beranda','HomeController@index'); 