<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use App\Models\ProgramKerja;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Ringkasan Keuangan Organisasi
        |--------------------------------------------------------------------------
        */

        // Dana dialokasikan berasal dari total budget seluruh program kerja
        $total_pemasukan = ProgramKerja::sum('budget_estimate');

        // Pengeluaran riil dari seluruh transaksi expense
        $total_pengeluaran = Anggaran::where('type', 'expense')->sum('amount');

        // Saldo organisasi
        $sisa_saldo = $total_pemasukan - $total_pengeluaran;

        /*
        |--------------------------------------------------------------------------
        | Data Per Program Kerja
        |--------------------------------------------------------------------------
        */

        $laporan_per_proker = ProgramKerja::with([
            'division',
            'anggarans'
        ])
        ->get()
        ->map(function (ProgramKerja $program) {

            $totalIncome = $program->anggarans
                ->where('type', 'income')
                ->sum('amount');

            $totalExpense = $program->anggarans
                ->where('type', 'expense')
                ->sum('amount');

            return [

                'program_id' => $program->id,

                'nama_proker' => $program->name,

                'divisi' => $program->division?->name,

                'dana_dialokasikan' => (float) $program->budget_estimate,

                'dana_terpakai' => $totalExpense,

                'sisa_dana_proker' => (float) $program->budget_estimate - $totalExpense,

                /*
                |--------------------------------------------------------------------------
                | Ringkasan Detail
                |--------------------------------------------------------------------------
                */

                'total_income' => $totalIncome,

                'total_expense' => $totalExpense,

                /*
                |--------------------------------------------------------------------------
                | Transaksi Dipisahkan
                |--------------------------------------------------------------------------
                */

                'transaksi' => [

                    'income' => $program->anggarans
                        ->where('type', 'income')
                        ->sortByDesc('created_at')
                        ->values()
                        ->map(function ($item) {

                            return [

                                'id' => $item->id,

                                'tanggal' => optional($item->created_at)
                                    ->format('d M Y'),

                                'description' => $item->description,

                                'amount' => $item->amount,

                                'receipt_path' => $item->receipt_path,

                            ];

                        }),

                    'expense' => $program->anggarans
                        ->where('type', 'expense')
                        ->sortByDesc('created_at')
                        ->values()
                        ->map(function ($item) {

                            return [

                                'id' => $item->id,

                                'tanggal' => optional($item->created_at)
                                    ->format('d M Y'),

                                'description' => $item->description,

                                'amount' => $item->amount,

                                'receipt_path' => $item->receipt_path,

                            ];

                        }),

                ],

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
