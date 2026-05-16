<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $roles = [
        ['name' => 'Admin'],
        ['name' => 'Ketua Umum'],
        ['name' => 'Sekretaris'],
        ['name' => 'Bendahara'],
        ['name' => 'Kepala Bidang'],
        ['name' => 'Anggota'],
    ];

    foreach ($roles as $role) {
        \App\Models\Role::create($role);
    }
}
}
