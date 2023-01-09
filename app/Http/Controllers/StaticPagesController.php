<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class StaticPagesController extends Controller
{
    public function home(User $user)
    {
        return view('static_pages/home', compact('user'));
    }

    public function help(User $user)
    {
        return view('static_pages/help', compact('user'));
    }

    public function about(User $user)
    {
        return view('static_pages/about', compact('user'));
    }
}
