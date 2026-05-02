<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Produk;
use App\Models\keranjang;

class mainController extends Controller
{
    public function index() {
        return view('landingPage');
    }

    public function viewRegister() {
        if(Auth::check()) {
            return redirect('/home');
        }else {
            return view('register');
        }
    }

    public function viewLogin() {
        if(Auth::check()) {
            return redirect('/home');
        }else {
            return view('login');
        }
    }

    public function home() {
        $produk = Produk::all();
        return view('user.home', compact('produk'));
    }

    public function history() {
        return view('user.history');
    }

    public function keranjang() {
        $idUser = Auth::id();
        $items = Keranjang::with('produk')->where('idUser', $idUser)->get();
        return view('user.keranjang', compact('items'));
    }

    public function dashboard() {
        $produk = Produk::all();
        return view('admin.dashboard', compact('produk'));
    }

    public function viewCreateProduk() {
        return view('admin.createProduk');
    }

    public function viewEditProduk($id) {
        $produk = Produk::findOrFail($id);
        return view('admin.editProduk', compact('produk'));
    }
}