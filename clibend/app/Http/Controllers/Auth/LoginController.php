<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Validate the request
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Attempt to find the user
        $user = User::where('email', $credentials['email'])->first();

        // Check if user exists and password is correct
        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user);

            // Redirect based on role
            switch ($user->role) {
                case 'end-user':
                    return redirect('/user');
                case 'proposer':
                    return redirect('/proposer');
                case 'admin':
                    return redirect('/admin');
                default:
                    return redirect('/'); // fallback
            }
        }

        // If login fails
        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->onlyInput('email');
    }
}
