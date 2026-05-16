<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Backfill agar data lama tidak menghasilkan null di UI baru.
        // - nama_task: task_name lama
        // - status: dari is_completed lama
        // - anggaran_digunakan: default 0 (dibiarkan jika sudah ada nilai)

        DB::table('tasks')
            ->whereNull('nama_task')
            ->update(['nama_task' => DB::raw('task_name')]);

        DB::table('tasks')
            ->whereNotNull('is_completed')
            ->update(['status' => DB::raw("CASE WHEN is_completed = 1 THEN 'completed' ELSE 'pending' END")]);

        // pastikan anggaran_digunakan minimal 0
        DB::table('tasks')
            ->whereNull('anggaran_digunakan')
            ->update(['anggaran_digunakan' => 0]);
    }

    public function down(): void
    {
        // tidak dirollback karena semantik data.
    }
};

