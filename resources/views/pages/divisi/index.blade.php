@extends('layouts.app')

@section('content')
<div class="grid grid-cols-12 gap-4 md:gap-6">
  <div class="col-span-12">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
      <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Manajemen Divisi</h1>
        <p class="text-gray-500 dark:text-gray-400">Kelola divisi di sistem</p>
      </div>

      @if($isAdmin)
        <a href="{{ route('manajemen-divisi.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 transition-colors">
          <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
          </svg>
          Tambah Divisi
        </a>
      @endif
    </div>

    <!-- Data Table -->
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead>
            <tr class="border-b border-gray-200 dark:border-gray-800">
              <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">No</th>
              <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">Nama Divisi</th>
              <th class="px-6 py-4 text-center text-sm font-semibold text-gray-900 dark:text-white">Aksi</th>
            </tr>
          </thead>

          <tbody>
            @forelse($divisions as $key => $division)
              <tr class="border-b border-gray-200 hover:bg-gray-50 dark:border-gray-800 dark:hover:bg-white/[0.02]">
                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                  {{ ($divisions->currentPage() - 1) * $divisions->perPage() + $key + 1 }}
                </td>
                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                  {{ $division->name }}
                </td>

                <td class="px-6 py-4">
                  @if($isAdmin)
                    <div class="flex items-center justify-center gap-2">
                      <!-- Edit -->
                      <a href="{{ route('manajemen-divisi.edit', $division->id) }}"
                         class="inline-flex items-center justify-center rounded-lg bg-blue-100 p-2 text-blue-600 hover:bg-blue-200 transition-colors dark:bg-blue-900/30 dark:text-blue-400 dark:hover:bg-blue-900/50"
                         title="Edit">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                      </a>

                      <!-- Delete -->
                      <form action="{{ route('manajemen-divisi.destroy', $division->id) }}" method="POST" class="inline"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus divisi ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center justify-center rounded-lg bg-red-100 p-2 text-red-600 hover:bg-red-200 transition-colors dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-900/50"
                                title="Hapus">
                          <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                          </svg>
                        </button>
                      </form>
                    </div>
                  @else
                    <span class="text-gray-400 dark:text-gray-500 text-sm">—</span>
                  @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="3" class="px-6 py-10 text-center text-sm text-gray-500 dark:text-gray-400">
                  Tidak ada data divisi
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      @if($divisions->hasPages())
        <div class="flex items-center justify-between border-t border-gray-200 px-6 py-4 dark:border-gray-800">
          <div class="text-sm text-gray-600 dark:text-gray-400">
            Menampilkan {{ $divisions->firstItem() ?? 0 }} - {{ $divisions->lastItem() ?? 0 }} dari {{ $divisions->total() }} data
          </div>
          <div class="flex items-center gap-2">
            {{ $divisions->links() }}
          </div>
        </div>
      @endif
    </div>
  </div>
</div>
@endsection

