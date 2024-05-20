<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CheckoutController extends Controller
{
    public function create(Request $request)
    {
        $metode = $request->post('metode');
        $totalBerat = 0;
        $hargaOngkir = \App\Models\Setting::where('key', 'ongkir')->first()->value;
        $pesanan = \App\Models\Pesanan::with('tabung')->whereNull('pembayaran_id');

        //cek stok tiap pesanan selain refill
        foreach ($pesanan->get() as $item) {
            if (!strpos($item->nama, 'refill'))
                if ($item->tabung->stok < $item->qty) {
                    // kalau ada stok yang kurang tampilkan error
                    return view('checkout-error');
                }
        }

        //kurangi stok tiap pesanan
        $pesanan->get()->each(function ($item) use (&$totalBerat) {
            //total semua berat
            $totalBerat += $item->tabung->berat;

            //cek stok selain refill
            if (!strpos($item->nama, 'refill')) {
                $tabung = \App\Models\Tabung::find($item->tabung->id);
                $tabung->stok -= $item->qty;
                $tabung->save();
            }
        });


        $pembayaran = \App\Models\Pembayaran::create([
            'metode' => $metode,
            'subtotal' => $pesanan->sum('subtotal'),
            'ongkir' => $totalBerat * $hargaOngkir,
        ]);

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
                    "expiration_date" => now()->addDay(),
                ])->json();

            $pembayaran->va_id = $createVA['id'];
            $pembayaran->save();
        }

        $pesanan->update(['pembayaran_id' => $pembayaran->id]);

        return redirect(url('/checkout', $pembayaran->id));
    }

    public function view(Pembayaran $record)
    {
        $batasWaktu = Carbon::createFromDate()->addDays(30);

        if (!$record->motode == 'cash') {
            $getVA = Http::withHeader('content-type', 'application/json')
                ->withBasicAuth(env('XENDIT_API_KEY'), '')
                ->get('https://api.xendit.co/callback_virtual_accounts/' . $record->va_id)->json();

            $batasWaktu = Carbon::parse($getVA["expiration_date"]);
        }

        return view('pembayaran', [
            'item' => $record,
            'date' => $batasWaktu,
            'va' => $getVA ?? null
        ]);
    }

    public function print(Pembayaran $record)
    {
        return view('checkout', ['item' => $record]);
    }

    public function simulate(Pembayaran $record)
    {
        Http::withHeader('content-type', 'application/json')
            ->withBasicAuth(env('XENDIT_API_KEY'), '')
            ->post('https://api.xendit.co/callback_virtual_accounts/external_id=' . $record->va_id . '/simulate_payment', [
                "amount" => $record->subtotal,
            ])->json();

        return redirect()->back();
    }

    public function updateStats()
    {
        $data = request()->all();
        dd($data);
        $id = $data['reference_id'];

        $item = Pembayaran::find($id);

        if (is_null($item))
            return response('Data tidak ditemukan')->json();

        if ($data['status'] != 'SUCCEEDED') {
            // kirim notifikasi ke user
            Notification::make()
                ->title('Pembayaran gagal')
                ->body('Waktu Pesanan #' . $item->id . ' telah berakhir. Harap melakukan checkout ulang untuk melakukan pembayaran ulang')
                ->sendToDatabase($item->pesanan->first()->user);

            return response('Pembayaran gagal')->json();
        }

        //ubah status jadi lunas
        $item->tgl_lunas = now();
        $item->save();

        // kirim notifikasi ke user
        Notification::make()
            ->title('Pembayaran berhasil')
            ->body('Pesanan #' . $item->id . ' dengan total ' . $item->total . ' telah berhasil di bayar.')
            ->sendToDatabase($item->pesanan->first()->user);

        return response('Status berhasil diubah')->json();
    }
}
