@extends('layouts.app')

@section('content')
  <div class="grid grid-cols-12 gap-4 md:gap-6">
    <!-- Statistic Cards (TailAdmin) -->
    <div class="col-span-12">
      <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 md:gap-6">
        <!-- Total Program Kerja -->
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
              <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z" fill="" />
            </svg>
          </div>

          <div class="flex items-end justify-between mt-5">
            <div>
              <span class="text-sm text-gray-500 dark:text-gray-400">Total Program Kerja</span>
              <h4 class="mt-2 font-bold text-gray-800 text-title-sm dark:text-white/90">
                {{ $data['total_proker'] ?? 0 }}
              </h4>
            </div>

            <span
              class="flex items-center gap-1 rounded-full bg-blue-50 py-0.5 pl-2 pr-2.5 text-sm font-medium text-blue-600 dark:bg-blue-500/15 dark:text-blue-400"
            >
              Proker
            </span>
          </div>
        </div>

        <!-- Program Kerja Selesai -->
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
              <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z" fill="" />
            </svg>
          </div>

          <div class="flex items-end justify-between mt-5">
            <div>
              <span class="text-sm text-gray-500 dark:text-gray-400">Program Kerja Selesai</span>
              <h4 class="mt-2 font-bold text-gray-800 text-title-sm dark:text-white/90">
                {{ $data['proker_selesai'] ?? 0 }}
              </h4>
            </div>

            <span
              class="flex items-center gap-1 rounded-full bg-success-50 py-0.5 pl-2 pr-2.5 text-sm font-medium text-success-600 dark:bg-success-500/15 dark:text-success-500"
            >
              Selesai
            </span>
          </div>
        </div>

        <!-- Program Kerja Berjalan -->
        <div
          class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6"
        >
          <div
            class="flex items-center justify-center w-12 h-12 bg-warning-100 rounded-xl dark:bg-warning-900/30"
          >
            <svg
              class="fill-warning-600 dark:fill-warning-400"
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm.75 14.25h-1.5v-1.5h1.5v1.5zm0-3h-1.5V7.5h1.5v5.75z" fill="" />
            </svg>
          </div>

          <div class="flex items-end justify-between mt-5">
            <div>
              <span class="text-sm text-gray-500 dark:text-gray-400">Program Kerja Berjalan</span>
              <h4 class="mt-2 font-bold text-gray-800 text-title-sm dark:text-white/90">
                {{ $data['proker_berjalan'] ?? 0 }}
              </h4>
            </div>

            <span
              class="flex items-center gap-1 rounded-full bg-warning-50 py-0.5 pl-2 pr-2.5 text-sm font-medium text-warning-600 dark:bg-warning-500/15 dark:text-warning-500"
            >
              Berjalan
            </span>
          </div>
        </div>

        <!-- Total Anggaran Keluar -->
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
              <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm1.07-7.75-.9.92c-.51.53-.64.94-.64 1.83h-2c0-1.2.21-1.81.89-2.5l1.17-1.2c.33-.34.53-.8.53-1.3 0-1-.8-1.8-1.8-1.8S8.6 6.5 8.6 7.5H6.6c0-2.1 1.7-3.8 3.8-3.8s3.8 1.7 3.8 3.8c0 .8-.31 1.56-.83 2.12z" fill="" />
            </svg>
          </div>

          <div class="flex items-end justify-between mt-5">
            <div>
              <span class="text-sm text-gray-500 dark:text-gray-400">Total Anggaran Keluar</span>
              <h4 class="mt-2 font-bold text-gray-800 text-title-sm dark:text-white/90">
                Rp {{ number_format($data['total_anggaran_keluar'] ?? 0, 0, ',', '.') }}
              </h4>
            </div>

            <span
              class="flex items-center gap-1 rounded-full bg-error-50 py-0.5 pl-2 pr-2.5 text-sm font-medium text-error-600 dark:bg-error-500/15 dark:text-error-500"
            >
              Rp
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- Recent Activities -->
    <div class="col-span-12">
      <div
        class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 pb-3 pt-4 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6"
      >
        <div class="flex flex-col gap-2 mb-4 sm:flex-row sm:items-center sm:justify-between">
          <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Recent Activities</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Daftar Program Kerja Terbaru</p>
          </div>
        </div>

        <div class="max-w-full overflow-x-auto custom-scrollbar">
          <table class="min-w-full">
            <thead>
              <tr class="border-t border-gray-100 dark:border-gray-800">
                <th class="py-3 text-left">
                  <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Program Kerja</p>
                </th>
                <th class="py-3 text-left">
                  <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Status</p>
                </th>
                <th class="py-3 text-left">
                  <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Divisi</p>
                </th>
              </tr>
            </thead>
            <tbody>
              @foreach(($prokers ?? []) as $proker)
                <tr class="border-t border-gray-100 dark:border-gray-800">
                  <td class="py-3 whitespace-nowrap">
                    <p class="font-medium text-gray-800 text-theme-sm dark:text-white/90">
                      {{ $proker->nama_program ?? $proker->name ?? '-' }}
                    </p>
                  </td>
                  <td class="py-3 whitespace-nowrap">
                    <span
                      class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700 dark:bg-white/[0.06] dark:text-gray-200"
                    >
                      {{ $proker->status ?? '-' }}
                    </span>
                  </td>
                  <td class="py-3 whitespace-nowrap">
                    <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                      {{ optional($proker->division ?? null)->name ?? '-' }}
                    </p>
                  </td>
                </tr>
              @endforeach

              @if(empty($prokers ?? []))
                <tr class="border-t border-gray-100 dark:border-gray-800">
                  <td class="py-3" colspan="3">
                    <p class="text-gray-500 text-theme-sm dark:text-gray-400">Belum ada aktivitas terbaru.</p>
                  </td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection
