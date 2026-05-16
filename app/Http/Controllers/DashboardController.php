<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramKerja;
use App\Models\Anggaran;


class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'total_proker' => ProgramKerja::count(),
            'proker_selesai' => ProgramKerja::where('status', 'completed')->count(),
            'proker_berjalan' => ProgramKerja::where('status', 'on_progress')->count(),
            'total_anggaran_keluar' => Anggaran::where('type', 'expense')->sum('amount'),
        ];

        $prokers = ProgramKerja::with('division')
            ->latest()
            ->take(10)
            ->get();

        return view('pages.dashboard.ecommerce', ['title' => 'Dashboard', 'data' => $data, 'prokers' => $prokers]);
    }
}
