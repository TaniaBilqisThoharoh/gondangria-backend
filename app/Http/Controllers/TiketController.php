<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengunjung;
use App\Models\Tiket;
use Midtrans\Config;
use Midtrans\Notification;

class TiketController extends Controller
{

    public function getPrice(){
        $tiket = Tiket::all();
        return response()->json($tiket, 200);
    }
    
    public function index()
    {
        $tiket = Tiket::all();
        return response()->json($tiket, 200);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'pengunjung_id' => 'required|exists:pengunjung,id',
            'total_pembayaran' => 'required|numeric',
        ]);

        // Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = !env('MIDTRANS_IS_SANDBOX');

        // Data pembayaran ke Midtrans
        $orderId = uniqid();
        $transaction = new Transaction;
        $transaction->payment_type = 'gopay';
        $transaction->transaction_details = [
            'order_id' => $orderId,
            'gross_amount' => $request->input('total_pembayaran'),
        ];
        // Tambahkan item_details dan customer_details sesuai kebutuhan

        // Buat Snap Token untuk pembayaran
        $snapToken = $transaction->createSnapToken();

        return response()->json(['snap_token' => $snapToken], 200);
    }

    public function storeTiket(Request $request){
        $tiket = new Tiket([
            'harga'
        ]);

        $tiket->harga = $request->input('harga');

        $tiket->save();

        return response()->json(["message"=>"Harga telah ditambahkan"]);
    }

    public function notification(Request $request)
    {
        // Callback dari Midtrans
        $notification = new Notification();

        // Periksa status pembayaran
        if ($notification->isSuccessful()) {
            // Jika pembayaran berhasil, buat tiket
            $orderId = $notification->order_id;
            $pengunjung = Pengunjung::where('email', $orderId)->first();

            if ($pengunjung) {
                $tiket = new Tiket(['pengunjung_id' => $pengunjung->id]);
                $tiket->save();
            }

            return response('OK', 200);
        } else {
            // Jika pembayaran gagal, tangani sesuai kebutuhan Anda
            return response('Pembayaran tidak berhasil', 400);
        }
    }
}
