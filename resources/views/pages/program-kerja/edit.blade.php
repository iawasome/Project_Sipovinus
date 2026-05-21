@extends('layouts.app')

@section('content')
<div class="grid grid-cols-12 gap-4 md:gap-6">
  <div class="col-span-12 md:col-span-8">
    <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
      <h2 class="mb-6 text-2xl font-bold text-gray-900 dark:text-white">Edit Program Kerja</h2>

      <form action="{{ route('program-kerja.update', $proker->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
          <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Program Kerja</label>
          <input type="text" name="name" value="{{ $proker->name }}"
                 class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none dark:border-gray-600 dark:bg-gray-800 dark:text-white">
        </div>

        <div class="mb-4">
          <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Status Program Kerja</label>
          <select name="status" required
                  class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-900 focus:border-blue-500 focus:outline-none dark:border-gray-600 dark:bg-gray-800 dark:text-white">
            <option value="pending" @selected($proker->status === 'pending')>pending</option>
            <option value="on_progress" @selected($proker->status === 'on_progress')>on_progress</option>
            <option value="completed" @selected($proker->status === 'completed')>completed</option>
          </select>
        </div>

        <div class="flex gap-4">
          <a href="{{ route('program-kerja.index') }}" class="inline-block rounded-lg bg-gray-300 px-4 py-2 text-gray-900 hover:bg-gray-400">
            Batal
          </a>
          <button type="submit" class="inline-block rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
            Simpan Perubahan
          </button>
        </div>

      </form>
    </div>
  </div>
</div>
@endsection
