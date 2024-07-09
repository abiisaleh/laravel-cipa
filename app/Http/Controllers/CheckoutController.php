<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Carbon\Carbon;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CheckoutController extends Controller
{
    public function callback()
    {
        $data = request()->all();

        $id = $data['external_id'];

        $item = Pembayaran::find($id);

        if (is_null($item))
            return response('Data tidak ditemukan');

        //ubah status jadi lunas
        $item->lunas = true;
        $item->tgl_lunas = now();
        $item->save();

        // kirim notifikasi ke user
        Notification::make()
            ->title('Pembayaran berhasil')
            ->body('Pesanan #' . $item->id . ' dengan total Rp. ' . number_format($item->total) . ' telah berhasil di bayar.')
            ->actions(
                [
                    Action::make('lihat')->url('/order/' . $item->id)
                ]
            )
            ->sendToDatabase($item->pesanan->first()->user);

        return response('Status berhasil diubah');
    }
}
