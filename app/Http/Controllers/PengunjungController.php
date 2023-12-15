<?php

namespace App\Http\Controllers;

use App\Models\Pengunjung;
use Illuminate\Http\Request;
use Mail;
use App\Mail\NotifMailTicket;

class PengunjungController extends Controller
{
    public function index()
    {
        $pengunjung = Pengunjung::all();
        return response()->json($pengunjung, 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'order_id' => 'required|string',
            'nama' => 'required|string',
            'email' => 'required|email',
            'no_telepon' => 'required|string',
            'tanggal' => 'required|date',
            'jumlah_tiket' => 'required|string',
            'subtotal' => 'required|string',
        ]);

        $pengunjung = new Pengunjung([
            'order_id' => $request->input('order_id'),
            'nama' => $request->input('nama'),
            'email' => $request->input('email'),
            'no_telepon' => $request->input('no_telepon'),
            'tanggal' => $request->input('tanggal'),
            'jumlah_tiket' => $request->input('jumlah_tiket'),
            'subtotal' => $request->input('subtotal'),
        ]);

        $pengunjung->save();

        return response()->json(['message' => 'Pengunjung ditambahkan'], 201);
    }

    //kirim tiket email
    public function kirimTiket($order_id)
    {
        $mailData = Pengunjung::where('order_id', $order_id)->firstOrFail();
        
        if($mailData){ 
            Mail::to($mailData->email)->send(new NotifMailTicket($mailData));
            
            return response()->json(['message'=> 'Email telah terkirim, mohon periksa email dan folder spam anda'], 200);
            
        }else{
            
            return response()->json(['message'=> 'Mohon maaf email ini tidak terdaftar'], 404);
        }

        return response()->json(['message' => 'Pengunjung ditambahkan'], 201);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama' => 'string',
            'email' => 'email|unique:pengunjung,email,'.$id,
            'no_telepon' => 'string',
        ]);

        $pengunjung = Pengunjung::find($id);

        if (!$pengunjung) {
            return response()->json(['message' => 'Pengunjung tidak ditemukan'], 404);
        }

        if ($request->has('nama')) {
            $pengunjung->nama = $request->input('nama');
        }

        if ($request->has('email')) {
            $pengunjung->email = $request->input('email');
        }

        if ($request->has('no_telepon')) {
            $pengunjung->no_telepon = $request->input('no_telepon');
        }

        $pengunjung->save();

        return response()->json(['message' => 'Pengunjung diperbarui'], 200);
    }

    public function destroy($id)
    {
        $pengunjung = Pengunjung::find($id);

        if (!$pengunjung) {
            return response()->json(['message' => 'Pengunjung tidak ditemukan'], 404);
        }

        $pengunjung->delete();

        return response()->json(['message' => 'Pengunjung dihapus'], 200);
    }

    public function checkoutMidtrans(Request $request){
        $token = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 100);
        \Midtrans\Config::$serverKey = 'SB-Mid-server-WhCkOGXvIKSEMKIEzklyKqBB';
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
        
        $params = array(
            'transaction_details' => array(
                'order_id' => $token,
                'gross_amount' => $request->subtotal,
            ),
            'customer_details' => array(
                'name' => $request->nama,
                'email' => $request->email,
                'phone' => $request->no_telepon,
                'tickets_amount' => $request->jumlah_tiket,
            ),
            /* 'test_type_tt' => 'donasi', */
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return response()->json([
            'token' => $snapToken,
            'orderId' => $token,
        ]);
    }

    public function sendTickets(Request $request){
        $token = rand(100000, 999999);
        /* dd($request); */
        \Midtrans\Config::$serverKey = 'SB-Mid-server-WhCkOGXvIKSEMKIEzklyKqBB';
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
        
        $params = array(
            'transaction_details' => array(
                'order_id' => $token,
                'gross_amount' => $request->subtotal,
            ),
            'customer_details' => array(
                'name' => $request->nama,
                'email' => $request->email,
                'phone' => $request->no_telepon,
                'tickets_amount' => $request->jumlah_tiket,
            ),
            /* 'test_type_tt' => 'donasi', */
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return $snapToken;
    }
}
