<?php

use App\Http\Middleware\Authenticate;
use App\Livewire\ListOrders;
use App\Livewire\UserProfile;
use App\Livewire\ViewOrder;
use App\Models\Pembayaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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
    Authenticate::class,
])->group(function () {

    Route::prefix('profil')->group(function () {
        Route::get('/', UserProfile::class);
    });

    Route::prefix('order')->group(function () {
        Route::get('/', ListOrders::class);
        Route::get('/new', \App\Livewire\CreatePesanan::class);
        Route::get('/{record}', ViewOrder::class);
    });

    Route::prefix('checkout')->group(function () {
        Route::get('/new', function (Request $request) {
            $metode = $request->get('metode');

            //total semua berat
            $pesanan = \App\Models\Pesanan::with('tabung')->whereNull('pembayaran_id');

            $totalBerat = 0;
            $pesanan->get()->each(function ($item) use (&$totalBerat) {
                $totalBerat += $item->tabung->berat;
            });

            $hargaOngkir = \App\Models\Setting::where('key', 'ongkir')->first()->value;

            $pembayaran = \App\Models\Pembayaran::create([
                'metode' => $metode,
                'subtotal' => $pesanan->sum('subtotal'),
                'ongkir' => $totalBerat * $hargaOngkir,
            ]);

            $batasWaktu = Carbon::createFromDate()->addDays(30);

            if ($metode != 'Cash') {
                $createVA = Http::withHeader('content-type', 'application/json')
                    ->withBasicAuth(env('XENDIT_API_KEY'), '')
                    ->post('https://api.xendit.co/callback_virtual_accounts', [
                        "external_id" => "$pembayaran->id",
                        "bank_code" => str_replace(' ', '_', strtoupper($metode)),
                        "name" => auth()->user()->name,
                        "is_single_use" => true,
                        "is_closed" => true,
                        "expected_amount" => $pembayaran->subtotal,
                        "expiration_date" => now()->addHours(3),
                    ])->json();

                $pembayaran->va_id = $createVA['id'];
                $pembayaran->save();

                $batasWaktu = Carbon::parse($createVA["expiration_date"]);
            }

            $pesanan->update(['pembayaran_id' => $pembayaran->id]);

            return view('pembayaran', [
                'item' => $pembayaran,
                'date' => $batasWaktu->format('d M Y, H:m'),
                'sisaWaktu' => $batasWaktu->diff(now()),
                'va' => $createVA ?? null
            ]);
        });
        Route::get('/{record}', function (Pembayaran $record) {
            return view('checkout', ['item' => $record]);
        });
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
