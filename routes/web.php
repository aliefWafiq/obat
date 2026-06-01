<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\mainController;
use App\Http\Controllers\actionController;

Route::get('/', [mainController::class, 'viewLogin'])->name('login');
Route::get('/register', [mainController::class, 'viewRegister'])->name('register');
Route::redirect('/login', '/');
Route::get('/maintenance', [mainController::class, 'viewMaintenance'])->name('maintenance');

Route::post('/register/action', [actionController::class, 'register']);
Route::post('/register/send-otp', [actionController::class, 'sendOTP'])->name('sendOTP');
Route::post('/login/action', [actionController::class,  'login']);
Route::post('/updateStatusPemesanan', [actionController::class, 'updateStatusPemesanan']);


// Routes requiring authentication (User, Admin, SuperAdmin)
Route::middleware(['auth'])->group(function () {
    // User pages
    Route::get('/home', [mainController::class, 'home'])->name('home');
    // Route::get('/produk/{id}', [mainController::class, 'produk'])->name('produk');
    Route::get('/keranjang', [mainController::class, 'keranjang'])->name('keranjang');
    Route::get('/pemesanan', [mainController::class, 'pemesanan'])->name('pemesanan');

    // User actions
    Route::post('/masukKeranjang', [actionController::class, 'masukKeranjang'])->name('masukKeranjang');
    Route::post('/pemesanan/create/{type}', [actionController::class, 'createPemesanan'])->name('createPemesanan');
    Route::get('/pemesanan/bayar-ulang/{id}', [actionController::class, 'bayarUlang'])->name('bayarUlang');
    Route::get('/pemesanan/cetak/{id}', [actionController::class, 'cetakStruk'])->name('cetakStruk');
    Route::delete('/removeItemKeranjang/{id}', [actionController::class, 'removeItemKeranjang'])->name('removeItemKeranjang');
    Route::get('/logOut', [actionController::class, 'signOut'])->name('logOut');

    // Admin & SuperAdmin dashboard and management
    Route::middleware(['admin'])->group(function () {
        // Views
        Route::get('/dashboard', [mainController::class, 'dashboard'])->name('dashboard');
        Route::get('/dashboard/produk', [mainController::class, 'listProduk'])->name('listProduk');
        Route::get('/dashboard/produk/edit/stok', [mainController::class, 'viewEditStok'])->name('viewEditStok');
        Route::get('/dashboard/produk/edit/{id}', [mainController::class, 'viewEditProduk'])->name('viewEditProduk');
        Route::get('/dashboard/akun', [mainController::class, 'listAkun'])->name('listAkun');
        Route::get('/dashboard/user', [mainController::class, 'listUser'])->name('listUser');
        Route::get('/dashboard/user/edit/{id}', [mainController::class, 'viewEditUser'])->name('viewEditUser');
        Route::get('/dashboard/klinik', [mainController::class, 'listKlinik'])->name('listKlinik');
        Route::get('/dashboard/category', [mainController::class, 'listCategory'])->name('listCategory');
        Route::get('/dashboard/category/create', [mainController::class, 'viewCreateCategory'])->name('viewCreateCategory');
        Route::get('/dashboard/category/edit/{id}', [mainController::class, 'viewEditCategory'])->name('viewEditCategory');
        Route::get('/dashboard/transaksi', [mainController::class, 'listTransaksi'])->name('listTransaksi');
        Route::get('/dashboard/penjualan', [mainController::class, 'listPenjualan'])->name('listPenjualan');
        Route::get('/dashboard/listProgram', [mainController::class, 'listProgram'])->name('listProgram');
        Route::get('/dashboard/buatProgram', [mainController::class, 'viewBuatProgram'])->name('viewBuatProgram');
        Route::get('/dashboard/buatProgram/edit/{id}', [mainController::class, 'viewEditProgram'])->name('viewEditProgram');
        Route::get('/dashboard/listDiskon', [mainController::class, 'listDiskon'])->name('listDiskon');
        Route::get('/dashboard/buatDiskon', [mainController::class, 'viewBuatDiskon'])->name('viewBuatDiskon');
        Route::get('/dashboard/buatDiskon/edit/{id}', [mainController::class, 'viewEditDiskon'])->name('editDiskon');
        Route::get('/dashboard/invoice', [mainController::class, 'listInvoice'])->name('listInvoice');
        Route::get('/dashboard/settings', [mainController::class, 'viewSettings'])->name('viewSettings');
        Route::get('/dashboard/activity-logs', [mainController::class, 'viewActivityLogs'])->name('viewActivityLogs');

        // Actions
        Route::post('/registerKlinik/action', [actionController::class, 'registerKlinik'])->name('registerKlinik');
        Route::post('/category/create', [actionController::class, 'createCategory']);
        Route::post('/produk/create', [actionController::class, 'createProduk'])->name('produk.store');
        Route::post('/program/create', [actionController::class, 'buatProgram']);
        Route::post('/buatDiskon/create', [actionController::class, 'buatDiskon'])->name('buatDiskon');
        Route::post('/dashboard/produk/edit/stok/bulk', [actionController::class, 'updateStokMassal'])->name('produk.updateStokMassal');
        
        Route::put('/category/update/{id}', [actionController::class, 'updateCategory']);
        Route::put('/produk/update/{id}', [actionController::class, 'updateProduk']);
        Route::put('/produk/update-stock/{id}', [actionController::class, 'updateStok'])->name('produk.updateStok');
        Route::put('/user/update/{id}', [actionController::class, 'updateUser'])->name('updateUser');
        Route::put('/user/reassign/{id}', [actionController::class, 'reassignUserClinic'])->name('reassignUserClinic');
        Route::put('/program/update/{id}', [actionController::class, 'updateProgram'])->name('updateProgram');
        Route::put('/diskon/update/{id}', [actionController::class, 'updateDiskon'])->name('updateDiskon');
        Route::put('/admin/settings/update', [actionController::class, 'updateSettings'])->name('admin.settings.update');
        Route::post('/admin/settings/backup', [actionController::class, 'backupDatabase'])->name('admin.settings.backup');
        Route::post('/admin/settings/restore', [actionController::class, 'restoreDatabase'])->name('admin.settings.restore');
        Route::post('/transaksi/approve/{id}', [actionController::class, 'approveTransaksi'])->name('approveTransaksi');
        Route::post('/transaksi/deny/{id}', [actionController::class, 'denyTransaksi'])->name('denyTransaksi');

        Route::delete('/produk/delete/{id}', [actionController::class, 'deleteProduk'])->name('deleteProduk');
        Route::delete('/category/delete/{id}', [actionController::class, 'deleteCategory'])->name('deleteCategory');
        Route::delete('/user/delete/{id}', [actionController::class, 'deleteUser'])->name('deleteUser');
        Route::delete('/program/delete/{id}', [actionController::class, 'deleteProgram'])->name('deleteProgram');
        Route::delete('/diskon/delete/{id}', [actionController::class, 'deleteDiskon'])->name('deleteDiskon');
    });

// OTP verification route
Route::post('register/verify-otp', [actionController::class, 'verifyOTP'])->name('verifyOTP');
});