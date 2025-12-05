<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class PenggunaAdminController extends Controller
{
    public function index()
    {
        $query = User::where('role', 'user');

        // Optional search by name or email (?q=...)
        if ($q = request('q')) {
            $query->where(function ($qBuilder) use ($q) {
                $qBuilder->where('nama', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        }

        $users = $query->orderByDesc('created_at')->paginate(15)->withQueryString();

        return view('admin.pengguna.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        // Return a fragment (modal) with user data for AJAX insertion
        return view('admin.pengguna.show-modal', compact('user'));
    }
}
