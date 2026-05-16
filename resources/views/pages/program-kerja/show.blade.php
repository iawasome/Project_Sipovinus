@extends('layouts.app')

@section('content')
<div class="rounded-2xl border border-stroke bg-white p-4 dark:border-strokedark dark:bg-boxdark text-black dark:text-white">
    <div class="flex flex-col gap-4">
        {{-- Header + Export PDF --}}
        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black dark:text-white">Detail Proker</h1>
                <p class="text-sm text-gray-600 dark:text-gray-300">{{ $title ?? 'Program Kerja' }}</p>
            </div>

            <div class="flex gap-2">
                <a
                    href="{{ route('program-kerja.export-pdf', $proker->id) }}"
                    class="inline-flex items-center justify-center rounded px-4 py-2 bg-primary text-white hover:opacity-95 transition"
                >
                    Export PDF
                </a>
            </div>
        </div>

        {{-- Section Detail Proker --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- Card 1: Informasi Utama --}}
            <div class="rounded-xl border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="p-4">
                    <p class="text-sm text-gray-600 dark:text-gray-300">Nama</p>
                    <p class="mt-1 text-lg font-bold text-black dark:text-white">{{ $proker->name }}</p>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Divisi: {{ $proker->division?->name }}</p>
                </div>
            </div>

            {{-- Card 2: Dana Awal --}}
            <div class="rounded-xl border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="p-4">
                    <p class="text-sm text-gray-600 dark:text-gray-300">Dana Awal</p>
                    <p class="mt-1 text-lg font-semibold text-black dark:text-white">
                        Rp {{ number_format($dana_dialokasikan, 2, ',', '.') }}
                    </p>
                </div>
            </div>

            {{-- Card 3: Dana Terpakai & Sisa Dana --}}
            <div class="rounded-xl border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="p-4">
                    <p class="text-sm text-gray-600 dark:text-gray-300">Dana Terpakai</p>
                    <p class="mt-1 text-lg font-semibold text-black dark:text-white">
                        Rp {{ number_format($dana_terpakai, 2, ',', '.') }}
                    </p>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                        Sisa Dana:
                        <span class="ml-1 font-semibold text-green-700 dark:text-green-400">
                            Rp {{ number_format($sisa_dana, 2, ',', '.') }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        {{-- Section Daftar Task & Table --}}
        <div class="rounded-2xl border border-stroke bg-white dark:border-strokedark dark:bg-boxdark p-4">
            {{-- Table Header --}}
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-lg font-semibold text-black dark:text-white">Daftar Task</h2>

                <div class="sm:flex sm:items-center sm:justify-end">
                    <button
                        type="button"
                        id="btnAddTask"
                        class="inline-flex items-center justify-center rounded bg-primary px-4 py-2 text-sm font-medium text-white hover:opacity-95 transition"
                        onclick="document.getElementById('addTaskModal').classList.remove('hidden')"
                    >
                        + Tambah Task
                    </button>
                </div>
            </div>

            <div class="mt-4 overflow-x-auto">
                <table class="w-full table-auto border-collapse">
                    <thead>
                        <tr>
                            <th class="bg-gray-2 dark:bg-meta-4 text-left font-medium text-black dark:text-white px-4 py-3">Nama Task</th>
                            <th class="bg-gray-2 dark:bg-meta-4 text-left font-medium text-black dark:text-white px-4 py-3">Status</th>
                            <th class="bg-gray-2 dark:bg-meta-4 text-left font-medium text-black dark:text-white px-4 py-3">Anggaran</th>
                            <th class="bg-gray-2 dark:bg-meta-4 text-right font-medium text-black dark:text-white px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tasks as $task)
                            @php
                                $status = $task->status;
                                $badgeBase = 'inline-flex rounded-full bg-opacity-10 py-1 px-3 text-sm font-medium';
                                // Status colors that remain readable in both light/dark.
                                $badgeClass = match($status) {
                                    'completed' => 'bg-green-500 text-green-700 dark:bg-green-400/20 dark:text-green-300',
                                    'on_progress' => 'bg-yellow-400 text-yellow-800 dark:bg-yellow-400/20 dark:text-yellow-200',
                                    default => 'bg-gray-400 text-gray-700 dark:bg-gray-300/15 dark:text-gray-200',
                                };
                                $anggaran = $task->anggaran_digunakan ?? 0;
                            @endphp

                            <tr class="border-t border-stroke dark:border-strokedark">
                                <td class="px-4 py-3 text-black dark:text-white">
                                    {{ $task->nama_task }}
                                </td>

                                <td class="px-4 py-3">
                                    <span class="{{ $badgeBase }} {{ $badgeClass }}">
                                        {{ $task->status }}
                                    </span>
                                </td>

                                <td class="px-4 py-3 text-right text-black dark:text-white">
                                    Rp {{ number_format($anggaran, 2, ',', '.') }}
                                </td>

                                <td class="px-4 py-3 text-right">
                                    <button
                                        type="button"
                                        class="inline-flex items-center justify-center rounded border border-blue-200 bg-blue-50 px-3 py-1 text-sm font-medium text-blue-700 hover:bg-blue-100 transition dark:border-blue-400/20 dark:bg-blue-400/10 dark:text-blue-200"
                                        data-modal-target="editTaskModal"
                                        data-modal-toggle="editTaskModal"
                                        data-task-id="{{ $task->id }}"
                                        data-nama="{{ $task->nama_task }}"
                                        data-status="{{ $task->status }}"
                                        data-anggaran="{{ $task->anggaran_digunakan }}"
                                    >
                                        {{-- Icon mini (pencil) --}}
                                        <svg class="mr-1 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M12 20h9"/>
                                            <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/>
                                        </svg>
                                        Edit
                                    </button>

                                    <form
                                        method="POST"
                                        action="{{ route('task.destroy', $task->id) }}"
                                        class="inline-block ml-2"
                                        onsubmit="return confirm('Hapus task ini? Anggaran terkait juga akan ikut terhapus.');"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="inline-flex items-center justify-center rounded border border-red-200 bg-red-50 px-3 py-1 text-sm font-medium text-danger hover:bg-red-100 transition dark:border-red-400/20 dark:bg-red-400/10 dark:text-red-200"
                                            type="submit"
                                        >
                                            {{-- Icon mini (trash) --}}
                                            <svg class="mr-1 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="3 6 5 6 21 6"/>
                                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                                <path d="M10 11v6"/>
                                                <path d="M14 11v6"/>
                                                <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-gray-600 dark:text-gray-300">Belum ada task.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal Add Task --}}
<div id="addTaskModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-[calc(100%)] max-h-full">
    <div class="relative p-4 w-full max-w-lg max-h-full mx-auto">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="p-4 md:p-5 border-b rounded-t border-gray-200 dark:border-gray-600">
                <h3 class="text-lg font-semibold">Tambah Task</h3>
            </div>

            <form method="POST" action="{{ route('task.store', $proker->id) }}" class="p-4 md:p-5">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium">Nama Task</label>
                        <input name="nama_task" type="text" required class="input input-bordered w-full" value="{{ old('nama_task') }}" />
                        @error('nama_task')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Status</label>
                        <select name="status" class="select select-bordered w-full" required>
                            <option value="pending" @selected(old('status')==='pending')>pending</option>
                            <option value="on_progress" @selected(old('status')==='on_progress')>on_progress</option>
                            <option value="completed" @selected(old('status')==='completed')>completed</option>
                        </select>
                        @error('status')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Due Date</label>
                        <x-form.date-picker
                            name="due_date"
                            :default-date="old('due_date')"
                            placeholder="Pilih tanggal"
                        />
                        @error('due_date')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Anggaran Digunakan</label>

                        <input name="anggaran_digunakan" type="number" step="0.01" min="0" max="999999999999.99" required class="input input-bordered w-full" value="{{ old('anggaran_digunakan') }}" />
                        @error('anggaran_digunakan')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-2">
                    <button type="button" class="btn btn-outline-secondary" data-modal-hide="addTaskModal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit Task --}}
<div id="editTaskModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-[calc(100%)] max-h-full">
    <div class="relative p-4 w-full max-w-lg max-h-full mx-auto">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="p-4 md:p-5 border-b rounded-t border-gray-200 dark:border-gray-600">
                <h3 class="text-lg font-semibold">Edit Task</h3>
            </div>

            <form id="editTaskForm" method="POST" class="p-4 md:p-5">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <input type="hidden" id="edit_task_id" name="_task_id" />

                    <div>
                        <label class="block text-sm font-medium">Nama Task</label>
                        <input id="edit_nama_task" name="nama_task" type="text" required class="input input-bordered w-full" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Status</label>
                        <select id="edit_status" name="status" class="select select-bordered w-full" required>
                            <option value="pending">pending</option>
                            <option value="on_progress">on_progress</option>
                            <option value="completed">completed</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Anggaran Digunakan</label>
                        <input id="edit_anggaran" name="anggaran_digunakan" type="number" step="0.01" min="0" required class="input input-bordered w-full" />
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-2">
                    <button type="button" class="btn btn-outline-secondary" data-modal-hide="editTaskModal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // TailAdmin/flowbite-style modal toggle umumnya butuh data attributes.
    // Kita pastikan URL form update dibentuk saat klik Edit.
    (function(){
        const form = document.getElementById('editTaskForm');
        const taskId = document.getElementById('edit_task_id');
        const nama = document.getElementById('edit_nama_task');
        const status = document.getElementById('edit_status');
        const anggaran = document.getElementById('edit_anggaran');

        document.addEventListener('click', function(e){
            const btn = e.target.closest('[data-task-id]');
            if(!btn) return;

            const id = btn.getAttribute('data-task-id');
            const namaVal = btn.getAttribute('data-nama');
            const statusVal = btn.getAttribute('data-status');
            const anggaranVal = btn.getAttribute('data-anggaran');

            taskId.value = id;
            nama.value = namaVal;
            status.value = statusVal;
            anggaran.value = anggaranVal;

            // Set action URL
            form.action = '{{ url('/task') }}/' + id;
        });
    })();
</script>
@endsection

