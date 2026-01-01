<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

    protected $table = 'keranjang';

    protected $fillable = [
        'user_id',
        'produk_id',
        'varian_id',
        'kuantitas',
        'subtotal',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    public function varian()
    {
        return $this->belongsTo(Varian::class, 'varian_id');
    }
}
