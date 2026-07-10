<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramKerja extends Model
{
    protected $fillable = [
        'division_id',
        'name',
        'description',
        'start_date',
        'end_date',
        'status',
        'budget_estimate',
        'target_program_kerja',
    ];

    // Catatan: kolom progress belum ada di tabel `program_kerjas` (sesuai migration).

    // Relasi: Satu proker milik satu divisi
    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'program_id');
    }

    public function anggarans()
    {
        return $this->hasMany(Anggaran::class, 'program_id');
    }

    public function getProgressAttribute()
    {
        // Mengambil total tugas untuk proker ini
        $totalTasks = $this->tasks()->count();

        // Jika tidak ada tugas, progres dianggap 0%
        if ($totalTasks === 0) {
            return 0;
        }

        // Mengambil jumlah tugas yang sudah dicentang (is_completed = true)
        $completedTasks = $this->tasks()->where('is_completed', true)->count();

        // Menghitung persentase: (tugas_selesai / total_tugas) * 100
        return round(($completedTasks / $totalTasks) * 100);
    }

    /**
     * Menentukan status proker secara otomatis berdasarkan tanggal.
     */
    public function getAutoStatusAttribute()
    {
        $today = now()->toDateString();

        if ($today < $this->start_date) {
            return 'Pending';
        } elseif ($today >= $this->start_date && $today <= $this->end_date) {
            return 'On Progress';
        }

        return 'Completed';
    }
}

