<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $divisions = [
        ['name' => 'Pengurus Inti'],
        ['name' => 'PSDM (Pengembangan Sumber Daya Mahasiswa)'],
        ['name' => 'Humas (Hubungan Masyarakat)'],
        ['name' => 'Kominfo (Komunikasi dan Informasi)'],
        ['name' => 'Minat dan Bakat'],
        ['name' => 'Kewirausahaan'],
    ];

    foreach ($divisions as $division) {
        \App\Models\Division::create($division);
    }
}
}
