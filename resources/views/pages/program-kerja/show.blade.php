@extends('layouts.app')

@section('content')
<div class="rounded-2xl border border-stroke bg-white p-4 dark:border-strokedark dark:bg-slate-900 text-black dark:text-white">
    <div class="flex flex-col gap-4">
        {{-- Header + Export PDF --}}
        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900 dark:text-white">Detail Proker</h1>
                <p class="text-sm text-slate-600 dark:text-slate-400">{{ $title ?? 'Program Kerja' }}</p>
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
            <div class="rounded-xl border border-stroke bg-white shadow-default dark:border-slate-800 dark:bg-slate-800/50 p-4">
                <p class="text-sm text-slate-500 dark:text-slate-400">Nama</p>
                <p class="mt-1 text-lg font-bold text-slate-900 dark:text-white">{{ $proker->name }}</p>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400 font-medium">Divisi: {{ $proker->division?->name }}</p>
            </div>

            {{-- Card 2: Dana Awal --}}
            <div class="rounded-xl border border-stroke bg-white shadow-default dark:border-slate-800 dark:bg-slate-800/50 p-4">
                <p class="text-sm text-slate-500 dark:text-slate-400">Dana Awal</p>
                <p class="mt-1 text-lg font-semibold text-slate-900 dark:text-white">
                    Rp {{ number_format($dana_dialokasikan, 2, ',', '.') }}
                </p>
            </div>

            {{-- Card 3: Dana Terpakai & Sisa Dana --}}
            <div class="rounded-xl border border-stroke bg-white shadow-default dark:border-slate-800 dark:bg-slate-800/50 p-4">
                <p class="text-sm text-slate-500 dark:text-slate-400">Dana Terpakai</p>
                <p class="mt-1 text-lg font-semibold text-slate-900 dark:text-white">
                    Rp {{ number_format($dana_terpakai, 2, ',', '.') }}
                </p>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                    Sisa Dana:
                    <span class="ml-1 font-bold text-emerald-600 dark:text-emerald-400">
                        Rp {{ number_format($sisa_dana, 2, ',', '.') }}
                    </span>
                </p>
            </div>
        </div>

        {{-- Section Daftar Task & Table --}}
        <div class="rounded-2xl border border-stroke bg-white dark:border-slate-800 dark:bg-slate-800/30 p-4">
            {{-- Table Header --}}
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Daftar Task</h2>

                <div class="sm:flex sm:items-center sm:justify-end">
                    <button
                        type="button"
                        id="btnAddTask"
                        class="inline-flex items-center justify-center bg-primary text-white hover:bg-opacity-90 font-medium rounded py-2 px-4 shadow-md transition"
                        onclick="document.getElementById('addTaskModal').classList.remove('hidden')"
                    >
                        <span>+ Tambah Task</span>
                    </button>
                </div>
            </div>

            <div class="mt-4 overflow-x-auto">
                <table class="w-full table-auto border-collapse">
                    <thead>
                        <tr class="border-b border-stroke dark:border-slate-700">
                            <th class="bg-slate-50 dark:bg-slate-800 text-left font-semibold text-slate-900 dark:text-white px-4 py-3">Nama Task</th>
                            <th class="bg-slate-50 dark:bg-slate-800 text-left font-semibold text-slate-900 dark:text-white px-4 py-3">Status</th>
                            <th class="bg-slate-50 dark:bg-slate-800 text-left font-semibold text-slate-900 dark:text-white px-4 py-3">Anggaran</th>
                            <th class="bg-slate-50 dark:bg-slate-800 text-left font-semibold text-slate-900 dark:text-white px-4 py-3">Due Date</th>
                            <th class="bg-slate-50 dark:bg-slate-800 text-right font-semibold text-slate-900 dark:text-white px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tasks as $task)
                            @php
                                $status = $task->status;
                                $badgeBase = 'inline-flex rounded-full bg-opacity-10 py-1 px-3 text-sm font-medium';
                                $badgeClass = match($status) {
                                    'completed' => 'bg-emerald-500 text-emerald-700 dark:bg-emerald-400/20 dark:text-emerald-300',
                                    'on_progress' => 'bg-amber-400 text-amber-800 dark:bg-amber-400/20 dark:text-amber-200',
                                    default => 'bg-slate-400 text-slate-700 dark:bg-slate-300/15 dark:text-slate-200',
                                };
                                $anggaran = $task->anggaran_digunakan ?? 0;

                                $formattedDate = '-';
                                if ($task->due_date) {
                                    $formattedDate = is_string($task->due_date) ? date('Y-m-d', strtotime($task->due_date)) : $task->due_date->format('Y-m-d');
                                }
                            @endphp

                            <tr class="border-t border-stroke dark:border-slate-700 hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition">
                                <td class="px-4 py-3 text-slate-900 dark:text-white font-medium">
                                    {{ $task->nama_task }}
                                </td>

                                <td class="px-4 py-3">
                                    <span class="{{ $badgeBase }} {{ $badgeClass }}">
                                        {{ $task->status }}
                                    </span>
                                </td>

                                <td class="px-4 py-3 text-right text-slate-900 dark:text-white font-mono">
                                    Rp {{ number_format($anggaran, 2, ',', '.') }}
                                </td>

                                <td class="px-4 py-3 text-slate-900 dark:text-white">
                                    {{ $formattedDate }}
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
                                        data-due-date="{{ $formattedDate }}"
                                    >
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
                                <td colspan="5" class="px-4 py-8 text-center text-slate-500 dark:text-slate-400">Belum ada task.</td>
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
        <div class="relative bg-white dark:bg-slate-900 border border-stroke dark:border-slate-800 rounded-lg shadow">
            <div class="sm:flex sm:items-center sm:justify-end">
                <button
                    type="button"
                    id="btnAddTask"
                    class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-medium rounded py-2 px-4 shadow-md transition"
                    onclick="document.getElementById('addTaskModal').classList.remove('hidden')"
                >
                    <span>+ Tambah Task</span>
                </button>
            </div>

            <form method="POST" action="{{ route('task.store', $proker->id) }}" class="p-4 md:p-5">
                @csrf

                <div class="mb-4.5">
                    <label class="mb-2.5 block text-slate-900 dark:text-white font-medium">Nama Task</label>
                    <input
                        name="nama_task"
                        type="text"
                        required
                        class="w-full rounded border border-stroke dark:border-slate-700 bg-transparent py-3 px-5 text-slate-900 dark:text-white outline-none transition focus:border-primary active:border-primary"
                        value="{{ old('nama_task') }}"
                    />
                </div>

                <div class="mb-4.5">
                    <label class="mb-2.5 block text-slate-900 dark:text-white font-medium">Status</label>
                    <select
                        name="status"
                        required
                        class="w-full rounded border border-stroke dark:border-slate-700 bg-transparent py-3 px-5 text-slate-900 dark:text-white outline-none transition focus:border-primary active:border-primary"
                    >
                        <option value="pending" @selected(old('status')==='pending')>pending</option>
                        <option value="on_progress" @selected(old('status')==='on_progress')>on_progress</option>
                        <option value="completed" @selected(old('status')==='completed')>completed</option>
                    </select>
                </div>

                <div class="mb-4.5">
                    <label class="mb-2.5 block text-slate-900 dark:text-white font-medium">Due Date</label>
                    <x-form.date-picker
                        name="due_date"
                        :default-date="old('due_date')"
                        placeholder="Pilih tanggal"
                    />
                </div>

                <div class="mb-4.5">
                    <label class="mb-2.5 block text-slate-900 dark:text-white font-medium">Anggaran</label>
                    <input
                        name="anggaran_digunakan"
                        type="number"
                        step="0.01"
                        min="0"
                        required
                        class="w-full rounded border border-stroke dark:border-slate-700 bg-transparent py-3 px-5 text-slate-900 dark:text-white outline-none transition focus:border-primary active:border-primary"
                        value="{{ old('anggaran_digunakan') }}"
                    />
                </div>

                <div class="flex justify-end gap-4.5 border-t border-stroke dark:border-slate-800 pt-4.5">
                    <button
                        type="button"
                        class="flex justify-center rounded border border-stroke py-2 px-6 font-medium text-slate-900 dark:text-white"
                        onclick="document.getElementById('addTaskModal').classList.add('hidden')"
                    >
                        Batal
                    </button>
                    <button type="submit" class="flex justify-center rounded bg-blue-600 hover:bg-blue-700 py-2 px-6 font-medium text-white transition shadow-md">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit Task --}}
