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
        Schema::create('anggarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('program_kerjas')->onDelete('cascade');
            $table->decimal('amount');
            $table->enum('type', ['income', 'expense']); // Pemasukan atau Pengeluaran [cite: 31]
            $table->string('description');
            $table->string('receipt_path')->nullable(); // Simpan bukti nota [cite: 31]
            $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggarans');
    }
};
