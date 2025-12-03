<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';

    protected $fillable = [
        'user_id',
        'alamat',
        'kabupaten_tujuan',
        'ongkir',
        'subtotal_produk',
        'total_bayar',
        'bukti_pembayaran',
        'status',
        'catatan',
        'keterangan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items()
    {
        return $this->hasMany(ItemPesanan::class, 'pesanan_id');
    }
}
