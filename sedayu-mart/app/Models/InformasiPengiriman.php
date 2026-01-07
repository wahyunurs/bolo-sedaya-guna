<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformasiPengiriman extends Model
{
    protected $table = 'informasi_pengiriman';

    protected $fillable = [
        'pesanan_id',
        'nomor_pengiriman',
        'nama_ekspedisi',
        'estimasi_tiba_mulai',
        'estimasi_tiba_selesai',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
    }
}
