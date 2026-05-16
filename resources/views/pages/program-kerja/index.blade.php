@extends('layouts.app')

@section('content')
<div class="grid grid-cols-12 gap-4 md:gap-6">
  <div class="col-span-12">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
      <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Daftar Program Kerja</h1>
        <p class="text-gray-500 dark:text-gray-400">Kelola semua program kerja di sini</p>
      </div>
      <a href="{{ route('program-kerja.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 transition-colors">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Tambah Program Kerja
      </a>
    </div>

    <!-- Data Table -->
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="overflow-x-auto">
        <table class="w-full">

          <thead>
            <tr class="border-b border-gray-200 dark:border-gray-800">
              <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">No</th>
              <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">Nama Program Kerja</th>
              <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">Divisi</th>
              <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">Progres</th>
              <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">Status</th>
              <th class="px-6 py-4 text-center text-sm font-semibold text-gray-900 dark:text-white">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($prokers as $key => $proker)
            <tr class="border-b border-gray-200 hover:bg-gray-50 dark:border-gray-800 dark:hover:bg-white/[0.02]">
              <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                {{ ($prokers->currentPage() - 1) * $prokers->perPage() + $key + 1 }}
              </td>
<td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                <a href="{{ route('program-kerja.show', $proker->id) }}" class="hover:underline">
                  {{ $proker->name }}
                </a>
              </td>

              <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                {{ $proker->division?->name ?? '-' }}
              </td>
              <td class="px-6 py-4 text-sm">
                <x-progress-bar :progress="$proker->progress" />
              </td>
              <td class="px-6 py-4 text-sm">
                <x-status-badge :status="$proker->status" />
              </td>
              <td class="px-6 py-4">
                <div class="flex items-center justify-center gap-2">
                  <!-- Edit Button -->
                  <a href="{{ route('program-kerja.edit', $proker->id) }}"
                     class="inline-flex items-center justify-center rounded-lg bg-blue-100 p-2 text-blue-600 hover:bg-blue-200 transition-colors dark:bg-blue-900/30 dark:text-blue-400 dark:hover:bg-blue-900/50"
                     title="Edit">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                  </a>

                  <!-- Export PDF Button -->
                  <a href="{{ route('program-kerja.export-pdf', $proker->id) }}"
                     class="inline-flex items-center justify-center rounded-lg bg-green-100 p-2 text-green-600 hover:bg-green-200 transition-colors dark:bg-green-900/30 dark:text-green-400 dark:hover:bg-green-900/50"
                     title="Export PDF">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                  </a>

                  <!-- Delete Button -->
                  <form action="{{ route('program-kerja.destroy', $proker->id) }}" method="POST"
                        class="inline"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus?')">
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
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                Tidak ada data Program Kerja
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      @if($prokers->hasPages())
      <div class="flex items-center justify-between border-t border-gray-200 px-6 py-4 dark:border-gray-800">
        <div class="text-sm text-gray-600 dark:text-gray-400">
          Menampilkan {{ $prokers->firstItem() ?? 0 }} - {{ $prokers->lastItem() ?? 0 }} dari {{ $prokers->total() }} data
        </div>
        <div class="flex items-center gap-2">
          {{ $prokers->links() }}
        </div>
      </div>
      @endif
    </div>
  </div>
</div>
@endsection
