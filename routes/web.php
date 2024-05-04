<?php

use App\Http\Middleware\Authenticate;
use App\Livewire\CreatePesanan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'index');

Route::middleware([
    // Authenticate::class
])->group(function () {

    Route::prefix('order')->group(function () {
        Route::view('/', 'pesanan.index');
        Route::get('/new', \App\Livewire\CreatePesanan::class);
        Route::get('/{record}', function (\App\Models\Pesanan $record) {
            return view('pesanan.view', ['item' => $record]);
        });
    });

    Route::prefix('checkout')->group(function () {
        Route::view('/new', 'pembayaran');
        Route::view('/selesai', 'checkout');
    });
});


Route::post('/checkout/callback', function () {
    $data = request()->all()['data'];
    $id = $data['reference_id'];

    //ubah status jadi lunas

    // if ($data['status'] == 'SUCCEEDED') {
    //     $booking = Booking::find($id);

    //     if (is_null($booking)) {
    //         return response('Data tidak ditemukan')->json();
    //     }

    //     $booking->lunas = 1;
    //     $booking->save();

    //     return response('Status berhasil diubah')->json();
    // }
    return response($data)->json();
});
