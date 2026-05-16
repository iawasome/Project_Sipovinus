<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use App\Models\ProgramKerja;
use Illuminate\Http\Request;


class KeuanganController extends Controller
{
    public function index(Request $request)
    {

        // Total keseluruhan
        $total_pemasukan = Anggaran::where('type', 'income')->sum('amount');
        $total_pengeluaran = Anggaran::where('type', 'expense')->sum('amount');
        $sisa_saldo = $total_pemasukan - $total_pengeluaran;

        // Ringkasan per proker
        // Mengambil agregat income/expense untuk tiap program_kerja (program)
        $anggaranAgg = Anggaran::select('program_id')
            ->selectRaw("SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) as total_income")
            ->selectRaw("SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) as total_expense")
            ->groupBy('program_id')
            ->get()
            ->keyBy('program_id');

        $laporan_per_proker = ProgramKerja::with('division')
            ->get()
            ->map(function (ProgramKerja $program) use ($anggaranAgg) {
                $agg = $anggaranAgg->get($program->id);

                $total_income = (float) ($agg->total_income ?? 0);
                $total_expense = (float) ($agg->total_expense ?? 0);

                return [
                    'program_id' => $program->id,
                    'nama_proker' => $program->name,
                    'divisi' => $program->division?->name,
                    'dana_dialokasikan' => $total_income,
                    'dana_terpakai' => $total_expense,
                    'sisa_dana_proker' => $total_income - $total_expense,
                ];
            })
            ->values();

        return view('pages.laporan-keuangan', [
            'title' => 'Laporan Keuangan',
            'total_pemasukan' => $total_pemasukan,
            'total_pengeluaran' => $total_pengeluaran,
            'sisa_saldo' => $sisa_saldo,
            'laporan_per_proker' => $laporan_per_proker,
        ]);
    }
}

