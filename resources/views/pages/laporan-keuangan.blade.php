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
                <th class="px-6 py-4 text-right text-sm font-semibold text-gray-900 dark:text-white">AKSI</th>
              </tr>
            </thead>

            <tbody class="divide-y divide-gray-100 dark:divide-white/[0.05]">
              @forelse(($laporan_per_proker ?? []) as $row)
                @php
                  $prokerId = $row['id'] ?? ($loop->index ?? 0);
                  $transaksiIncome = $row['transaksi']['income'] ?? [];
                  $transaksiExpense = $row['transaksi']['expense'] ?? [];
                  $totalIncome = (float)($row['total_income'] ?? 0);
                  $totalExpense = (float)($row['total_expense'] ?? 0);
                  $sisaDanaProker = (float)($row['sisa_dana_proker'] ?? ($totalIncome - $totalExpense));
                @endphp

                <tr class="group hover:bg-gray-50 dark:hover:bg-white/[0.02]">
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
                  <td class="px-6 py-4 text-sm text-right">
                    <button
                      type="button"
                      class="detail-toggle inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-3 py-1.5 text-sm font-medium text-gray-800 shadow-sm transition hover:bg-gray-50 active:translate-y-[1px] dark:border-gray-800 dark:bg-white/[0.02] dark:text-white"
                      data-proker-target="detail-{{ $prokerId }}"
                      aria-expanded="false"
                    >
                      <span>Detail</span>
                      <svg class="detail-icon h-4 w-4 text-gray-500 transition-transform duration-200" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8 10l4 4 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                    </button>
                  </td>
                </tr>

                <tr id="{{ 'detail-' . $prokerId }}" class="detail-row" style="display:none;">
                  <td colspan="6" class="px-0 py-0">
                    <div class="detail-inner overflow-hidden m-4 max-h-0 opacity-0 rounded-2xl border border-gray-200 bg-white p-5 shadow-[max-height,opacity] duration-250 ease-out dark:border-gray-800 dark:bg-white/[0.03]">

                      <div class="flex flex-col gap-2 md:flex-row md:items-start md:justify-between">
                        <div>
                          <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Program</div>
                          <div class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">{{ $row['nama_proker'] }}</div>

                          <div class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                            Divisi: <span class="font-medium text-gray-900 dark:text-white">{{ $row['divisi'] ?? '-' }}</span>
                          </div>
                        </div>

                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                          <div class="rounded-xl border border-gray-100 bg-gray-50 p-3 dark:border-gray-800 dark:bg-white/[0.02]">
                            <div class="text-xs font-medium text-gray-500 dark:text-gray-400">Dana Dialokasikan</div>
                            <div class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">
                              Rp {{ number_format((float)($row['dana_dialokasikan'] ?? 0), 0, ',', '.') }}
                            </div>
                          </div>
                          <div class="rounded-xl border border-gray-100 bg-gray-50 p-3 dark:border-gray-800 dark:bg-white/[0.02]">
                            <div class="text-xs font-medium text-gray-500 dark:text-gray-400">Total Income</div>
                            <div class="mt-1 text-sm font-semibold text-success-600 dark:text-success-400">
                              Rp {{ number_format($totalIncome, 0, ',', '.') }}
                            </div>
                          </div>
                          <div class="rounded-xl border border-gray-100 bg-gray-50 p-3 dark:border-gray-800 dark:bg-white/[0.02]">
                            <div class="text-xs font-medium text-gray-500 dark:text-gray-400">Total Expense</div>
                            <div class="mt-1 text-sm font-semibold text-error-600 dark:text-error-400">
                              Rp {{ number_format($totalExpense, 0, ',', '.') }}
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="mt-5 grid grid-cols-1 gap-5">
                        <!-- UANG MASUK -->
                        <div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.02]">
                          <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-success-50 dark:bg-success-500/15">
                              <svg class="h-5 w-5 text-success-600 dark:text-success-400" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 3v18m9-9H3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                              </svg>
                            </div>
                            <div>
                              <div class="text-sm font-semibold text-success-700 dark:text-success-300">UANG MASUK</div>
                              <div class="text-xs text-gray-500 dark:text-gray-400">Transaksi income</div>
                            </div>
                          </div>

                          <div class="mt-3 overflow-x-auto">
                            <table class="w-full">
                              <thead>
                                <tr class="border-b border-gray-100 dark:border-gray-800">
                                  <th class="px-2 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300">Tanggal</th>
                                  <th class="px-2 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300">Keterangan</th>
                                  <th class="px-2 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-300">Nominal</th>
                                </tr>
                              </thead>
                              <tbody>
                                @forelse($transaksiIncome as $item)
                                  <tr class="border-b border-gray-50 dark:border-white/[0.02]">
                                    <td class="px-2 py-2 text-xs text-gray-700 dark:text-gray-200">{{ $item['tanggal'] ?? '-' }}</td>
                                    <td class="px-2 py-2 text-xs text-gray-700 dark:text-gray-200">{{ $item['description'] ?? '-' }}</td>
                                    <td class="px-2 py-2 text-right text-xs font-medium text-success-700 dark:text-success-300">
                                      Rp {{ number_format((float)($item['amount'] ?? 0), 0, ',', '.') }}
                                    </td>
                                  </tr>
                                @empty
                                  <tr>
                                    <td colspan="3" class="px-2 py-4 text-center text-xs text-gray-500 dark:text-gray-400">Belum ada pemasukan.</td>
                                  </tr>
                                @endforelse
                              </tbody>
                            </table>
                          </div>
                        </div>

                        <!-- UANG KELUAR -->
                        <div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.02]">
                          <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-error-50 dark:bg-error-500/15">
                              <svg class="h-5 w-5 text-error-600 dark:text-error-400" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 19h14M10 4h4l1 16H9l1-16Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                              </svg>
                            </div>
                            <div>
                              <div class="text-sm font-semibold text-error-700 dark:text-error-300">UANG KELUAR</div>
                              <div class="text-xs text-gray-500 dark:text-gray-400">Transaksi expense</div>
                            </div>
                          </div>

                          <div class="mt-3 overflow-x-auto">
                            <table class="w-full">
                              <thead>
                                <tr class="border-b border-gray-100 dark:border-gray-800">
                                  <th class="px-2 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300">Tanggal</th>
                                  <th class="px-2 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300">Keterangan</th>
                                  <th class="px-2 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-300">Nominal</th>
                                </tr>
                              </thead>
                              <tbody>
                                @forelse($transaksiExpense as $item)
                                  <tr class="border-b border-gray-50 dark:border-white/[0.02]">
                                    <td class="px-2 py-2 text-xs text-gray-700 dark:text-gray-200">{{ $item['tanggal'] ?? '-' }}</td>
                                    <td class="px-2 py-2 text-xs text-gray-700 dark:text-gray-200">{{ $item['description'] ?? '-' }}</td>
                                    <td class="px-2 py-2 text-right text-xs font-medium text-error-700 dark:text-error-300">
                                      Rp {{ number_format((float)($item['amount'] ?? 0), 0, ',', '.') }}
                                    </td>
                                  </tr>
                                @empty
                                  <tr>
                                    <td colspan="3" class="px-2 py-4 text-center text-xs text-gray-500 dark:text-gray-400">Belum ada pengeluaran.</td>
                                  </tr>
                                @endforelse
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>

                      <div class="mt-5 grid grid-cols-1 gap-3 sm:grid-cols-3">
                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-800 dark:bg-white/[0.02]">
                          <div class="text-xs font-semibold text-gray-500 dark:text-gray-400">Total Income</div>
                          <div class="mt-1 text-sm font-bold text-success-700 dark:text-success-300">
                            Rp {{ number_format($totalIncome, 0, ',', '.') }}
                          </div>
                        </div>
                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-800 dark:bg-white/[0.02]">
                          <div class="text-xs font-semibold text-gray-500 dark:text-gray-400">Total Expense</div>
                          <div class="mt-1 text-sm font-bold text-error-700 dark:text-error-300">
                            Rp {{ number_format($totalExpense, 0, ',', '.') }}
                          </div>
                        </div>
                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-800 dark:bg-white/[0.02]">
                          <div class="text-xs font-semibold text-gray-500 dark:text-gray-400">Sisa Dana</div>
                          <div class="mt-1 text-sm font-bold text-gray-900 dark:text-white">
                            Rp {{ number_format($sisaDanaProker, 0, ',', '.') }}
                          </div>
                        </div>
                      </div>
                    </div>
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

  <style>
    .detail-row{
      transition: max-height 250ms ease, opacity 200ms ease;
      will-change: max-height, opacity;
    }
  </style>

  <script>
    (function () {
      const toggles = document.querySelectorAll('.detail-toggle');
      if (!toggles.length) return;

      let activeId = null;

      function closeRow(row) {
        if (!row) return;
        row.style.display = 'none';

        const inner = row.querySelector('.detail-inner');
        const content = inner || row;

        if (content && typeof content.scrollHeight === 'number') {
          content.style.maxHeight = '0px';
          content.style.opacity = '0';
        }

        const btn = document.querySelector('[data-proker-target="' + row.id + '"]');
        if (btn) {
          btn.setAttribute('aria-expanded', 'false');
          const icon = btn.querySelector('.detail-icon');
          if (icon) icon.style.transform = 'rotate(0deg)';
        }
      }

      function openRow(row, btn) {
        if (!row) return;

        row.style.display = '';

        const inner = row.querySelector('.detail-inner');
        const content = inner || row;

        if (content) {
          const height = content.scrollHeight;
          content.style.maxHeight = height + 'px';
          content.style.opacity = '1';
        }

        if (btn) {
          btn.setAttribute('aria-expanded', 'true');
          const icon = btn.querySelector('.detail-icon');
          if (icon) icon.style.transform = 'rotate(180deg)';
        }
      }

      function toggle(btn) {
        const target = btn.getAttribute('data-proker-target');
        const row = document.getElementById(target);
        if (!row) return;

        // Only one open row at a time
        if (activeId && activeId !== target) {
          const prev = document.getElementById(activeId);
          closeRow(prev);
        }

        if (activeId === target) {
          closeRow(row);
          activeId = null;
          return;
        }

        // Open
        activeId = target;
        // Ensure initial collapsed state for animation
        const inner = row.querySelector('.detail-inner');
        const content = inner || row;
        if (content) {
          content.style.maxHeight = '0px';
          content.style.opacity = '0';
          // force reflow
          content.offsetHeight;
        }
        openRow(row, btn);
      }

      toggles.forEach(function (btn) {
        btn.addEventListener('click', function () {
          toggle(btn);
        });
      });
    })();
  </script>
@endsection



