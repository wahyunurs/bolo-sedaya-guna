<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPesanan extends Model
{
    use HasFactory;

    protected $table = 'item_pesanan';

    protected $fillable = [
        'pesanan_id',
        'produk_id',
        'varian_id',
        'kuantitas',
        'subtotal',
        'berat_total',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
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
