<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\User;
use App\Models\Produk;
use App\Models\Keranjang;

class actionController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'phoneNumber' => 'required|unique:users,phoneNumber',
            'password' => 'required'
        ], [
            'username.required' => 'Username wajib diisi.',
            'phoneNumber.required' => 'Nomor telepon wajib diisi.',
            'phoneNumber.unique' => 'Nomor telepon sudah terdaftar.',
            'password.required' => 'Password wajib diisi.'
        ]);

        $password = Hash::make($request->input('password'));

        User::create([
            'username' => $request->input('username'),
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
            if($check->role == 'Admin'){
                return redirect('/dashboard');
            }else{
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

    public function createProduk(Request $request){
        $request->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'namaProduk' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
        ],[
            'namaProduk.required' => 'Nama produk wajib diisi.',
            'harga.required' => 'Harga produk wajib diisi.',
            'stok.required' => 'Stok produk wajib diisi.',
        ]);

        $request->file('gambar')->store('images', 'public');

        Produk::create([
            'namaProduk' => $request->input('namaProduk'),
            'harga' => $request->input('harga'),
            'stok' => $request->input('stok'),
            'gambar' => $request->file('gambar')->store('images', 'public')
        ]);

        return redirect('/dashboard')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function updateProduk(Request $request, $id){
        $request->validate([
            'gambar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'namaProduk' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric'
        ],[
            'namaProduk.required' => 'Nama produk wajib diisi.',
            'harga.required' => 'Harga produk wajib diisi.',
            'stok.required' => 'Stok produk wajib diisi.'
        ]);
        
        $produk = Produk::find($id);
        $gambar = $request->hasFile('gambar') ? $request->file('gambar')->store('images', 'public') : $produk->gambar;

        if($request->hasFile('gambar') && $produk->gambar) {
            Storage::disk('public')->delete($produk->gambar);
        }

        if($produk){
            $produk->update([
                'gambar' => $gambar,
                'namaProduk' => $request->input('namaProduk'),
                'harga' => $request->input('harga'),
                'stok' => $request->input('stok')
            ]);
            return redirect('/dashboard')->with('success', 'Produk berhasil diperbarui.');
        }else{
            return redirect('/dashboard')->with('error', 'Produk tidak ditemukan.');
        }
    }

    public function deleteProduk($id){
        $produk = Produk::find($id);
        if ($produk) {
            Storage::disk('public')->delete($produk->gambar);
            $produk->delete();
            return redirect('/dashboard')->with('success', 'Produk berhasil dihapus.');
        } else {
            return redirect('/dashboard')->with('error', 'Produk tidak ditemukan.');
        }
    }

    public function masukKeranjang(Request $request){
        $request->validate([
            'produk_id' => 'required',
            'jumlah' => 'required|numeric|min:1'
        ]);

        $userId = Auth::id();

        Keranjang::create([
            'idUser' => $userId,
            'idProduk' => $request->input('produk_id'),
            'jumlah' => $request->input('jumlah'),
        ]);

        return redirect('/keranjang')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function removeItemKeranjang($id){
        $keranjangItem = Keranjang::find($id);
        if ($keranjangItem) {
            $keranjangItem->delete();
            return redirect('/keranjang')->with('success', 'Item berhasil dihapus dari keranjang.');
        } else {
            return redirect('/keranjang')->with('error', 'Item tidak ditemukan di keranjang.');
        }
    }
}
