<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfilAdminController extends Controller
{
    public function index()
    {
        return view('admin.profil.index', [
            'title' => 'Profil Admin',
        ]);
    }
}
