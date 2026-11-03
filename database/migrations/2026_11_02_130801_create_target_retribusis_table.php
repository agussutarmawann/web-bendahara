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
        Schema::create('target_retribusis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('objek_retribusi_id')->constrained('objek_retribusis')->onDelete('cascade');
            $table->integer('tahun');
            $table->integer('bulan');
            $table->decimal('nominal_target', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('target_retribusis');
    }
};
