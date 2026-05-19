<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\mainController;
use App\Http\Controllers\actionController;

Route::get('/', [mainController::class, 'viewLogin'])->name('login');
Route::get('/register', [mainController::class, 'viewRegister'])->name('register');
Route::redirect('/login', '/');

// User
Route::get('/home', [mainController::class, 'home'])->name('home')->middleware('auth');
Route::get('/home/history', [mainController::class, 'history'])->name('history')->middleware('auth');
Route::get('/produk/{id}', [mainController::class, 'produk'])->name('produk')->middleware('auth');
Route::get('/keranjang', [mainController::class, 'keranjang'])->name('keranjang')->middleware('auth');
Route::get('/pemesanan', [mainController::class, 'pemesanan'])->name('pemesanan')->middleware('auth');

//Admin
Route::get('/dashboard', [mainController::class, 'dashboard'])->name('dashboard')->middleware(['auth', 'admin']);
Route::get('/dashboard/produk', [mainController::class, 'listProduk'])->name('listProduk')->middleware(['auth', 'admin']);
Route::get('/dashboard/produk/edit/{id}', [mainController::class, 'viewEditProduk'])->name('viewEditProduk')->middleware(['auth', 'admin']);

// List User
Route::get('/dashboard/user', [mainController::class, 'listUser'])->name('listUser')->middleware(['auth', 'admin']);
Route::get('/dashboard/user/edit/{id}', [mainController::class, 'viewEditUser'])->name('viewEditUser')->middleware(['auth', 'admin']);

// list Category
Route::get('/dashboard/category', [mainController::class, 'listCategory'])->name('listCategory')->middleware(['auth', 'admin']);
Route::get('/dashboard/category/create', [mainController::class, 'viewCreateCategory'])->name('viewCreateCategory')->middleware(['auth', 'admin']);
Route::get('/dashboard/category/edit/{id}', [mainController::class, 'viewEditCategory'])->name('viewEditCategory')->middleware(['auth', 'admin']);

// List Transaksi
Route::get('/dashboard/transaksi', [mainController::class, 'listTransaksi'])->name('listTransaksi')->middleware(['auth', 'admin']);
Route::get('/dashboard/penjualan', [mainController::class, 'listPenjualan'])->name('listPenjualan')->middleware(['auth', 'admin']);
Route::get('/pemesanan/bayar-ulang/{id}', [actionController::class, 'bayarUlang'])->name('bayarUlang');
Route::post('/updateStatusPemesanan', [actionController::class, 'updateStatusPemesanan']);
Route::get('/pemesanan/cetak/{id}', [actionController::class, 'cetakStruk'])->name('cetakStruk')->middleware('auth');

// List Program
Route::get('/dashboard/listProgram', [mainController::class, 'listProgram'])->name('listProgram')->middleware(['auth', 'admin']);
Route::get('/dashboard/buatProgram', [mainController::class, 'viewBuatProgram'])->name('viewBuatProgram')->middleware(['auth', 'admin']);
Route::get('/dashboard/buatProgram/edit/{id}', [mainController::class, 'viewEditProgram'])->name('viewEditProgram')->middleware(['auth', 'admin']);

Route::get('/dashboard/listDiskon', [mainController::class, 'listDiskon'])->name('listDiskon')->middleware(['auth', 'admin']);
Route::get('/dashboard/buatDiskon', [mainController::class, 'viewBuatDiskon'])->name('viewBuatDiskon')->middleware(['auth', 'admin']);
Route::get('/dashboard/buatDiskon/edit/{id}', [mainController::class, 'viewEditDiskon'])->name('editDiskon')->middleware(['auth', 'admin']);

Route::get('/logOut', [actionController::class, 'signOut'])->name('logOut')->middleware('auth');

Route::post('/register/action', [actionController::class, 'register']);
Route::post('/registerKlinik/action', [actionController::class, 'registerKlinik'])->name('registerKlinik');
Route::post('/login/action', [actionController::class,  'login']);
Route::post('/masukKeranjang', [actionController::class, 'masukKeranjang'])->name('masukKeranjang')->middleware('auth');
Route::post('/pemesanan/create', [actionController::class, 'createPemesanan'])->name('createPemesanan')->middleware('auth');
Route::post('/category/create', [actionController::class, 'createCategory']);
Route::post('/produk/create', [actionController::class, 'createProduk'])->name('produk.store');
Route::post('/program/create', [actionController::class, 'buatProgram']);
Route::post('/buatDiskon/create', [actionController::class,'buatDiskon'])->name('buatDiskon')->middleware('auth');
// Route::post('/updateStatusPemesanan', [actionController::class, 'updateStatusPemesanan']);

Route::put('/pemesanan/update/{id}', [actionController::class, 'updatePemesanan'])->name('updatePemesanan');
Route::put('/category/update/{id}', [actionController::class, 'updateCategory']);
Route::put('/produk/update/{id}', [actionController::class, 'updateProduk']);
Route::put('/user/update/{id}', [actionController::class, 'updateUser'])->name('updateUser');
Route::put('/user/reassign/{id}', [actionController::class, 'reassignUserClinic'])->name('reassignUserClinic')->middleware(['auth', 'admin']);
Route::put('/program/update/{id}', [actionController::class, 'updateProgram'])->name('updateProgram');
Route::put('/diskon/update/{id}', [actionController::class, 'updateDiskon'])->name('updateDiskon');

Route::delete('/removeItemKeranjang/{id}', [actionController::class, 'removeItemKeranjang'])->name('removeItemKeranjang');
Route::delete('/produk/delete/{id}', [actionController::class, 'deleteProduk'])->name('deleteProduk');
Route::delete('/category/delete/{id}', [actionController::class, 'deleteCategory'])->name('deleteCategory');
Route::delete('/user/delete/{id}', [actionController::class, 'deleteUser'])->name('deleteUser');
Route::delete('/program/delete/{id}', [actionController::class, 'deleteProgram'])->name('deleteProgram');
Route::delete('/diskon/delete/{id}', [actionController::class, 'deleteDiskon'])->name('deleteDiskon');