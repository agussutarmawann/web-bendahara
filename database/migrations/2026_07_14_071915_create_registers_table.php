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
        Schema::create('registers', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('wajib_retribusi');
            $table->string('kategori');
            $table->string('nomor_stbp')->nullable(); // Untuk mencatat otomatis nomor STS jika sudah disetor
            // Jenis: 'penetapan' (dengan SKP/ketetapan) atau 'tanpa_penetapan' (langsung bayar)
            $table->enum('jenis_penetapan', ['penetapan','tanpa_penetapan'])->default('tanpa_penetapan');
            $table->decimal('jumlah', 15, 2);// Nominal uang (maksimal 15 digit, 2 angka di belakang koma)
            $table->string('nomor_sts_link')->nullable(); // Untuk mencatat otomatis nomor STS jika sudah disetor
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registers');
    }
};
