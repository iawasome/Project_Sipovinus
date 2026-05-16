<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('anggarans', function (Blueprint $table) {
            // Perbaikan: sebelumnya amount didefinisikan tanpa precision/scale,
            // sehingga MySQL bisa memakai definisi yang terlalu sempit (bisa error out-of-range).
            $table->decimal('amount', 15, 2)->change();
        });
    }

    public function down(): void
    {
        Schema::table('anggarans', function (Blueprint $table) {
            // Kembali ke definisi lama (tanpa precision/scale).
            // Catatan: ini mengikuti migration awal.
            $table->decimal('amount')->change();
        });
    }
};

