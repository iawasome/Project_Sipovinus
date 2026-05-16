<?php

namespace App\Http\Controllers;

use App\Models\ProgramKerja;
use App\Models\Division;
use App\Models\Anggaran;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class ProgramKerjaController extends Controller
{
    // 1. Menampilkan daftar proker (Sekarang dengan perhitungan progres)
    public function index()
    {
        $prokers = ProgramKerja::with('division', 'tasks')->get();
        return view('program_kerja.index', compact('prokers'));
    }

    public function show($program_kerja)
    {
        $programKerja = ProgramKerja::with(['division', 'tasks.user', 'anggarans'])->findOrFail($program_kerja);

        return view('program_kerja.show', compact('programKerja'));
    }


    // 2. Fungsi untuk menyimpan proker baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'division_id' => 'required|exists:divisions,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'budget_estimate' => 'required|numeric',
        ]);

        ProgramKerja::create($validated);

        return redirect()->route('program-kerja.index')->with('success', 'Program Kerja berhasil ditambahkan!');
    }

    // 3. Fungsi khusus untuk simpan Anggaran (Validasi agar tidak minus)
    public function storeAnggaran(Request $request)
{
    $request->validate([
        'program_id' => 'required|exists:program_kerjas,id',
        'amount' => 'required|numeric',
        'type' => 'required|in:income,expense',
        'description' => 'required|string',
        'receipt_path' => 'nullable|image|mimes:jpg,png,jpeg|max:2048', // Validasi file gambar max 2MB
    ]);

    $data = $request->all();

    // Logika Simpan File
    if ($request->hasFile('receipt_path')) {
        // Simpan file ke folder 'storage/app/public/receipts'
        $filePath = $request->file('receipt_path')->store('receipts', 'public');
        $data['receipt_path'] = $filePath;
    }

    // Cek saldo jika tipenya pengeluaran (seperti logika sebelumnya)
    if ($request->type == 'expense') {
        $saldo = $this->getRemainingBudget($request->program_id);
        if ($request->amount > $saldo) {
            return back()->with('error', 'Saldo tidak cukup!');
        }
    }

    \App\Models\Anggaran::create($data);

    return back()->with('success', 'Anggaran dan bukti nota berhasil disimpan!');
}

    // 4. Kalkulator sisa saldo (Helper Function)
    public function getRemainingBudget($programId)
    {
        $income = Anggaran::where('program_id', $programId)->where('type', 'income')->sum('amount');
        $expense = Anggaran::where('program_id', $programId)->where('type', 'expense')->sum('amount');

        return $income - $expense;
    }

    public function exportPDF($programKerja)
    {
        $proker = ProgramKerja::with(['division', 'tasks.user', 'anggarans'])->findOrFail($programKerja);

        $pdf = Pdf::loadView('program_kerja.pdf_report', compact('proker'));

        return $pdf->download('Laporan-' . $proker->name . '.pdf');
    }



    public function destroy($id)
    {
        $user = Auth::user();

        if (!$user || $user->role_id != 1) {
            return back()->with('error', 'Hanya Admin yang bisa menghapus program kerja!');
        }

        ProgramKerja::destroy($id);

        return redirect()->route('program-kerja.index')
            ->with('success', 'Program Kerja berhasil dihapus!');
    }
}

