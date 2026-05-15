<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Try to find user by email
        $user = User::where('member_email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user);
            return redirect()->route('index')->with('success', 'Login berhasil!');
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }

    /**
     * Show register form
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle register
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,member_email',
            'password' => 'required|min:6|confirmed',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
        ]);

$id = mt_rand(100000000, 999999999);
while (User::where('id_member', $id)->exists()) {
    $id = mt_rand(100000000, 999999999);
}

        $user = User::create([
            'id_member' => $id,
            'name' => $request->name,
            'member_name' => $request->name,
            'member_email' => $request->email,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'member_city' => $request->city,
            'member_country' => $request->country,
            'member_gr_count' => 0,
            'member_ev_count' => 0,
        ]);

        Auth::login($user);
        return redirect()->route('index')->with('success', 'Registrasi berhasil!');
    }

    /**
     * Handle logout
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('index')->with('success', 'Logout berhasil!');
    }
}
