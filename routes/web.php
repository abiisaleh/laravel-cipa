<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\DatabaseNotification;
use App\Http\Middleware\UserPelanggan;
use App\Http\Middleware\UserPimpinan;
use App\Http\Middleware\UserVerification;
use App\Livewire\Checkout\PrintCheckout;
use App\Livewire\Checkout\ViewCheckout;
use App\Models\Pembayaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
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

Route::view('/', 'index')->middleware(DatabaseNotification::class);

Route::middleware([
    Authenticate::class,
    DatabaseNotification::class,
    UserPelanggan::class,
])->group(function () {
    Route::prefix('profil')->group(function () {
        Route::get('/', \App\Livewire\UserProfile::class);
    });

    Route::prefix('order')->group(function () {
        Route::get('/', \App\Livewire\Order\ListOrder::class);
        Route::get('/new', \App\Livewire\Order\CreateOrder::class)->middleware([UserVerification::class]);
        Route::get('/{id}', \App\Livewire\Order\ViewOrder::class);
    });

    Route::prefix('checkout')->group(function () {
        Route::get('/{record}', ViewCheckout::class);
        Route::get('/{record}/print', PrintCheckout::class);
    });
});

Route::get('report/print/{from}/{until}', function ($from, $until) {
    $item = Pembayaran::whereBetween('tgl_lunas', [$from, $until])->get();

    $pdf = Pdf::loadView('pdf.report', [
        'from' => $from,
        'until' => $until,
        'items' =>  $item,
        'total' => $item->sum('subtotal') + $item->sum('ongkir') + $item->sum('denda')
    ]);

    return $pdf->stream();
})->middleware([
    Authenticate::class,
    UserPimpinan::class,
]);

Route::post('/checkout/callback', [CheckoutController::class, 'callback']);
