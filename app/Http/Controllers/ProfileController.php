<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the password.
     */
    public function editPassword()
    {
        $user = Auth::user();
        
        // Determine the layout based on the user's role
        $layout = 'layouts.user'; // default
        if ($user->role === 'admin') {
            $layout = 'layouts.admin';
        } elseif ($user->role === 'operator') {
            $layout = 'layouts.operator';
        }

        return view('auth.change-password', compact('layout'));
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'Password saat ini salah.',
            ]);
        }

        $user->forceFill([
            'password' => Hash::make($request->password),
        ])->save();

        return back()->with('success', 'Password berhasil diubah.');
    }
}
