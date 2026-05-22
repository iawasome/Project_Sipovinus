<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use App\Models\ProgramKerja;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    public function index(Request $request)
    {
        // 1. Pemasukan Utama otomatis dihitung dari Total Estimasi Anggaran (budget_estimate) semua Proker
        $total_pemasukan = ProgramKerja::sum('budget_estimate');

        // 2. Pengeluaran riil tetap dihitung dari akumulasi transaksi 'expense' di tabel anggaran
        $total_pengeluaran = Anggaran::where('type', 'expense')->sum('amount');

        // 3. Sisa Saldo Kas Utama Organisasi
        $sisa_saldo = $total_pemasukan - $total_pengeluaran;

        // Ringkasan pengeluaran per proker dari tabel anggaran
        $anggaranAgg = Anggaran::select('program_id')
            ->selectRaw("SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) as total_expense")
            ->groupBy('program_id')
            ->get()
            ->keyBy('program_id');

        // 4. Bangun laporan gabungan dengan menyuntikkan data budget_estimate asli proker
        $laporan_per_proker = ProgramKerja::with('division')
            ->get()
            ->map(function (ProgramKerja $program) use ($anggaranAgg) {
                $agg = $anggaranAgg->get($program->id);

                // Dana dialokasikan langsung mengambil data rancangan 'budget_estimate' dari proker terkait
                $dana_dialokasikan = (float) ($program->budget_estimate ?? 0);
                $total_expense = (float) ($agg->total_expense ?? 0);

                return [
                    'program_id' => $program->id,
                    'nama_proker' => $program->name,
                    'divisi' => $program->division?->name,
                    'dana_dialokasikan' => $dana_dialokasikan, // Ambil dari budget_estimate proker
                    'dana_terpakai' => $total_expense,         // Ambil dari pengeluaran riil anggaran
                    'sisa_dana_proker' => $dana_dialokasikan - $total_expense, // Hasil pasti bersih/positif di awal
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
