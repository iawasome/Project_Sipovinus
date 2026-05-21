<?php

namespace App\Http\Controllers;

use App\Models\Division;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    private function isAdmin(): bool
    {
        return auth()->check() && (int) auth()->user()->role_id === 1;
    }

    private function authorizeAdmin(): void
    {
        abort_unless($this->isAdmin(), 403, 'Unauthorized');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $divisions = Division::orderByDesc('id')->paginate(10);
        $isAdmin = $this->isAdmin();

        return view('pages.divisi.index', [
            'title' => 'Manajemen Divisi',
            'divisions' => $divisions,
            'isAdmin' => $isAdmin,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorizeAdmin();

        return view('pages.divisi.create', [
            'title' => 'Tambah Divisi',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        Division::create([
            'name' => $validated['name'],
        ]);

        return redirect()
            ->route('manajemen-divisi.index')
            ->with('success', 'Divisi berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->authorizeAdmin();

        $division = Division::findOrFail($id);

        return view('pages.divisi.edit', [
            'title' => 'Edit Divisi',
            'division' => $division,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorizeAdmin();

        $division = Division::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $division->update([
            'name' => $validated['name'],
        ]);

        return redirect()
            ->route('manajemen-divisi.index')
            ->with('success', 'Divisi berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorizeAdmin();

        $division = Division::findOrFail($id);
        $division->delete();

        return redirect()
            ->route('manajemen-divisi.index')
            ->with('success', 'Divisi berhasil dihapus');
    }
}

