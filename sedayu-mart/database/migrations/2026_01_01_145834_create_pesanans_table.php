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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('alamat');
            $table->string('kabupaten_tujuan'); // untuk lookup tarif
            $table->integer('ongkir'); // rupiah
            $table->integer('subtotal_produk'); // total harga barang tanpa ongkir
            $table->integer('total_bayar'); // subtotal_produk + ongkir
            $table->foreignId('rekening_id')->constrained('rekening')->onDelete('cascade'); // rekening tujuan pembayaran
            $table->string('bukti_pembayaran')->nullable(); // path ke file bukti pembayaran
            $table->enum('status', [
                'Menunggu Verifikasi',
                'Ditolak',
                'Diterima',
                'Dalam Pengiriman',
                'Selesai'
            ])->default('Menunggu Verifikasi');
            $table->text('catatan')->nullable(); // catatan tambahan dari pembeli
            $table->text('keterangan')->nullable(); // alasan penolakan dari admin
            $table->boolean('dihapus')->default(false);  // menandai item yang dihapus setelah pemesanan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
