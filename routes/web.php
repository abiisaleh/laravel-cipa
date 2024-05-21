<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\DatabaseNotification;
use App\Http\Middleware\UserVerification;
use App\Models\Pembayaran;
use Barryvdh\DomPDF\Facade\Pdf;
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
        Route::post('/new', [CheckoutController::class, 'create']);
        Route::get('/{record}', [CheckoutController::class, 'view']);
        Route::get('/{record}/simulasi', [CheckoutController::class, 'simulate']);
        Route::get('/{record}/print', [CheckoutController::class, 'print']);
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
    });
});


Route::post('/checkout/callback', [CheckoutController::class, 'updateStats']);
