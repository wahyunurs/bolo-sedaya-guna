<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardUserController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('user.dashboard.index', [
            'title' => 'Dashboard User',
            'user' => $user,
        ]);
    }
}
