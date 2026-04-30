<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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

        if (Auth::attempt($data)) {
            return redirect('/home');
        } else {
            return redirect('/login')->with('error', 'Nomor telepon atau password salah.');
        }
    }

    public function signOut() 
    {
        Auth::logout();
        return redirect('/login/view')->with('success', 'Anda berhasil keluar.');
    }
}
