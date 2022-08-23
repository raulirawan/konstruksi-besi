<?php

use Illuminate\Support\Facades\Route;

/*konstruksi-besi
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::prefix('admin')->middleware(['auth','admin'])->group(function () {
    Route::get('dashboard','Admin\DashboardController@index')->name('admin.dashboard.index');



    // CRUD KLIEN
    Route::get('klien', 'Admin\KlienController@index')->name('admin.klien.index');
    Route::post('klien/create', 'Admin\KlienController@store')->name('admin.klien.store');
    Route::post('klien/update/{id}', 'Admin\KlienController@update')->name('admin.klien.update');
    Route::post('klien/delete/{id}', 'Admin\KlienController@delete')->name('admin.klien.delete');

    Route::get('portfolio', 'Admin\PortfolioController@index')->name('admin.portfolio.index');
    Route::post('portfolio/create', 'Admin\PortfolioController@store')->name('admin.portfolio.store');
    Route::post('portfolio/update/{id}', 'Admin\PortfolioController@update')->name('admin.portfolio.update');
    Route::post('portfolio/delete/{id}', 'Admin\PortfolioController@delete')->name('admin.portfolio.delete');

    Route::get('mandor', 'Admin\MandorController@index')->name('admin.mandor.index');
    Route::post('mandor/create', 'Admin\MandorController@store')->name('admin.mandor.store');
    Route::post('mandor/update/{id}', 'Admin\MandorController@update')->name('admin.mandor.update');
    Route::post('mandor/delete/{id}', 'Admin\MandorController@delete')->name('admin.mandor.delete');

    Route::get('transaksi','Admin\TransaksiController@index')->name('admin.transaksi.index');
    Route::get('transaksi/riwayat-pekerjaan','Admin\TransaksiController@riwayatPekerjaan')->name('admin.transaksi.riwayat.pekerjaan');
    Route::get('transaksi/detail/{id}','Admin\TransaksiController@detail')->name('admin.transaksi.detail');
    Route::post('transaksi/add/pembayaran/{id}', 'Admin\TransaksiController@addPembayaran')->name('admin.add.pembayaran');
    Route::delete('transaksi/hapus/pembayaran/{id}', 'Admin\TransaksiController@deletePembayaran')->name('admin.delete.pembayaran');

    Route::post('transaksi/accept','Admin\TransaksiController@accept')->name('admin.accept.transaksi');
    Route::get('transaksi/reject/{id}','Admin\TransaksiController@reject')->name('admin.reject.transaksi');


    Route::get('progress/accept/progress/{id}','Admin\TransaksiController@acceptProgress')->name('admin.accept.progress');
    Route::get('progress/reject/progress/{id}','Admin\TransaksiController@rejectProgress')->name('admin.reject.progress');


});
// mandor
Route::prefix('mandor')->middleware(['auth','mandor'])->group(function () {
    Route::get('dashboard','Mandor\DashboardController@index')->name('mandor.dashboard.index');
    Route::get('detail/pekerjaan/{id}','Mandor\DashboardController@detailPekerjaan')->name('mandor.detail.pekerjaan.index');
    Route::post('add/progress/{id}','Mandor\DashboardController@addProgress')->name('mandor.add.progress');
    Route::post('update/progress/{id}','Mandor\DashboardController@updateProgress')->name('mandor.update.progress');
    Route::delete('delete/progress/{id}','Mandor\DashboardController@deleteProgress')->name('mandor.delete.progress');
});

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard','Klien\DashboardController@index')->name('klien.dashboard.index');
    Route::get('detail/pekerjaan/{id}','Klien\DashboardController@detailPekerjaan')->name('klien.pekerjaan.detail.index');
    Route::get('order','Klien\OrderController@index')->name('klien.order.index');
    Route::get('order/form/{id}','Klien\OrderController@orderForm')->name('klien.order.form');
    Route::post('order/store','Klien\OrderController@orderStore')->name('klien.order.store');

    Route::get('/pembayaran','Klien\PembayaranController@index')->name('pembayaran.index');
    Route::get('/pembayaran/detail/{id}','Klien\PembayaranController@detail')->name('pembayaran.detail');

    Route::post('/bayar/{id}','Klien\PembayaranController@bayar')->name('bayar.klien');


    Route::get('/profil', 'Klien\ProfilController@index')->name('klien.profile.index');
    Route::post('/update/profil', 'Klien\ProfilController@update')->name('klien.profile.update');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/midtrans/callback', 'MidtransController@callback')->name('callback');
