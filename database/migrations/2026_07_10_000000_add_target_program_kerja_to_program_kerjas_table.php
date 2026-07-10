<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('program_kerjas', function (Blueprint $table) {
            $table->string('target_program_kerja', 255)
                  ->default('')
                  ->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('program_kerjas', function (Blueprint $table) {
            $table->dropColumn('target_program_kerja');
        });
    }
};
