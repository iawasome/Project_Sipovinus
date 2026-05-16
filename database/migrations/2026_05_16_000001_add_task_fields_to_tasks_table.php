<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->string('nama_task')->nullable()->after('task_name');
            $table->enum('status', ['pending', 'on_progress', 'completed'])->default('pending')->after('due_date');
            $table->decimal('anggaran_digunakan', 15, 2)->default(0)->after('status');

            // Jika sistem lama masih memakai kolom ini, biarkan tetap ada.
            // Nantinya UI/controller akan memakai kolom baru.
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn(['nama_task', 'status', 'anggaran_digunakan']);
        });
    }
};

