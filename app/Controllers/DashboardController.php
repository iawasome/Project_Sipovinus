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
    $data = [
        'total_proker' => ProgramKerja::count(),
        'proker_selesai' => ProgramKerja::where('status', 'completed')->count(),
        'proker_berjalan' => ProgramKerja::where('status', 'on_progress')->count(),
        'total_anggaran_keluar' => \App\Models\Anggaran::where('type', 'expense')->sum('amount'),
    ];

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
