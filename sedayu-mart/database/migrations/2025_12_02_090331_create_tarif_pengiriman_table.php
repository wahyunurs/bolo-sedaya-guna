<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tarif_pengiriman', function (Blueprint $table) {
            $table->id();
            $table->string('kabupaten'); // nama kabupaten/kota tujuan (mis. "Kota Semarang", "Kab. Sukoharjo")
            $table->integer('tarif_per_kg'); // tarif per kg (Rupiah)
            $table->timestamps();

            $table->unique('kabupaten');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarif_pengiriman');
    }
};
