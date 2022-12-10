<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\PenulisController;
use App\Http\Controllers\ReviewController;
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

Route::get('email/verify/{id}', [VerificationController::class, 'verify'])->name('verification.verify'); // Make sure to keep this as your route name
Route::get('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

    // show profile auth user
    Route::get('/profile', [UserController::class, 'showProfile']);
    // update profile auth user
    Route::put('/profile', [UserController::class, 'updateProfile']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);



    // show all buku
    Route::get('/buku', [BukuController::class, 'index']);
    // show buku by id
    Route::get('/buku/{id}', [BukuController::class, 'show']);
    // show buku by genre
    Route::get('/buku/genre/{id}', [BukuController::class, 'showByGenre']);
    // show buku by penulis
    Route::get('/buku/penulis/{id}', [BukuController::class, 'showByPenulis']);

    // show all genre
    Route::get('/genre', [GenreController::class, 'index']);
    // show genre by id
    Route::get('/genre/{id}', [GenreController::class, 'show']);

    // show all penulis
    Route::get('/penulis', [PenulisController::class, 'index']);
    // show penulis by id
    Route::get('/penulis/{id}', [PenulisController::class, 'show']);

    // show all review
    Route::get('/review', [ReviewController::class, 'index']);
    // show review by id
    Route::get('/review/{id}', [ReviewController::class, 'show']);
    // show review by buku
    Route::get('/review/buku/{id}', [ReviewController::class, 'showByBuku']);
    // show review by user
    Route::get('/review/user/{id}', [ReviewController::class, 'showByUser']);
    // store review
    Route::post('/review', [ReviewController::class, 'store']);
    // update review
    Route::put('/review/{id}', [ReviewController::class, 'update']);
    // delete review
    Route::delete('/review/{id}', [ReviewController::class, 'destroy']);
});

