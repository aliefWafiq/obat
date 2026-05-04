<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\User;
use App\Models\Produk;
use App\Models\Keranjang;
use App\Models\Category;
use App\Models\CategoryProduk;
use App\Models\Pemesanan;
use App\Models\DetailPemesanan;

class actionController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'alamat' => 'required',
            'phoneNumber' => 'required|unique:users,phoneNumber',
            'password' => 'required'
        ], [
            'username.required' => 'Username wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'phoneNumber.required' => 'Nomor telepon wajib diisi.',
            'phoneNumber.unique' => 'Nomor telepon sudah terdaftar.',
            'password.required' => 'Password wajib diisi.'
        ]);

        $password = Hash::make($request->input('password'));

        User::create([
            'username' => $request->input('username'),
            'alamat' => $request->input('alamat'),
            'phoneNumber' => $request->input('phoneNumber'),
            'password' => $password
        ]);

        return redirect('/login')->with('success', 'Akun berhasil dibuat. Silakan masuk.');
    }

    public function login(Request $request)
    {
        $data = array(
            'phoneNumber' => $request->input('phoneNumber'),
            'password' => $request->input('password')
        );
        $check = User::where('phoneNumber', $data['phoneNumber'])->first();

        if (Auth::attempt($data)) {
            if ($check->role == 'Admin') {
                return redirect('/dashboard');
            } else {
                return redirect('/home');
            }
        } else {
            return redirect('/login')->with('error', 'Nomor telepon atau password salah.');
        }
    }

    public function signOut()
    {
        Auth::logout();
        return redirect('/login')->with('success', 'Anda berhasil keluar.');
    }

    public function createProduk(Request $request)
    {
        $request->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'namaProduk' => 'required',
            'deskripsi' => 'required',
            'idCategory' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
        ], [
            'namaProduk.required' => 'Nama produk wajib diisi.',
            'deskripsi.required' => 'Deskripsi produk wajib diisi.',
            'idCategory.required' => 'Kategori produk wajib diisi.',
            'harga.required' => 'Harga produk wajib diisi.',
            'stok.required' => 'Stok produk wajib diisi.',
        ]);

        $request->file('gambar')->store('images', 'public');

        Produk::create([
            'namaProduk' => $request->input('namaProduk'),
            'deskripsi' => $request->input('deskripsi'),
            'idCategory' => $request->input('idCategory'),
            'harga' => $request->input('harga'),
            'stok' => $request->input('stok'),
            'gambar' => $request->file('gambar')->store('images', 'public')
        ]);

        return redirect('/dashboard')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function updateProduk(Request $request, $id)
    {
        $request->validate([
            'gambar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'namaProduk' => 'required',
            'deskripsi' => 'required',
            'idCategory' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric'
        ], [
            'namaProduk.required' => 'Nama produk wajib diisi.',
            'deskripsi.required' => 'Deskripsi produk wajib diisi.',
            'idCategory.required' => 'Kategori produk wajib diisi.',
            'harga.required' => 'Harga produk wajib diisi.',
            'stok.required' => 'Stok produk wajib diisi.'
        ]);

        $produk = Produk::find($id);
        $gambar = $request->hasFile('gambar') ? $request->file('gambar')->store('images', 'public') : $produk->gambar;

        if ($request->hasFile('gambar') && $produk->gambar) {
            Storage::disk('public')->delete($produk->gambar);
        }

        if ($produk) {
            $produk->update([
                'gambar' => $gambar,
                'namaProduk' => $request->input('namaProduk'),
                'deskripsi' => $request->input('deskripsi'),
                'idCategory' => $request->input('idCategory'),
                'harga' => $request->input('harga'),
                'stok' => $request->input('stok')
            ]);
            return redirect('/dashboard')->with('success', 'Produk berhasil diperbarui.');
        } else {
            return redirect('/dashboard')->with('error', 'Produk tidak ditemukan.');
        }
    }

    public function deleteProduk($id)
    {
        $produk = Produk::find($id);
        if ($produk) {
            Storage::disk('public')->delete($produk->gambar);
            $produk->delete();
            return redirect('/dashboard')->with('success', 'Produk berhasil dihapus.');
        } else {
            return redirect('/dashboard')->with('error', 'Produk tidak ditemukan.');
        }
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'username' => 'required',
            'alamat' => 'required',
            'phoneNumber' => 'required|unique:users,phoneNumber,' . $id,
            'role' => 'required'
        ], [
            'username.required' => 'Username wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'phoneNumber.required' => 'Nomor telepon wajib diisi.',
            'phoneNumber.unique' => 'Nomor telepon sudah terdaftar.',
            'role.required' => 'Role wajib diisi.'
        ]);

        $user = User::find($id);
        if ($user) {
            $user->update([
                'username' => $request->input('username'),
                'alamat' => $request->input('alamat'),
                'phoneNumber' => $request->input('phoneNumber'),
                'role' => $request->input('role')
            ]);
            return redirect('/dashboard/user')->with('success', 'User berhasil diperbarui.');
        } else {
            return redirect('/dashboard/user')->with('error', 'User tidak ditemukan.');
        }
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return redirect('/dashboard/user')->with('success', 'User berhasil dihapus.');
        } else {
            return redirect('/dashboard/user')->with('error', 'User tidak ditemukan.');
        }
    }

    public function masukKeranjang(Request $request)
    {
        $request->validate([
            'produk_id' => 'required',
            'jumlah' => 'required|numeric|min:1'
        ]);

        $userId = Auth::id();
        $checkCart = Keranjang::where('idUser', $userId)->where('idProduk', $request->input('produk_id'))->first();

        if ($request->input('jumlah') > Produk::find($request->input('produk_id'))->stok) {
            return redirect('/keranjang')->with('error', 'Jumlah produk melebihi stok yang tersedia.');
        } else {
            if ($checkCart) {
                $checkCart->update([
                    'jumlah' => $checkCart->jumlah + $request->input('jumlah')
                ]);
                return redirect('/keranjang')->with('success', 'Jumlah produk berhasil diperbarui di keranjang.');
            } else {
                Keranjang::create([
                    'idUser' => $userId,
                    'idProduk' => $request->input('produk_id'),
                    'jumlah' => $request->input('jumlah'),
                ]);

                return redirect('/keranjang')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
            }
        }
    }

    public function removeItemKeranjang($id)
    {
        $keranjangItem = Keranjang::find($id);
        if ($keranjangItem) {
            $keranjangItem->delete();
            return redirect('/keranjang')->with('success', 'Item berhasil dihapus dari keranjang.');
        } else {
            return redirect('/keranjang')->with('error', 'Item tidak ditemukan di keranjang.');
        }
    }

    public function createCategory(Request $request)
    {
        $request->validate([
            'namaCategory' => 'required|unique:category,namaCategory'
        ], [
            'namaCategory.required' => 'Nama kategori wajib diisi.',
            'namaCategory.unique' => 'Nama kategori sudah terdaftar.'
        ]);

        Category::create([
            'namaCategory' => $request->input('namaCategory')
        ]);

        return redirect('/dashboard/category')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function updateCategory(Request $request, $id)
    {
        $request->validate([
            'namaCategory' => 'required|unique:category,namaCategory,' . $id
        ], [
            'namaCategory.required' => 'Nama kategori wajib diisi.',
            'namaCategory.unique' => 'Nama kategori sudah terdaftar.'
        ]);

        $category = Category::find($id);
        if ($category) {
            $category->update([
                'namaCategory' => $request->input('namaCategory')
            ]);
            return redirect('/dashboard/category')->with('success', 'Kategori berhasil diperbarui.');
        } else {
            return redirect('/dashboard/category')->with('error', 'Kategori tidak ditemukan.');
        }
    }

    public function deleteCategory($id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->delete();
            return redirect('/dashboard/category')->with('success', 'Kategori berhasil dihapus.');
        } else {
            return redirect('/dashboard/category')->with('error', 'Kategori tidak ditemukan.');
        }
    }

    public function createPemesanan(Request $request)
    {
        $idUser = Auth::id();

        $itemKeranjang = Keranjang::with('produk')->where('idUser', $idUser)->get();

        if ($itemKeranjang->isEmpty()) {
            return redirect('/keranjang')->with('error', 'Keranjang kosong. Tambahkan produk sebelum melakukan pemesanan.');
        }

        $total = $itemKeranjang->sum(function ($item) {
            return $item->produk->harga * $item->jumlah;
        });

        if ($itemKeranjang->first()->produk->stok < $itemKeranjang->first()->jumlah) {
            return redirect('/keranjang')->with('error', 'Stok produk tidak mencukupi untuk jumlah yang Anda pesan.');
        }

        $kodePemesanan = 'PM' . time() . rand(1000, 9999);
        $estimasiPembayaran = now()->addDays(3)->format('Y-m-d');
        $estimasiPengiriman = now()->addDays(5)->format('Y-m-d');

        $pemesanan = Pemesanan::create([
            'kodePemesanan' => $kodePemesanan,
            'idUser' => $idUser,
            'status' => 'Pending',
            'totalHarga' => $total,
            'estimasipembayaran' => $estimasiPembayaran,
            'estimasiPengantaran' => $estimasiPengiriman
        ]);

        foreach ($itemKeranjang as $item) {
            DetailPemesanan::create([
                'idPemesanan' => $pemesanan->id,
                'idProduk' => $item->idProduk,
                'jumlahBeli' => $item->jumlah,
                'harga' => $item->produk->harga
            ]);
            $produk = Produk::find($item->idProduk);
            $produk->update([
                'stok' => $produk->stok - $item->jumlah
            ]);
        }

        Keranjang::where('idUser', $idUser)->delete();
        return redirect('/keranjang')->with('success', 'Pemesanan berhasil dibuat. Kode pemesanan: ' . $kodePemesanan);
    }
}
