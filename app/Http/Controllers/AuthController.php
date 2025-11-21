<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ], [
            'login.required' => 'Login is required',
            'password.required' => 'Password is required',
        ]);

        // Try to authenticate
        if (Auth::attempt(['login' => $credentials['login'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'))->with('success', 'Welcome back!');
        }

        return back()
            ->withInput($request->only('login'))
            ->with('error', 'Invalid login credentials.');
    }

    /**
     * Show register form
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'login' => 'required|string|unique:user,login|max:50',
            'email' => 'required|email|unique:user,email|max:255',
            'name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'login' => $validated['login'],
            'email' => $validated['email'],
            'name' => $validated['name'],
            'last_name' => $validated['last_name'],
            'password_hash' => Hash::make($validated['password']),
            'isActive' => true,
            'address' => 'N/A', // Optional: Add a default address or add an input field for it
            'date_of_registration' => now(),
            'role' => 'visitor',
        ]);

        // Assign customer role
        $user->assignRole('customer');

        Auth::login($user);

        return redirect(route('dashboard'))->with('success', 'Registration successful!');
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('home'))->with('success', 'You have been logged out.');
    }
}
