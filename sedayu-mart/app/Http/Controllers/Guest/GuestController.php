<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function beranda()
    {
        return view('guest.index');
    }

    public function produk()
    {
        return view('guest.produk.index');
    }

    public function tentang()
    {
        return view('guest.tentang.index');
    }

    public function kontak()
    {
        return view('guest.kontak.index');
    }
}
