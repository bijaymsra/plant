<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller; 

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
            'role' => 'required|in:end-user,proposer,admin',
            'terms' => 'accepted',
        ]);

        \Log::info('Storing user:', $validated); // 🔍 debugging

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        // return redirect('/login')->with('success', 'Registration successful!');
        return redirect()->back()->with('registration_success', true);

    }
}
