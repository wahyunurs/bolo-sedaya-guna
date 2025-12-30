<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Varian extends Model
{
    protected $table = 'varian';

    protected $fillable = [
        'produk_id',
        'gambar',
        'nama',
        'harga',
        'berat',
        'stok',
        'is_default',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
