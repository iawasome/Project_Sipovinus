<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    // Menentukan nama tabel (opsional jika nama tabel sudah sesuai standar Laravel)
    protected $table = 'divisions';

    // Kolom yang boleh diisi
    protected $fillable = [
        'name',
    ];

    /**
     * Relasi: Satu Divisi memiliki banyak Program Kerja.
     */
    public function programKerjas()
    {
        return $this->hasMany(ProgramKerja::class, 'division_id');
    }

    /**
     * Relasi: Satu Divisi memiliki banyak Anggota (Users).
     */
    public function users()
    {
        return $this->hasMany(User::class, 'division_id');
    }
}
