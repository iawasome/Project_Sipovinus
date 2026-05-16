<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\ProgramKerja;

class Anggaran extends Model
{
    protected $fillable = [
        'program_id',
        'task_id',
        'amount',
        'type',
        'description',
        'receipt_path',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function program()
    {
        return $this->belongsTo(ProgramKerja::class, 'program_id');
    }

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }
}


