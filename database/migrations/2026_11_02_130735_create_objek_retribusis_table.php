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
        Schema::create('objek_retribusis', function (Blueprint $table) {
            $table->id();
            $table->string('kategori'); // RETRIBUSI PELAYANAN PERSAMPAHAN /KEBERSIHAN atau RETRIBUSI PEMANFAATAN ASET DAERAH
            $table->string('nama_objek'); // Contoh: PKS PERUMDA TIRTA HITA KAB BULELENG
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('objek_retribusis');
    }
};
