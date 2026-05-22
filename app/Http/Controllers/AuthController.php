<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('pages.auth.signin', ['title' => 'Sign In']);
    }

    public function showRegister()
    {
        return view('pages.auth.signup', ['title' => 'Sign Up']);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role_id' => ['required', 'integer'],
            'division_id' => ['required', 'integer'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $validated['role_id'],
            'division_id' => $validated['division_id'],
        ]);

        Auth::login($user);

        // Paksa langsung masuk ke halaman utama dashboard setelah registrasi
        return redirect('/dashboard')->with('success', 'Account created successfully.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->withInput($request->except('password'));
        }

        $request->session()->regenerate();

        // Paksa langsung masuk ke halaman dashboard agar tidak memantul ke route '/'
        return redirect('/dashboard')->with('success', 'Welcome back!');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/signin');
    }
}
