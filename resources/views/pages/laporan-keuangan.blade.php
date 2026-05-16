@extends('layouts.app')

@section('content')
  <div class="grid grid-cols-12 gap-4 md:gap-6">
    <!-- Summary Cards -->
    <div class="col-span-12">
      <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 md:gap-6">
        <!-- Total Pemasukan -->
        <div
          class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6"
        >
          <div
            class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-xl dark:bg-blue-900/30"
          >
            <svg
              class="fill-blue-600 dark:fill-blue-400"
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path d="M12 3v18m9-9H3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
          </div>

          <div class="flex items-end justify-between mt-5">
            <div>
              <span class="text-sm text-gray-500 dark:text-gray-400">Total Pemasukan</span>
              <h4 class="mt-2 font-bold text-gray-800 text-title-sm dark:text-white/90">
                Rp {{ number_format((float)($total_pemasukan ?? 0), 0, ',', '.') }}
              </h4>
            </div>

            <span
              class="flex items-center gap-1 rounded-full bg-blue-50 py-0.5 pl-2 pr-2.5 text-sm font-medium text-blue-600 dark:bg-blue-500/15 dark:text-blue-400"
            >
              Income
            </span>
          </div>
        </div>

        <!-- Total Pengeluaran -->
        <div
          class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6"
        >
          <div
            class="flex items-center justify-center w-12 h-12 bg-error-100 rounded-xl dark:bg-error-900/30"
          >
            <svg
              class="fill-error-600 dark:fill-error-400"
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path d="M5 19h14M10 4h4l1 16H9l1-16Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>

          <div class="flex items-end justify-between mt-5">
            <div>
              <span class="text-sm text-gray-500 dark:text-gray-400">Total Pengeluaran</span>
              <h4 class="mt-2 font-bold text-gray-800 text-title-sm dark:text-white/90">
                Rp {{ number_format((float)($total_pengeluaran ?? 0), 0, ',', '.') }}
              </h4>
            </div>

            <span
              class="flex items-center gap-1 rounded-full bg-error-50 py-0.5 pl-2 pr-2.5 text-sm font-medium text-error-600 dark:bg-error-500/15 dark:text-error-500"
            >
              Expense
            </span>
          </div>
        </div>

        <!-- Sisa Saldo -->
        <div
          class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6"
        >
          <div
            class="flex items-center justify-center w-12 h-12 bg-success-100 rounded-xl dark:bg-success-900/30"
          >
            <svg
              class="fill-success-600 dark:fill-success-400"
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path d="M9 16.17 4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>

          <div class="flex items-end justify-between mt-5">
            <div>
              <span class="text-sm text-gray-500 dark:text-gray-400">Sisa Saldo</span>
              <h4 class="mt-2 font-bold text-gray-800 text-title-sm dark:text-white/90">
                Rp {{ number_format((float)($sisa_saldo ?? 0), 0, ',', '.') }}
              </h4>
            </div>

            <span
              class="flex items-center gap-1 rounded-full bg-success-50 py-0.5 pl-2 pr-2.5 text-sm font-medium text-success-600 dark:bg-success-500/15 dark:text-success-500"
            >
              Balance
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- Data Table -->
    <div class="col-span-12">
      <div class="mt-6 overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800">
          <div class="flex items-start justify-between gap-4">
            <div>
              <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Alokasi Anggaran per Proker</h3>
              <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Ringkasan pemasukan, pengeluaran, dan sisa per program kerja</p>
            </div>
          </div>
        </div>

        <div class="max-w-full overflow-x-auto custom-scrollbar">
          <table class="w-full">
            <thead>
              <tr class="border-b border-gray-200 dark:border-gray-800">
                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">Nama Proker</th>
                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">Divisi</th>
                <th class="px-6 py-4 text-right text-sm font-semibold text-gray-900 dark:text-white">Dana Dialokasikan</th>
                <th class="px-6 py-4 text-right text-sm font-semibold text-gray-900 dark:text-white">Dana Terpakai</th>
                <th class="px-6 py-4 text-right text-sm font-semibold text-gray-900 dark:text-white">Sisa Dana Proker</th>
              </tr>
            </thead>

            <tbody class="divide-y divide-gray-100 dark:divide-white/[0.05]">
              @forelse(($laporan_per_proker ?? []) as $row)
                <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02]">
                  <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">{{ $row['nama_proker'] }}</td>
                  <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $row['divisi'] ?? '-' }}</td>
                  <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-200 text-right">
                    Rp {{ number_format((float)($row['dana_dialokasikan'] ?? 0), 0, ',', '.') }}
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-200 text-right">
                    Rp {{ number_format((float)($row['dana_terpakai'] ?? 0), 0, ',', '.') }}
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-200 text-right">
                    Rp {{ number_format((float)($row['sisa_dana_proker'] ?? 0), 0, ',', '.') }}
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="px-6 py-10 text-center text-sm text-gray-500 dark:text-gray-400">
                    Belum ada data anggaran.
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection


