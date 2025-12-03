<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TarifPengiriman extends Model
{
    use HasFactory;

    protected $table = 'tarif_pengiriman';

    protected $fillable = [
        'kabupaten',
        'tarif_per_kg',
    ];
}
