<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm() {
        return view('login');
    }

    public function showRegisterForm() {
        return view('register');
    }

    public function register(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['phone'] . '@example.com', // dummy email if required by schema
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
        ]);

        Auth::login($user);
        
        if ($user->role === 'admin') {
            return redirect()->intended('/admin/data-master');
        } elseif ($user->role === 'operator') {
            return redirect()->intended('/operator/kelolaproduksi');
        } else {
            return redirect()->intended('/user/buat-pesanan');
        }
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'phone' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->intended('/admin/data-master');
            } elseif ($user->role === 'operator') {
                return redirect()->intended('/operator/kelolaproduksi');
            } else {
                return redirect()->intended('/user/buat-pesanan');
            }
        }

        return back()->withErrors([
            'phone' => 'No HP atau password salah.',
        ])->onlyInput('phone');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
