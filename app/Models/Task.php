<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\ProgramKerja;
use App\Models\User;

class Task extends Model
{
    protected $fillable = [
        'program_id',
        'user_id',
        'task_name',
        'nama_task',
        'due_date',
        'status',
        'anggaran_digunakan',
        'is_completed',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'anggaran_digunakan' => 'decimal:2',
    ];

    public function program()
    {
        return $this->belongsTo(ProgramKerja::class, 'program_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function anggarans()
    {
        return $this->hasMany(Anggaran::class, 'task_id');
    }
}


