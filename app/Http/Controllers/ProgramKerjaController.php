<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use App\Models\ProgramKerja;
use App\Models\Task;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProgramKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prokers = ProgramKerja::with('division')->paginate(10);
        return view('pages.program-kerja.index', ['title' => 'Daftar Program Kerja', 'prokers' => $prokers]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $divisions = \App\Models\Division::all();

        return view('pages.program-kerja.create', [
            'title' => 'Tambah Program Kerja',
            'divisions' => $divisions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'division_id' => ['required', 'integer'],
            'status' => ['required', 'string', 'max:50'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'budget_estimate' => ['required', 'numeric', 'min:0'],
        ]);

        ProgramKerja::create([
            'name' => $validated['name'],
            'division_id' => $validated['division_id'],
            'status' => strtolower($validated['status']),
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'budget_estimate' => $validated['budget_estimate'],
        ]);

        return redirect()->route('program-kerja.index')->with('success', 'Program Kerja berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Eager-load tasks dan anggarans
        $proker = ProgramKerja::with('division', 'tasks', 'anggarans')->findOrFail($id);

        $dana_dialokasikan = (float) $proker->budget_estimate;

        $dana_terpakai = (float) $proker
            ->anggarans
            ->where('type', 'expense')
            ->sum('amount');

        $sisa_dana = $dana_dialokasikan - $dana_terpakai;

        return view('pages.program-kerja.show', [
            'title' => 'Detail Program Kerja',
            'proker' => $proker,
            'tasks' => $proker->tasks->sortByDesc('created_at'),
            'dana_dialokasikan' => $dana_dialokasikan,
            'dana_terpakai' => $dana_terpakai,
            'sisa_dana' => $sisa_dana,
        ]);
    }

    public function storeTask(Request $request, string $prokerId)
    {
        $validated = $request->validate([
            'nama_task' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:pending,on_progress,completed'],
            'due_date' => ['nullable', 'date'],
            'anggaran_digunakan' => ['required', 'numeric', 'min:0'],
        ]);


        $proker = ProgramKerja::findOrFail($prokerId);

        return DB::transaction(function () use ($validated, $proker, $request) {
            $task = Task::create([
                'program_id' => $proker->id,
                'user_id' => $request->user()?->id,
                // task_name adalah kolom wajib dari skema lama
                'task_name' => $validated['nama_task'],
                'nama_task' => $validated['nama_task'],
                // status kolom baru
                'status' => $validated['status'],
                'anggaran_digunakan' => $validated['anggaran_digunakan'],
                // due_date wajib pada skema lama, tapi sekarang nullable. Ambil dari form.
                'due_date' => $validated['due_date'] ?? now()->toDateString(),
                // is_completed kolom lama (tidak dipakai UI baru), set aman
                'is_completed' => $validated['status'] === 'completed',
            ]);




            // expense untuk task
            Anggaran::create([
                'program_id' => $proker->id,
                'task_id' => $task->id,
                'amount' => $validated['anggaran_digunakan'],
                'type' => 'expense',
                'description' => 'Expense Task: ' . $task->nama_task,
            ]);

            return redirect()
                ->route('program-kerja.show', $proker->id)
                ->with('success', 'Task berhasil ditambahkan beserta anggarannya');
        });
    }

    public function updateTask(Request $request, string $id)
    {
        $validated = $request->validate([
            'nama_task' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:pending,on_progress,completed'],
            'due_date' => ['nullable', 'date'],
            'anggaran_digunakan' => ['required', 'numeric', 'min:0'],
        ]);


        $task = Task::with('program')->findOrFail($id);
        $prokerId = $task->program_id;

        return DB::transaction(function () use ($task, $validated, $prokerId) {
            $task->update([
                'nama_task' => $validated['nama_task'],
                'status' => $validated['status'],
                'anggaran_digunakan' => $validated['anggaran_digunakan'],
                'due_date' => $validated['due_date'] ?? null,
                'is_completed' => $validated['status'] === 'completed',
            ]);


            $anggaran = Anggaran::where('task_id', $task->id)
                ->where('type', 'expense')
                ->first();

            if (!$anggaran) {
                // Defensive: jika baris anggaran tidak ada, buat ulang
                Anggaran::create([
                    'program_id' => $prokerId,
                    'task_id' => $task->id,
                    'amount' => $validated['anggaran_digunakan'],
                    'type' => 'expense',
                    'description' => 'Expense Task: ' . $task->nama_task,
                ]);
            } else {
                $anggaran->update([
                    'amount' => $validated['anggaran_digunakan'],
                    'description' => 'Expense Task: ' . $task->nama_task,
                ]);
            }

            return redirect()
                ->route('program-kerja.show', $prokerId)
                ->with('success', 'Task dan anggarannya berhasil diupdate');
        });
    }

    public function destroyTask(string $id)
    {
        $task = Task::findOrFail($id);
        $prokerId = $task->program_id;

        $task->delete(); // cascade on anggarans.task_id

        return redirect()
            ->route('program-kerja.show', $prokerId)
            ->with('success', 'Task berhasil dihapus');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $proker = ProgramKerja::findOrFail($id);
        return view('pages.program-kerja.edit', ['title' => 'Edit Program Kerja', 'proker' => $proker]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // belum diimplementasi
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $proker = ProgramKerja::findOrFail($id);
        $proker->delete();
        return redirect()->route('program-kerja.index')->with('success', 'Program Kerja berhasil dihapus');
    }

    /**
     * Export to PDF
     */
    public function exportPdf(string $id)
    {
        $proker = ProgramKerja::with('division', 'tasks', 'anggarans')->findOrFail($id);

        $tasks = $proker->tasks;
        $anggarans = $proker->anggarans;

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pages.program-kerja.pdf.proker', [
            'title' => 'Laporan Program Kerja',
            'proker' => $proker,
            'tasks' => $tasks,
            'anggarans' => $anggarans,
        ]);

        $filename = 'sipovinus-program-kerja-' . $proker->id . '.pdf';

        return $pdf->download($filename);
    }
}

