<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Produk;
use App\Models\keranjang;
use App\Models\User;
use App\Models\Category;
use App\Models\Pemesanan;

class mainController extends Controller
{
    public function index()
    {
        $categories = Category::with(['produk' => function ($query) {
            $query->latest()->limit(1);
        }])->take(4)->get();

        $produk = Produk::with('category')->latest()->take(4)->get();

        return view('landingPage', compact('categories', 'produk'));
    }

    public function viewRegister()
    {
        if (Auth::check()) {
            return redirect('/home');
        } else {
            return view('register');
        }
    }

    public function viewLogin()
    {
        if (Auth::check()) {
            return redirect('/home');
        } else {
            return view('login');
        }
    }

    public function home()
    {
        $produk = Produk::all();
        $categories = Category::all();
        return view('user.home', compact('produk', 'categories'));
    }

    public function pemesanan()
    {
        $pemesanan = Pemesanan::where('idUser', Auth::id())->get();
        return view('user.pemesanan', compact('pemesanan'));
    }

    public function keranjang()
    {
        $idUser = Auth::id();
        $items = Keranjang::with('produk')->where('idUser', $idUser)->get();
        $total = $items->sum(function ($item) {
            return $item->produk->harga * $item->jumlah;
        });
        return view('user.keranjang', compact('items', 'total'));
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function listProduk()
    {
        $produk = Produk::with('category')->get();
        return view('admin.list.listProduk', compact('produk'));
    }

    public function viewCreateProduk()
    {
        $categories = Category::all();
        return view('admin.create.createProduk', compact('categories'));
    }

    public function viewEditProduk($id)
    {
        $produk = Produk::findOrFail($id);
        $categories = Category::all();
        return view('admin.edit.editProduk', compact('produk', 'categories'));
    }

    public function listUser()
    {
        $users = User::all();
        return view('admin.list.listUser', compact('users'));
    }

    public function viewEditUser($id)
    {
        $users = User::findOrFail($id);
        return view('admin.edit.editUser', compact('users'));
    }

    public function listCategory()
    {
        $categories = Category::all();
        return view('admin.list.listCategory', compact('categories'));
    }

    public function viewCreateCategory()
    {
        return view('admin.create.createCategory');
    }

    public function viewEditCategory($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.edit.editCategory', compact('category'));
    }

    public function listTransaksi()
    {
        $pemesanan = Pemesanan::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.list.listTransaksi', compact('pemesanan'));
    }
}
