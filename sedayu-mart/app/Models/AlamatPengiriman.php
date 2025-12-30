<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlamatPengiriman extends Model
{
    protected $table = 'alamat_pengiriman';

    protected $fillable = [
        'user_id',
        'nama_penerima',
        'nomor_telepon',
        'alamat',
        'kabupaten',
        'provinsi',
        'kode_pos',
        'keterangan',
        'is_default',
    ];

    // Relasi dengan User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
