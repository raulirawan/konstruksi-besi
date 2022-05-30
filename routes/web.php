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

// Route::get('/', function () {
//     return view('welcome');
// });

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
    Route::get('transaksi/detail/{id}','Admin\TransaksiController@detail')->name('admin.transaksi.detail');
    Route::post('transaksi/add/pembayaran/{id}', 'Admin\TransaksiController@addPembayaran')->name('admin.add.pembayaran');
    Route::delete('transaksi/hapus/pembayaran/{id}', 'Admin\TransaksiController@deletePembayaran')->name('admin.delete.pembayaran');

});

Route::prefix('mandor')->middleware(['auth'])->group(function () {
    Route::get('dashboard','Mandor\DashboardController@index')->name('mandor.dashboard.index');
    Route::get('detail/pekerjaan/{id}','Mandor\DashboardController@detailPekerjaan')->name('mandor.detail.pekerjaan.index');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
