@extends('layouts.app')

@section('content')
<div class="grid grid-cols-12 gap-4 md:gap-6">
  <div class="col-span-12 md:col-span-8">
    <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
      <h2 class="mb-6 text-2xl font-bold text-gray-900 dark:text-white">Tambah Program Kerja</h2>

      <form action="{{ route('program-kerja.store') }}" method="POST">
        @csrf

        <div class="mb-4">
          <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Program Kerja</label>
          <input
            type="text"
            name="name"
            value="{{ old('name') }}"
            required
            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none dark:border-gray-600 dark:bg-gray-800 dark:text-white"
          />
        </div>

        <div class="mb-4">
          <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Divisi</label>
          <select
            name="division_id"
            required
            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-900 focus:border-blue-500 focus:outline-none dark:border-gray-600 dark:bg-gray-800 dark:text-white"
          >
            <option value="" disabled {{ old('division_id') ? '' : 'selected' }}>Pilih Divisi</option>
            @foreach($divisions as $division)
              <option value="{{ $division->id }}" {{ (string) old('division_id') === (string) $division->id ? 'selected' : '' }}>
                {{ $division->name }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="mb-4">
          <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
          <select
            name="status"
            required
            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-900 focus:border-blue-500 focus:outline-none dark:border-gray-600 dark:bg-gray-800 dark:text-white"
          >
            <option value="" disabled {{ old('status') ? '' : 'selected' }}>Pilih Status</option>
            <option value="planning" {{ old('status') === 'planning' ? 'selected' : '' }}>Planning</option>
            <option value="on_progress" {{ old('status') === 'on_progress' ? 'selected' : '' }}>On Progress</option>
            <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>Completed</option>
          </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
          <div>
            <x-form.date-picker
              name="start_date"
              label="Start Date"
              placeholder="Pilih tanggal"
              :defaultDate="old('start_date')"
            />
          </div>

          <div>
            <x-form.date-picker
              name="end_date"
              label="End Date"
              placeholder="Pilih tanggal"
              :defaultDate="old('end_date')"
            />
          </div>
        </div>

        <div class="mb-6">
          <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Budget Estimate</label>
          <input
            type="number"
            name="budget_estimate"
            value="{{ old('budget_estimate') }}"
            required
            step="0.01"
            min="0"
            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none dark:border-gray-600 dark:bg-gray-800 dark:text-white"
          />
        </div>

        <div class="flex gap-4">
          <a href="{{ route('program-kerja.index') }}" class="inline-block rounded-lg bg-gray-300 px-4 py-2 text-gray-900 hover:bg-gray-400">
            Batal
          </a>
          <button type="submit" class="inline-block rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
            Simpan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
