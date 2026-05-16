@extends('layouts.app')

@section('content')
  <div class="grid grid-cols-12 gap-4 md:gap-6">
    <div class="col-span-12 md:col-span-8">
      <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
        <h2 class="mb-6 text-2xl font-bold text-gray-900 dark:text-white">Tambah Transaksi Anggaran</h2>

        <form
          action="{{ route('anggaran.store') }}"
          method="POST"
          enctype="multipart/form-data"
        >
          @csrf

          <div class="mb-4">
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Program Kerja</label>
            <select
              name="program_id"
              class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none dark:border-gray-600 dark:bg-gray-800 dark:text-white"
            >
              <option value="" disabled selected>Pilih Program Kerja</option>
              @foreach($prokers ?? [] as $proker)
                <option value="{{ $proker->id }}" {{ old('program_id') == $proker->id ? 'selected' : '' }}>
                  {{ $proker->name }}
                </option>
              @endforeach
            </select>
            @error('program_id')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div class="mb-4">
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Amount</label>
            <input
              type="number"
              name="amount"
              value="{{ old('amount') }}"
              step="0.01"
              min="0"
              class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none dark:border-gray-600 dark:bg-gray-800 dark:text-white"
              placeholder="Masukkan nominal"
            >
            @error('amount')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div class="mb-4">
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Tipe</label>
            <select
              name="type"
              class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none dark:border-gray-600 dark:bg-gray-800 dark:text-white"
            >
              <option value="" disabled selected>Pilih tipe</option>
              <option value="income" {{ old('type') === 'income' ? 'selected' : '' }}>Income</option>
              <option value="expense" {{ old('type') === 'expense' ? 'selected' : '' }}>Expense</option>
            </select>
            @error('type')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div class="mb-6">
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Bukti Nota (Receipt)</label>
            <input
              type="file"
              name="receipt_path"
              accept="image/*,application/pdf"
              class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none dark:border-gray-600 dark:bg-gray-800 dark:text-white"
            >
            @error('receipt_path')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div class="flex gap-4">
            <a
              href="{{ url()->previous() }}"
              class="inline-block rounded-lg bg-gray-300 px-4 py-2 text-gray-900 hover:bg-gray-400"
            >
              Batal
            </a>
            <button
              type="submit"
              class="inline-block rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
            >
              Simpan Transaksi
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

