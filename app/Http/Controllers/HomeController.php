<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function admin()
    {
        return view('admin.home');
    }

    public function user()
    {
        return view('user.home');
    }
}