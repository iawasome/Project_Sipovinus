<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('anggarans', function (Blueprint $table) {
            $table->foreignId('task_id')
                ->nullable()
                ->after('program_id')
                ->constrained('tasks')
                ->onDelete('cascade');

            // indeks membantu lookup anggaran per task
            $table->index(['task_id']);
        });
    }

    public function down(): void
    {
        Schema::table('anggarans', function (Blueprint $table) {
            // Hati-hati: drop foreignId butuh nama constraint otomatis dari Laravel.
            // Laravel akan menangani selama migrations rollback.
            $table->dropColumn('task_id');
        });
    }
};

