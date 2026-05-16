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
    Schema::create('program_kerjas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('division_id')->constrained('divisions'); // Penanggung jawab divisi
        $table->string('name');
        $table->text('description')->nullable();
        $table->date('start_date');
        $table->date('end_date');
        $table->enum('status', ['pending', 'on_progress', 'completed'])->default('pending');
        $table->decimal('budget_estimate', 15, 2);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_kerjas');
    }
};
