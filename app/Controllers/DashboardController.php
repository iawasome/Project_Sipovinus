<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProgramKerja;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
{
    // Kita bungkus pakai try-catch agar jika database kosong/error, aplikasi tidak crash dan tidak menendang user keluar!
    try {
        $data = [
            'total_proker' => class_exists(\App\Models\ProgramKerja::class) ? ProgramKerja::count() : 0,
            'proker_selesai' => class_exists(\App\Models\ProgramKerja::class) ? ProgramKerja::where('status', 'completed')->count() : 0,
            'proker_berjalan' => class_exists(\App\Models\ProgramKerja::class) ? ProgramKerja::where('status', 'on_progress')->count() : 0,
            'total_anggaran_keluar' => class_exists(\App\Models\Anggaran::class) ? \App\Models\Anggaran::where('type', 'expense')->sum('amount') : 0,
        ];
    } catch (\Exception $e) {
        // Jika tabel belum di-migrate/kosong, paksa isi angka 0 agar halaman tetap terbuka
        $data = [
            'total_proker' => 0,
            'proker_selesai' => 0,
            'proker_berjalan' => 0,
            'total_anggaran_keluar' => 0,
        ];
    }

    return view('pages.dashboard.ecommerce', ['title' => 'Dashboard', 'data' => $data]);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
