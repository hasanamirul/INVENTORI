<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role !== 'user') {
            abort(403, 'Unauthorized');
        }

        return view('user.dashboard'); // user/dashboard.blade.php
    }
}
