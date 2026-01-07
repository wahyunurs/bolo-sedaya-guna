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
        'nomor_pesanan',
        'alamat',
        'kabupaten_tujuan',
        'ongkir',
        'subtotal_produk',
        'total_bayar',
        'rekening_id',
        'bukti_pembayaran',
        'status',
        'catatan',
        'keterangan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function rekening()
    {
        return $this->belongsTo(Rekening::class, 'rekening_id');
    }

    public function ItemPesanan()
    {
        return $this->hasMany(ItemPesanan::class, 'pesanan_id');
    }

    public function informasiPengiriman()
    {
        return $this->hasOne(InformasiPengiriman::class, 'pesanan_id');
    }
}
