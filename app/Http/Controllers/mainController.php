<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return view('user.home');
    }

    public function history() {
        return view('user.history');
    }

    public function keranjang() {
        return view('user.keranjang');
    }

    public function dashboard() {
        return view('admin.dashboard');
    }

    public function viewCreateProduk() {
        return view('admin.createProduk');
    }
}
