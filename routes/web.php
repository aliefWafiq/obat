<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\mainController;
use App\Http\Controllers\actionController;

Route::get('/', [mainController::class, 'index'])->name('landingPage');
Route::get('/register', [mainController::class, 'viewRegister'])->name('register');
Route::get('/login', [mainController::class, 'viewLogin'])->name('login');

Route::get('/home', [mainController::class, 'home'])->name('home')->middleware('auth');
Route::get('/home/history', [mainController::class, 'history'])->name('history')->middleware('auth');
Route::get('/produk/{id}', [mainController::class, 'produk'])->name('produk')->middleware('auth');
Route::get('/keranjang', [mainController::class, 'keranjang'])->name('keranjang')->middleware('auth');

Route::get('/dashboard', [mainController::class, 'dashboard'])->name('dashboard')->middleware('auth');
Route::get('/dashboard/produk/create', [mainController::class, 'viewCreateProduk'])->name('viewCreateProduk')->middleware('auth');
Route::get('/dashboard/produk/edit/{id}', [mainController::class, 'viewEditProduk'])->name('viewEditProduk')->middleware('auth');

Route::post('/register/action', [actionController::class, 'register']);
Route::post('/login/action', [actionController::class,  'login']);
Route::get('/logOut', [actionController::class, 'signOut'])->name('logOut')->middleware('auth');

Route::post('/masukKeranjang', [actionController::class, 'masukKeranjang'])->name('masukKeranjang')->middleware('auth');
Route::post('/pemesanan/create', [actionController::class, 'createPemesanan']);
Route::post('/pemesanan/update/{id}', [actionController::class, 'updatePemesanan']);

Route::post('/produk/create', [actionController::class, 'createProduk']);
Route::put('/produk/update/{id}', [actionController::class, 'updateProduk']);

Route::delete('/removeItemKeranjang/{id}', [actionController::class, 'removeItemKeranjang'])->name('removeItemKeranjang');
Route::delete('/produk/delete/{id}', [actionController::class, 'deleteProduk'])->name('deleteProduk');