<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';

    protected $fillable = [
        'nama',
        'satuan_produk',
        'deskripsi',
    ];

    public function varians()
    {
        return $this->hasMany(Varian::class, 'produk_id');
    }

    public function gambarProduks()
    {
        return $this->hasMany(GambarProduk::class, 'produk_id');
    }

    public function gambarUtama()
    {
        return $this->hasOne(GambarProduk::class, 'produk_id')->where('utama', true);
    }

    public function keranjang()
    {
        return $this->hasMany(Keranjang::class, 'produk_id');
    }

    public function itemPesanan()
    {
        return $this->hasMany(ItemPesanan::class, 'produk_id');
    }
}