<div id="editTaskModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-[calc(100%)] max-h-full">
    <div class="relative p-4 w-full max-w-lg max-h-full mx-auto">
        <div class="relative bg-white rounded-lg shadow dark:bg-slate-900 border border-stroke dark:border-slate-800">
            <div class="p-4 md:p-5 border-b rounded-t border-slate-200 dark:border-slate-800">
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Edit Task</h3>
            </div>

            <form id="editTaskForm" method="POST" class="p-4 md:p-5">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <input type="hidden" id="edit_task_id" />

                    <div>
                        <label class="block text-sm font-medium text-slate-900 dark:text-white">Nama Task</label>
                        <input id="edit_nama_task" name="nama_task" type="text" required class="w-full rounded border border-stroke dark:border-slate-700 bg-transparent py-2 px-4 outline-none text-slate-900 dark:text-white" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-900 dark:text-white">Status</label>
                        <select id="edit_status" name="status" class="w-full rounded border border-stroke dark:border-slate-700 bg-transparent py-2 px-4 outline-none text-slate-900 dark:text-white" required>
                            <option value="pending">pending</option>
                            <option value="on_progress">on_progress</option>
                            <option value="completed">completed</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-900 dark:text-white">Due Date</label>
                        <x-form.date-picker
                            name="due_date"
                            :default-date="''"
                            placeholder="Pilih tanggal"
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-900 dark:text-white">Anggaran Digunakan</label>
                        <input id="edit_anggaran" name="anggaran_digunakan" type="number" step="0.01" min="0" required class="w-full rounded border border-stroke dark:border-slate-700 bg-transparent py-2 px-4 outline-none text-slate-900 dark:text-white" />
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-2 border-t border-stroke dark:border-slate-800 pt-4">
                    <button type="button" class="flex justify-center rounded border border-stroke py-2 px-4 font-medium text-slate-900 dark:text-white" onclick="document.getElementById('editTaskModal').classList.add('hidden');">Batal</button>
                    <button type="submit" class="flex justify-center rounded bg-blue-600 hover:bg-blue-700 py-2 px-4 font-medium text-white transition shadow-md">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    (function(){
        const form = document.getElementById('editTaskForm');
        const taskId = document.getElementById('edit_task_id');
        const nama = document.getElementById('edit_nama_task');
        const status = document.getElementById('edit_status');
        const anggaran = document.getElementById('edit_anggaran');
        const modal = document.getElementById('editTaskModal');

        document.addEventListener('click', function(e){
            const btn = e.target.closest('[data-task-id]');
            if(!btn) return;

            const id = btn.getAttribute('data-task-id');
            const namaVal = btn.getAttribute('data-nama');
            const statusVal = btn.getAttribute('data-status');
            const anggaranVal = btn.getAttribute('data-anggaran');
            const dueDateVal = btn.getAttribute('data-due-date');

            taskId.value = id;
            nama.value = namaVal;
            status.value = statusVal;
            anggaran.value = anggaranVal;

            const dueDateInput = modal.querySelector('input[name="due_date"]');
            if(dueDateInput) {
                dueDateInput.value = dueDateVal || '';
                if(dueDateInput._flatpickr) {
                    dueDateInput._flatpickr.setDate(dueDateVal || '');
                }
            }

            form.action = '{{ url('/task') }}/' + id;

            modal?.classList.remove('hidden');
            modal?.classList.add('block');
        });
    })();
</script>
@endsection
