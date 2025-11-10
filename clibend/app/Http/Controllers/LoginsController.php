<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginsController extends Controller
{
    public function showLoginForm()
    {
        return view('login.login');
    }
}
