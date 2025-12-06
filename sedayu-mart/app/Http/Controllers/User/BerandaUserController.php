<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BerandaUserController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (Auth::user()->role !== 'user') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        return view('user.beranda.index', [
            'user' => $user,
        ]);
    }
}
