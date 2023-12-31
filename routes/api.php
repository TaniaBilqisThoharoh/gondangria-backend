<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WahanaController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\PengunjungController;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\HargaTiketController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



// Rute untuk Wahana
Route::get('wahana', [WahanaController::class, 'index']);

// Rute untuk Fasilitas
Route::get('fasilitas', [FasilitasController::class, 'index']);


// Rute untuk Beranda
Route::get('beranda', [BerandaController::class, 'index']);

// Rute untuk Tiket (disesuaikan dengan kebutuhan)

Route::get('harga_tiket', [HargaTiketController::class, 'index']);
Route::get('tiket', [TiketController::class, 'index']);
Route::post('tiket', [TiketController::class, 'store']);
Route::post('tiket/notification', [TiketController::class, 'notification']);

// Rute untuk Pengunjung (disesuaikan dengan kebutuhan)
Route::get('pengunjung', [PengunjungController::class, 'index']);
Route::post('pengunjung', [PengunjungController::class, 'store']);
Route::post('checkout-midtrans', [PengunjungController::class, 'checkoutMidtrans']);

// Rute untuk User (Admin)


Route::middleware('jwt.auth')->group(function () {
    $admin = md5('admins'); //2aefc34200a294a3cc7db81b43a81873
    
    Route::get($admin . '/admin/wahana/', [WahanaController::class, 'index']);
    Route::post($admin . '/admin/wahana/store', [WahanaController::class, 'store']);
    Route::post($admin . '/admin/wahana/update/{id}', [WahanaController::class, 'update']);
    Route::delete($admin . '/admin/wahana/destroy', [WahanaController::class, 'destroy']);

    Route::get($admin . '/admin/fasilitas/', [FasilitasController::class, 'index']);
    Route::post($admin . '/admin/fasilitas/store', [FasilitasController::class, 'store']);
    Route::post($admin . '/admin/fasilitas/update/{id}', [FasilitasController::class, 'update']);
    Route::delete($admin . '/admin/fasilitas/destroy/{id}', [FasilitasController::class, 'destroy']);

    Route::get($admin . '/admin/beranda/', [BerandaController::class, 'index']);
    // Route::put($admin . '/admin/beranda/{$id}', [BerandaController::class, 'update']);
    Route::post($admin . '/admin/beranda/store', [BerandaController::class, 'store']);
    Route::post($admin . '/admin/beranda/update/', [BerandaController::class, 'update']);
    Route::delete($admin . '/admin/beranda/destroy', [BerandaController::class, 'destroy']);

    Route::get($admin . 'harga_tiket', [HargaTiketController::class, 'index']);
    Route::get($admin . '/admin/harga_tiket/', [HargaTiketController::class, 'index']);
    Route::post($admin . '/admin/harga_tiket/', [HargaTiketController::class, 'store']);
    Route::post($admin . '/admin/harga_tiket/{id}', [HargaTiketController::class, 'update']);
});

Route::prefix('password')->group(function (){
    Route::post('forgot_password', [UserController::class, 'forgotPassword']);
    Route::post('validasi', [UserController::class, 'validasi_password']);
    Route::post('change_password', [UserController::class, 'changePassword']);
});


// Rute untuk Otentikasi
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout']);


// Rute untuk mendapatkan informasi pengguna saat ini (harus masuk terlebih dahulu)
Route::middleware('auth:api')->get('user', 'UserController@getUserInfo');

