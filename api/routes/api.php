<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\PenulisController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/bukus', [BukuController::class, 'index']);
Route::get('email/verify/{id}', [VerificationController::class, 'verify'])->name('verification.verify'); // Make sure to keep this as your route name
Route::get('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

Route::group(['middleware' => ['auth:sanctum']], function () {
    // show profile auth user
    Route::get('/profile', [UserController::class, 'showProfile']);
    // update profile auth user
    Route::put('/profile', [UserController::class, 'updateProfile']);

    Route::get('/user', [AuthController::class, 'user']);
    Route::get('/logout', [AuthController::class, 'logout']);
    
    Route::resource('/buku', BukuController::class);
    // show buku by genre
    Route::get('/buku/genre/{id}', [BukuController::class, 'showByGenre']);
    // show buku by penulis
    Route::get('/buku/penulis/{id}', [BukuController::class, 'showByPenulis']);

    Route::resource('/genre', GenreController::class);

    Route::resource('/penulis', PenulisController::class);

    Route::resource('/keranjang', KeranjangController::class);

    Route::resource('/transaksi', TransaksiController::class);

    Route::resource('/review', ReviewController::class);
    // show review by buku
    Route::get('/review/buku/{id}', [ReviewController::class, 'showByBuku']);
    // show review by user
    Route::get('/review/user/{id}', [ReviewController::class, 'showByUser']);
});

